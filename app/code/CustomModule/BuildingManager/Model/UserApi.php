<?php
/**
 * cms-nckh - UserApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;


use CustomModule\BuildingManager\Api\Data\UserInterface;
use CustomModule\BuildingManager\Api\UserManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Model\CredentialsValidator;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;
use CustomModule\BuildingManager\Model\ResourceModel\UserFactory;

use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use phpDocumentor\Reflection\Types\Object_;

use Magento\User\Model\ResourceModel\User\CollectionFactory as AdminUserCollection;

class UserApi implements UserManagementInterface
{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */

    CONST ACC_ADMIN = 'admin@gmail.com';
    CONST PASS_ADMIN = 'admin@123';

    protected $_objectManager;

    private $validatorHelper;
    private $_collectionFactory;
    private $adminUser;

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    private $_resource;
    private $_userFactory;

    /**
     * UserApi constructor.
     * @param CredentialsValidator $validatorHelper
     * @param CollectionFactory $collectionFactory
     * @param TokenModelFactory $tokenModelFactory
     * @param AdminUserCollection $adminUser
     * @param ResourceConnection $resource
     * @param UserFactory $userFactory
     * @param Context $context
     */
    public function __construct(CredentialsValidator $validatorHelper,
                                CollectionFactory $collectionFactory,
                                TokenModelFactory $tokenModelFactory,
                                AdminUserCollection $adminUser,
                                ResourceConnection $resource,
                                UserFactory $userFactory,
                                Context $context)
    {
        $this->_collectionFactory = $collectionFactory;
        $this->validatorHelper = $validatorHelper;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->_resource = $resource;
        $this->_userFactory = $userFactory;
        $this->_objectManager = $context->getObjectManager();
        $this->adminUser = $adminUser;
    }


    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        //$this->validatorHelper->validate($email, $password);
        $collection = $this->getJoinData();
        $selectField = array('id', 'fullname', 'email');
        $data = $collection->addFieldToFilter('email', $email)
            ->addFieldToFilter('password', md5($password))->addFieldToSelect($selectField)
            ->getFirstItem()->getData();
        if ($data) {
            try{
                $token = $this->tokenModelFactory->create()->createCustomerToken($data['id'])->getToken();
                $data['token'] = $token;
                $result['success'] = true;
                $result["data"] = $data;
            }catch (\Exception $e){
                $result["data"] = $e->getMessage();
            }
           
        } elseif ($email == self::ACC_ADMIN && $password == self::PASS_ADMIN) {
            $selectField = array('user_id', 'lastname','firstname', 'email');
            $data = $this->adminUser->create()->addFieldToFilter('email', $email)->addFieldToSelect($selectField)
                ->getFirstItem()->getData();
            if ($data){
                $token = $this->tokenModelFactory->create()->createAdminToken($data['user_id'])->getToken();
                $data['token'] = $token;
                $result['success'] = true;
                $result["data"] = $data;
            }

        }
        // TODO: Implement login() method.
        return $result;
    }

    public function getJoinData()
    {
        $collection = $this->_collectionFactory->create();
        $second_table_name = $this->_resource->getTableName('custom_module_user_room');

        $collection->getSelect()->joinLeft(
            array('custom_module_user_room' => $second_table_name),
            'main_table.id = custom_module_user_room.userID',
            ['custom_module_user_room.roomID AS roomID']
        );

        return $collection;

    }

    /**
     * @param string $tokenes
     * @param string $password
     * @param string $new_password
     * @return mixed
     */
    public function changePassword($tokenes, $password, $new_password)
    {
        $result = array(
            "success" => false,
            "data" => ''
        );

        //check token => getId customer =>get password =>check pass =>change pass
        $token = $this->tokenModelFactory->create()->loadByToken($tokenes)->getData();
        if ($token) {
            $idUser = $token['customer_id'];
            //Get password user
            $passUser = $this->_collectionFactory->create()->addFieldToFilter('id', $idUser)->getFirstItem()->getPassword();
            if (md5($password) == $passUser) {
                //change pass
                $return = $this->changePass($idUser, $new_password);
                $result['data'] = $return;
                $result['success'] = true;
            } else {
                $result['data'] = 'mật khẩu sai';
            }

        } else {
            $result['data'] = 'Xác thực không đúng';
        }

        return $result;
        // TODO: Implement changePassword() method.
    }

    private function changePass($idUser, $new_password)
    {
        $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\User');

        try {
            $model->setData(array('id' => $idUser, 'password' => md5($new_password)));
            $model->save();
            return 'Thay đổi mật khẩu thành công';

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}