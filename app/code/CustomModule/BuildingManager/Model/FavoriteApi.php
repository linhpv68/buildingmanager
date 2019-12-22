<?php


namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Api\FavoriteManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use CustomModule\BuildingManager\Model\ResourceModel\Favorite\CollectionFactory;


class FavoriteApi implements FavoriteManagementInterface
{

    private $tokenModelFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    protected $_collectionFactory;

    protected $_resource;

    /**
     * FavoriteApi constructor.
     * @param TokenModelFactory $tokenModelFactory
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param ResourceConnection $resource
     */
    public function __construct(TokenModelFactory $tokenModelFactory,
                                Context $context,
                                CollectionFactory $collectionFactory,
                                ResourceConnection $resource)
    {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_objectManager = $context->getObjectManager();
        $this->_resource = $resource;

    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id)
    {
        $result = array(
            "success" => false,
            "data" => ''
        );

        if ($id) {

        } else {
            $result['data'] = 'Id không đúng';
        }

        return $result;
        // TODO: Implement getById() method.
    }


    /**
     * @return mixed
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param string $token
     * @param string $idProject
     * @return mixed
     */
    public function add($token, $idProject)
    {
        $result = array(
            "success" => false,
            "data" => ''
        );
        //Check token
        $token = $this->tokenModelFactory->create()->loadByToken($token)->getData();
        //return user after check token
        if ($token && $idProject) {
            $idUser = $token['customer_id'];
            //add favorite
            $return = $this->addFavorite($idUser, $idProject);
            $result['data'] = $return;
            $result['success'] = true;
        } else {
            if (!$token) {
                $result['data'] = 'Xác thực không đúng';
            } elseif (!$idProject) {
                $result['data'] = 'Mã dự án không đúng';
            }

        }
        //return result
        return $result;
        // TODO: Implement add() method.
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getByUser($token)
    {
        $result = array(
            "success" => false,
            "data" => $token
        );

        //Check token
        $token = $this->tokenModelFactory->create()->loadByToken($token)->getData();

        if ($token) {
            //get id_user by token
            $idUser = $token['customer_id'];
            //get list favorite with id_user
            $listFavorite = $this->getJoinData()->addFieldToFilter('id_user', $idUser)->getData();
           // $listFavorite = $this->_collectionFactory->create()->addFieldToFilter('id_user', $idUser)->getData();
            $result["data"] = $listFavorite;
            if ($listFavorite) {
                $result["success"] = true;
                $result["data"] = $listFavorite;
            }
        } else {
            $result['data'] = 'Xác thực không đúng';
        }


        return $result;
    }

    private function addFavorite($idUser, $idProject)
    {
        $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Favorite');

        try {
            $date = date('m/d/Y', time());
            $model->setData(array('id_user' => $idUser, 'id_project' => $idProject, 'datecreate' => $date));
            $model->save();
            return 'Thêm Favorite thành công';

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function getJoinData()
    {
        $collection = $this->_collectionFactory->create();
        $second_table_name = $this->_resource->getTableName('custom_module_project');

        $collection->getSelect()->join(
            array('custom_module_project' => $second_table_name),
            'main_table.id_project = custom_module_project.id',
            array(
                'id_project'=>'custom_module_project.id',
                'name_project'=>'custom_module_project.name',
                'address_project'=>'custom_module_project.address',
                'image_project'=>'custom_module_project.image',
                'ImageList_project'=>'custom_module_project.ImageList',
                'Lat_project'=>'custom_module_project.Lat',
                'Lng_project'=>'custom_module_project.Lng',
                'investor_project'=>'custom_module_project.investor',
                'email_project'=>'custom_module_project.email',
                'phonenumber_project'=>'custom_module_project.phonenumber',
                'website_project'=>'custom_module_project.website',
                'description_project'=>'custom_module_project.description',
                'modelId_project'=>'custom_module_project.modelId'
            )
        );
        return $collection;

    }
}