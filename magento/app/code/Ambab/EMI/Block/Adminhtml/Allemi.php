<?php
namespace Ambab\EMI\Block\Adminhtml;

class Allemi extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_allemi';
        $this->_blockGroup = 'Ambab_EMI';
        $this->_headerText = __('Manage EMI');

        parent::_construct();

        if ($this->_isAllowedAction('Ambab_EMI::save')) {
            $this->buttonList->update('add', 'label', __('Add EMI'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
?>
