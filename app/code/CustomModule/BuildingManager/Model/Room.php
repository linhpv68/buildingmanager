<?php
/**
 * cms-nckh - Room.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;


use Magento\Framework\Model\AbstractModel;

class Room extends AbstractModel
{

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('CustomModule\BuildingManager\Model\ResourceModel\Room');

    }
}