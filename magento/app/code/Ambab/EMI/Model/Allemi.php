<?php
namespace Ambab\EMI\Model;

use Ambab\EMI\Api\Data\AllemiInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Allemi extends AbstractModel implements AllemiInterface, IdentityInterface
{
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;

	const CACHE_TAG = 'emi';

	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;

	protected function _construct()
	{
		$this->_init('Ambab\EMI\Model\ResourceModel\Allemi');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getEMI_Id()];
	}

	public function getDefaultValues()
	{
		$values = [];
		return $values;
	}

	public function getAvailableStatuses()
	{
		return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
	}

	public function getEMI_Id()
	{
		return parent::getData(self::EMI_ID);
	}

	public function getBank_Name()
	{
		return $this->getData(self::Bank_Name);
	}

	public function getEMI_Plan()
	{
		return $this->getData(self::EMI_Plan);
	}

	public function getInterest_Rate()
	{
		return $this->getData(self::Interest_Rate);
	}

	public function setEMI_Id($emi_id)
	{
		return $this->setData(self::EMI_ID, $emi_id);
	}

	public function setBank_Name($bank_name)
	{
		return $this->setData(self::Bank_Name, $bank_name);
	}

	public function setEMI_Plan($emi_plan)
	{
		return $this->setData(self::EMI_Plan, $emi_plan);
	}

	public function setInterest_Rate($interest_rate)
	{
		return $this->setData(self::Interest_Rate, $interest_rate);
	}

}
?>
