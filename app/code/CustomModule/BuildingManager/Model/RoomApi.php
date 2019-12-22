<?php
/**
 * cms-nckh - RoomApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 13/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Api\RoomManagementInterface;
use CustomModule\BuildingManager\Model\ResourceModel\Room\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;

class RoomApi implements RoomManagementInterface
{
    protected $_collectionFactory;
    protected $context;
    protected $_resource;
    private $tokenModelFactory;

    public function __construct(CollectionFactory $collectionFactory,
                                \Magento\Framework\App\Action\Context $context,
                                TokenModelFactory $tokenModelFactory,
                                ResourceConnection $resource)
    {
        $this->_collectionFactory = $collectionFactory;
        $this->context = $context;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->_resource = $resource;

    }

    /**
     * @param string $projectId
     * @return mixed|void
     */
    public function getByProject($projectId)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        $data = $this->_collectionFactory->create()->addFieldToFilter('projectId', $projectId)->getData();
        if ($data) {
            $result["success"] = true;
            $result["data"] = $data;
        }
        return $result;
        // TODO: Implement view() method.
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getByUser($token)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );

        $data = $this->tokenModelFactory->create()->loadByToken($token)->getData();

        if ($data) {
            $listRoom = $this->getRoomByCustomerId($data['customer_id']);
            $result["success"] = true;
            $result["data"] = $listRoom;
        } else {
            $messenger = "Customer not Login";
            $result["data"] = array(
                "messenger"=>$messenger
            );
        }

        return $result;

        // TODO: Implement getByUser() method.
    }

    public function getRoomByCustomerId($customerId)
    {
        $collection = $this->getJoinData()->addFieldToFilter('userID', $customerId)->getData();
        return $collection;
    }

    public function getJoinData()
    {
        $collection = $this->_collectionFactory->create();
        $second_table_name = $this->_resource->getTableName('custom_module_user_room');

        $collection->getSelect()->joinLeft(
            array('custom_module_user_room' => $second_table_name),
            'main_table.id = custom_module_user_room.roomID',
            ['custom_module_user_room.userID AS userID']
        );

        return $collection;

    }


}