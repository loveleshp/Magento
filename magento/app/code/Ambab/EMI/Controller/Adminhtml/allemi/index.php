<?php

namespace Ambab\EMI\Controller\Adminhtml\allemi;

class Index extends \Magento\Backend\App\Action
{
    // /**
    //  * @var \Magento\Backend\Model\View\Result\PageFactory
    //  */
    
    protected $resultPageFactory;
    

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
        
        
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
      
        
    }
    
    protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMI::emi_allemi');
	}

    /**
     * Catalog categories index action
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        // echo $this->helperData->getGeneralConfig('enable');
		// exit();
        // $allemi = $this->allemiFactory->create();
		// $emiCollection = $allemi->getCollection();
		
		// echo '<pre>';print_r($emiCollection->getData());
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add EMI'));
        return $resultPage;
        
    }
}

