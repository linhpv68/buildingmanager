<?php
/**
 * cms-nckh - DeviceApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 10/09/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Model\ResourceModel\Device\CollectionFactory;
use CustomModule\BuildingManager\Api\DeviceManagementInterface;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use CustomModule\BuildingManager\Model\DeviceFactory;
use PHPUnit\Runner\Exception;

class DeviceApi implements DeviceManagementInterface
{
    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;
    protected $collectionFactory;
    protected $_deviceFactory;

    public function __construct(CollectionFactory $collectionFactory,
                                TokenModelFactory $tokenModelFactory,
                                DeviceFactory $deviceFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->_deviceFactory = $deviceFactory;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );

        $data = $this->collectionFactory->create()->addFieldToFilter("id", $id)->getData();
        if ($data) {
            $result["data"] = $data;
            $result["success"] = true;
        }
        return $result;
        // TODO: Implement getById() method.
    }

    /**
     * @param string $token
     * @param mixed $data
     * @return mixed
     */
    public function updateByAdmin($token, $data)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        // check user admin
        $checkToken = $this->tokenModelFactory->create()->loadByToken($token)->getData();
        if ($checkToken && $checkToken['admin_id']){
            //update device
            $model = $this->_deviceFactory->create();
            try{
                $model->setData($data);
                $model->save();
                $result['success'] = true;
                $result['data'] = "Bạn đã thay đổi thành công!";
            }catch (Exception $exception){
                $result['data'] = $exception->getMessage();
            }


        }else{
            $result['data'] = "Chỉ có tài khoản admin mới có thể thay đổi!";

        }

        return $result;
        // TODO: Implement updateByAdmin() method.
    }
}