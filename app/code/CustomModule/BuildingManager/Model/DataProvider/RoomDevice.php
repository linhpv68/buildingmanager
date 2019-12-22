<?php
/**
 * cms-nckh - RoomDevice.php
 *
 * Initial version by: linhphung
 * Initial version create on : 27/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\DataProvider;


use CustomModule\BuildingManager\Model\ResourceModel\RoomDevice\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class RoomDevice extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;

    /**
     * HistoryRoom constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct($name,
                                $primaryFieldName,
                                $requestFieldName,
                                CollectionFactory $collectionFactory,
                                array $meta = [],
                                array $data = [])
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }

}