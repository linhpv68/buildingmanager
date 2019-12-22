<?php
/**
 * cms-nckh - HistoryRoom.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class HistoryRoom extends AbstractDb
{

    public function _construct()
    {
        $this->_init('custom_module_history_room', 'id');
    }

}