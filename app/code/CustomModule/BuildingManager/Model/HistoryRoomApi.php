<?php
/**
 * cms-nckh - HistoryRoomApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 15/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Api\Data\HistoryRoomInterface;
use CustomModule\BuildingManager\Api\HistoryRoomManagementInterface;
use CustomModule\BuildingManager\Model\ResourceModel\HistoryRoom\CollectionFactory;
use CustomModule\BuildingManager\Model\HistoryRoomFactory;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use CustomModule\BuildingManager\Model\UserFactory;
use CustomModule\BuildingManager\Model\ResourceModel\UserRoom\CollectionFactory as UserRoomFactory;

class HistoryRoomApi implements HistoryRoomManagementInterface
{
    protected $_collectionFactory;
    protected $tokenModelFactory;
    protected $historyRoomFactory;
    protected $_userFactory;
    protected $_userRoomFactory;

    /**
     * HistoryRoomApi constructor.
     * @param CollectionFactory $collectionFactory
     * @param TokenModelFactory $tokenModelFactory
     * @param \CustomModule\BuildingManager\Model\HistoryRoomFactory $historyRoomFactory
     * @param UserFactory $userFactory
     * @param UserRoomFactory $userRoomFactory
     */
    public function __construct(CollectionFactory $collectionFactory,
                                TokenModelFactory $tokenModelFactory,
                                HistoryRoomFactory $historyRoomFactory,
                                UserFactory $userFactory,
                                UserRoomFactory $userRoomFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->historyRoomFactory = $historyRoomFactory;
        $this->_userFactory = $userFactory;
        $this->_userRoomFactory = $userRoomFactory;

    }

    /**
     * @param string $roomId
     * @return mixed
     */
    public function getByRoomId($roomId)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        $data = $this->_collectionFactory->create()->addFieldToFilter('roomId', $roomId);
        $data = $data->getData();
        foreach ($data as $key => $value) {
            if (isset($value['userID'])) {
                $fullName = $this->_userFactory->create()->load($value['userID'])->getFullname();
                if ($fullName){
                    $data[$key]['userID'] = $fullName;
                }
            }
        }
        if ($data) {
            $totalResult = sizeof($data);
            $result["success"] = array(
                "success" => true,
                "total" => $totalResult
            );
            $result["data"] = $data;
        }
        //return $result;
        return $result;
        // TODO: Implement getByRoomId() method.
    }


    /**
     * @param string $roomId
     * @param string $dateCreate
     * @param string $token
     * @param string $content
     * @return mixed
     */
    public function saveData($roomId, $dateCreate, $token, $content)
    {
        $data = array(
            "datecreate" => $dateCreate,
            "roomID" => $roomId,
            "token" => $token,
            "content" => $content
        );
        $result = array(
            "success" => false,
            "data" => ""
        );

        $token = $this->tokenModelFactory->create()->loadByToken($token)->getData();
        if ($token) {
            $userId = $token['customer_id'];
            unset($data["token"]);
            $data["userID"] = $userId;
            // Check User ID by Room Id
            $listRoom = $this->_userRoomFactory->create()->addFieldToFilter('userID',$userId)->addFieldToFilter('roomID',$data['roomID'])->getData();
            if ($listRoom){
                $model = $this->saveDataHistoryRoom($data);
                if ($model) {
                    $result["data"] = array(
                        "message" => "Add History room unsuccessful."//$model//
                    );
                } else {
                    $result["success"] = true;
                    $result["data"] = array(
                        "message" => "Add History room successfully."
                    );
                }
            }else{
                $result["success"] = false;
                $result["data"] = array(
                    "message" => "This user does not use that room or it room do not exist"
                );
            }



        } else {
            $result["data"] = array(
                "message" => "You must to login."
            );
        }
        // TODO: Implement saveData() method.
        return $result;
//        return $result;
    }


    public function saveDataHistoryRoom($data)
    {
        try {
            $model = $this->historyRoomFactory->create()->setData($data);
            $model->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}