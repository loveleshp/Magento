<?php

namespace Ambab\EMI\Controller\Adminhtml\Allemi;

use Magento\Backend\App\Action;
use Ambab\EMI\Model\Allemi;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Ambab\EMI\Model\AllemiFactory
     */
    private $allemiFactory;

    /**
     * @var \Ambab\EMI\Api\AllemiRepositoryInterface
     */
    private $allemiRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \Ambab\EMI\Model\AllemiFactory $allemiFactory
     * @param \Ambab\EMI\Api\AllemiRepositoryInterface $allemiRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Ambab\EMI\Model\AllemiFactory $allemiFactory = null,
        \Ambab\EMI\Api\AllemiRepositoryInterface $allemiRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->allemiFactory = $allemiFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Ambab\EMI\Model\AllemiFactory::class);
        $this->allemiRepository = $allemiRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Ambab\EMI\Api\AllemiRepositoryInterface::class);
        parent::__construct($context);
    }
	
    protected $resultPageFactory;

     /* @see _isAllowed()
     */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMI::save');
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Allemi::STATUS_ENABLED;
            }
            if (empty($data['emi_id'])) {
                $data['emi_id'] = null;
            }

            /** @var \Ambab\EMI\Model\Allemi $model */
            $model = $this->allemiFactory->create();

            $id = $this->getRequest()->getParam('emi_id');
            if ($id) {
                try {
                    $model = $this->allemiRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This emi no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'emi_allemi_prepare_save',
                ['allemi' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allemiRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the emi.'));
                $this->dataPersistor->clear('emi_allemi');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('emi/allemi/index', ['emi_id' => $model->getEMI_Id(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            }//  catch (\Exception $e) {
            //     $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the emi.'));
            // }

            $this->dataPersistor->set('emi_allemi', $data);
            return $resultRedirect->setPath('*/*/edit', ['emi_id' => $this->getRequest()->getParam('emi_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
?>
