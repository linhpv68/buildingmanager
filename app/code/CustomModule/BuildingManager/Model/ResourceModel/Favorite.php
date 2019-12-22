<?php


namespace CustomModule\BuildingManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Favorite extends AbstractDb
{

    public function _construct()
    {
        $this->_init('custom_module_favorite', 'id');
    }
}