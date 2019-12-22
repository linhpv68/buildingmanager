<?php


namespace CustomModule\BuildingManager\Model\ResourceModel\Favorite;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'custom_module_favorite_collection';
    protected $_eventObject = 'custom_module_favorite_collection';

    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $model = 'CustomModule\BuildingManager\Model\Favorite';
        $srcModel = 'CustomModule\BuildingManager\Model\ResourceModel\Favorite';
        $this->_init($model, $srcModel);
    }

}