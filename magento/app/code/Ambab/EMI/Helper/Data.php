<?php
namespace Ambab\EMI\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper 
{
    public function getModuleConfig()
	{
		return $this->scopeConfig->getValue('Ambab_EMI/general/enable', ScopeInterface::SCOPE_STORE);
	}

}
?>