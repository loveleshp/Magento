<?php
namespace Ambab\EMI\Model\Allemi;

use Ambab\EMI\Model\ResourceModel\Allemi\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Ambab\EMI\Model\ResourceModel\Allnews\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $allemiCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $allemiCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $allemiCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $emi \Ambab\EMI\Model\Allemi */
        foreach ($items as $emi) {
            $this->loadedData[$emi->getEMI_Id()] = $emi->getData();
        }

        $data = $this->dataPersistor->get('emi_allemi');
        if (!empty($data)) {
            $emi = $this->collection->getNewEmptyItem();
            $emi->setData($data);
            $this->loadedData[$emi->getEMI_Id()] = $emi->getData();
            $this->dataPersistor->clear('emi_allemi');
        }

        return $this->loadedData;
    }
}