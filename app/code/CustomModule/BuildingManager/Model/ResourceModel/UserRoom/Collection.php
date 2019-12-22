<?php
/**
 * cms-nckh - Collection.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\ResourceModel\UserRoom;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'custom_module_user_room_collection';
    protected $_eventObject = 'custom_module_user_room_collection';

    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $model = 'CustomModule\BuildingManager\Model\UserRoom';
        $srcModel = 'CustomModule\BuildingManager\Model\ResourceModel\UserRoom';
        $this->_init($model, $srcModel);
    }

}