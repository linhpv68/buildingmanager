<?php
/**
 * cms-nckh - Project.php
 *
 * Initial version by: linhphung
 * Initial version create on : 20/08/2019
 *
 */

namespace CustomModule\BuildingManager\Model\DataProvider;


use Magento\Ui\DataProvider\AbstractDataProvider;
use CustomModule\BuildingManager\Model\ResourceModel\Project\CollectionFactory;

class Project extends AbstractDataProvider
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
            $itemData = $item->getData();
            if (isset($itemData['image'])) {
                unset($itemData['image']);

                $image = explode('/',$item->getData('image'));
                $size = sizeof($image);
                $image = $image[ $size-1];
                $url = $item->getData('image');
                $itemData['image'][0]['name'] = $image;
                $itemData['image'][0]['url'] = $url;
            }

            if (isset($itemData['ImageList'])){
                unset($itemData['ImageList']);
                $ImageList =  explode(',',$item->getData('ImageList'));
                $i = 0;
                foreach ($ImageList as $value){
                    $image = explode('/',$value);
                    $size = sizeof($image);
                    $image = $image[ $size-1];
                    $url = $value;
                    $itemData['ImageList'][$i]['name'] = $image;
                    $itemData['ImageList'][$i]['url'] = $url;
                    $i +=1;
                }
            }
            $this->_loadedData[$item->getId()] = $itemData;
        }
        return $this->_loadedData;
    }

}