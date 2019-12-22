<?php
/**
 * cms-nckh - Model.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Model\DataProvider;


use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use CustomModule\BuildingManager\Model\ResourceModel\Model\CollectionFactory;
class Model extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $storeManager;

    /**
     * HistoryRoom constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct($name,
                                $primaryFieldName,
                                $requestFieldName,
                                StoreManagerInterface $storeManager,
                                CollectionFactory $collectionFactory,
                                array $meta = [],
                                array $data = [])
    {
        $this->storeManager = $storeManager;
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
        $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'buildingmanager/files/';
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $itemData = $item->getData();
            if (isset($itemData['source'])) {
                $name = $itemData['source'];
                $url =  $path.$itemData['source'];
                unset($itemData['source']);
                $itemData['source'][0]['name'] = $name;
                $itemData['source'][0]['url'] = $url;
            }
            $this->_loadedData[$item->getId()] = $itemData;
        }
        return $this->_loadedData;
    }

}