<?php
/**
 * cms-nckh - Device.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Model\DataProvider;


use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

use CustomModule\BuildingManager\Model\ResourceModel\Device\CollectionFactory;
class Device extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $storeManager;

    /**
     * HistoryRoom constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct($name,
                                $primaryFieldName,
                                $requestFieldName,
                                CollectionFactory $collectionFactory,
                                StoreManagerInterface $storeManager,
                                array $meta = [],
                                array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
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
        $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'buildingmanager/files/';
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $itemData = $item->getData();
            if (isset($itemData['user_guide'])) {
                $name = $itemData['user_guide'];
                $url =  $path.$itemData['user_guide'];
                unset($itemData['user_guide']);
                $itemData['user_guide'][0]['name'] = $name;
                $itemData['user_guide'][0]['url'] = $url;
            }
            $this->_loadedData[$item->getId()] = $itemData;
            //$this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }

}