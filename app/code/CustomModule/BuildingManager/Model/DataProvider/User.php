<?php
/**
 * cms-nckh - User.phpnitial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;

class User extends AbstractDataProvider
{

    protected $_loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,

        array $meta = [],
        array $data = []
    )
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
            $itemData['re-password'] = 123456;
            $itemData['new-password'] = 123456;
            $this->_loadedData[$item->getId()] = $itemData;

            //$this->_loadedData[$user->getId()] = $user->getData();
        }
        /*if (!$items){
            $itemData['re-password'] = 123456;
            $itemData['new-password'] = 123456;
            $itemData['id_field_name'] = "id";
            $itemData['fullname'] = "";
            $itemData['email'] = "";
            $itemData['phonenumber'] = "";
            $itemData['status'] = "0";
            $itemData['orig_data'] = null;
            $this->_loadedData[1] = $itemData;
        }*/

        return $this->_loadedData;
    }

}