<?php
namespace Ambab\EMI\Model\ResourceModel\Allemi;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'emi_id';
	
	protected $_eventPrefix = 'emi_allemi_collection';

    protected $_eventObject = 'allemi_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('Ambab\EMI\Model\Allemi', 'Ambab\EMI\Model\ResourceModel\Allemi');
	}
}
?>
