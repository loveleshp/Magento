<?php
namespace Ambab\EMI\Controller\Adminhtml\Allemi;

class Delete extends \Magento\Backend\App\Action
{

    protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMI::emi_delete');
	}

    public function execute()
    {
        $id = $this->getRequest()->getParam('emi_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if($id){
            $bank_name="";
            try{
                $model= $this->_objectManager->create(\Ambab\EMI\Model\Allemi::class);
                $model->load($id);
                $bank_name= $model->getBank_Name();
                $model->delete();
                $this->messageManager->addSuccess(__('The emi has been delete.'));
                $this->_eventManager->dispatch('adminhtml_emi_on_delete',['bank_name'=> $bank_name,'status'=> 'success']);
                return $resultRedirect->setPath('*/*/');
            }catch(\Exception $e){
                $this->_eventManager->dispatch('adminhtml_emi_on_delete',['bank_name'=>$bank_name,'status'=>'fail']);
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit',['emi_id'=> $id]);
            }
        }
        $this->messageManager->addError(_('We cant delete'));
        return $resultRedirect-> setPath('*/*/');
    }
}