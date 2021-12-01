<?php

namespace Ambab\EMI\Controller\Adminhtml\Allemi;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
	/**
     * Authorization level
     *
     * @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMI::save');
	}

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Allemi
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allemi $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ambab_EMI::emi_allemi')
            ->addBreadcrumb(__('EMI'), __('EMI'))
            ->addBreadcrumb(__('Manage All EMI'), __('Manage All EMI'));
        return $resultPage;
    }

    /**
     * Edit Allnews
     *
     * @return \Magento\Backend\Model\View\Result\Allemi|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('emi_id');
        $model = $this->_objectManager->create(\Ambab\EMI\Model\Allemi::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getEMI_Id()) {
                $this->messageManager->addError(__('This emi no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('emi_allemi', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allemi $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit EMI') : __('Add EMI'),
            $id ? __('Edit EMI') : __('Add EMI')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Allemi'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getEMI_Id() ? $model->getTitle() : __('Add EMI'));

        return $resultPage;
    }
}