<?php
namespace Ambab\EMI\Block\Catalog\Product;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
use Ambab\EMI\Model\AllemiFactory;

class View extends AbstractProduct
{
    protected $_product;
    protected $helper;
    protected $_allemiFactory;
    protected $registry;
    protected $ordertotal;
    protected $json;
    

    public function __construct(Context $context, 
    array $data = [],
    \Ambab\EMI\Helper\Data $helperData,
    \Magento\Framework\Registry $registry,
    AllemiFactory $allemiFactory,
    \Magento\Checkout\Model\Cart $ordertotal,
    \Magento\Framework\Serialize\Serializer\Json $json
    )
    {   
        $this->helper = $helperData;
        $this->_allemiFactory = $allemiFactory;
        $this->registry = $registry;
        $this->ordertotal = $ordertotal;
        $this->json = $json;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();

        // $emi = $this->getEMI();
    }

    public function isEnable()
    {
        return $this->helper->getModuleConfig();
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    // public function getPriceById($id)
    // {
    //     $id =  700;//Product ID
    //     $product = $this->productFactory->create();
    //     $productPriceById = $product->load($id)->getPrice();
    //     return $productPriceById;
    // }

    public function getCollection(){
        return $this->_allemiFactory->create()->getCollection();
    }

    // public function getEMI()
	// {
	// 	$emi_id = $this->getRequest()->getParam('emi_id');
	// 	$emi = $this->_allemiFactory->create()->load($emi_id);
		
	// 	return $emi;
	// }

    public function getProductPrize()
    {
        $_product = $this->getProduct();
        $productprice = $_product->getFinalPrice(); 
        return $productprice;
    }
    
    public function getEMI_Plan($emi_id)
	{
		$emiData = $this->_allemiFactory->create();
		$collection = $emiData->getCollection()
				->addFieldToFilter('emi_id', array('Like' => $emi_id))
				->load();
		
		return $collection;
	}

    public function getEMI_Detail($bank_name)
	{
		$bankName = $this->_allemiFactory->create();
		$collection = $bankName->getCollection()
				->addFieldToFilter('bank_name', array('Like' => $bank_name))
                ->setOrder('emi_plan', 'asc')
                ->load();

		return $collection;
	}

    public function getEMI($Price, $interest_rate, $emi_plan)
    {   
        $interest_rate = $interest_rate / (12 * 100); 
        $emi = ($Price * $interest_rate * pow(1 + $interest_rate, $emi_plan)) /  
        (pow(1 + $interest_rate, $emi_plan) - 1); 

        return ($emi); 
    }
        
    public function getBank()
	{
		$bank = $this->_allemiFactory->create();
		$collection = $bank->getCollection()
				->distinct(true)
				->addFieldToSelect('bank_name')
				->load();

        // $jsonData = json_encode($collection->getData());       
        // print_r($jsonData); exit;
		
		return $collection;
	}

    public function getOrdertotal()
    {
        return $this->ordertotal->getQuote()->getGrandTotal();
    }

    public function getJsonCollection()
    {
        $Data=[];
        foreach($this->getBank() as $b)
        {
          $Data['getBk'][]= $b['bank_name'];
          $Bankn = $b['bank_name'];
        
        foreach($this->getEMI_Detail($Bankn) as $bn ){
            $Data['Interest'][$bn['bank_name']]['interest_rate'][] = $bn['interest_rate'];
            $Data['Plan'][$bn['bank_name']]['emi_plan'][] = $bn['emi_plan'];
        }
    }
        echo json_encode($Data); exit;
    }
}
?>