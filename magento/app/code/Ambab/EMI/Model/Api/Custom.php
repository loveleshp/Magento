<?php
 
namespace Ambab\EMI\Model\Api;
 
use Psr\Log\LoggerInterface;
use \Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
 
class Custom
{
    protected $logger;
    protected $order;
    protected $productRepository;
    protected $_storeManager;

 
    public function __construct(
        LoggerInterface $logger,
        OrderRepositoryInterface $order,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storemanager
    )
    {
 
        $this->logger = $logger;
        $this->order = $order;
        $this->productRepository = $productRepository;
        $this->_storeManager =  $storemanager;
    }
 
    /**
     * @inheritdoc
     */
 
    public function getPost($id)
    {
        // $response = ['success' => false];
 
        try {
            $i = 0;
            $orderdetails = [];
            $order_p = $this->order->get($id);
            $orderdetails['Order_no'] = $order_p->getEntityId();

            foreach($order_p->getAllItems() as $item){

                $productID =$orderdetails['Order_ID'] = $item->getId();
                $orderdetails['items'][$i]['Name'] = $item->getName();
                $orderdetails['items'][$i]['Qty'] = $item->getQtyOrdered();
                $orderdetails['items'][$i]['Price'] = $item->getOriginalPrice(); 
                $orderdetails['items'][$i]['Sppecial_Price'] = $item->getPrice();
                $orderdetails['items'][$i]['Discount_Price'] = $item->getDiscountAmount(); 
                $productId = $orderdetails['items'][$i]['product_id'] = $item->getProductId();

               // Get Image url
                $product = $this->productRepository->getById($productId);
                $store = $this->_storeManager->getStore();
                $orderdetails['items'][$i]['image_url'] = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product'.$product->getImage();
                $i++;
            }
               // Get shipping info
               $orderdetails['Shipping_Address'] = $order_p->getShippingAddress()->getData();
               $orderdetails['Shipping_Method'] = $order_p->getShippingMethod();
               $orderdetails['Shipping_Amount'] = $order_p->getShippingAmount();

                  // Get payment method
               $orderdetails['Payment_Method'] = $order_p->getPayment()->getMethod();

            $response = ['success' => 'Order info successfull', 'message' => $orderdetails];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $response; 
    }
}