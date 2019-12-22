<?php
/**
 * cms-nckh - Dashboard.php
 *
 * Initial version by: linhphung
 * Initial version create on : 23/08/2019
 *
 */

namespace CustomModule\BuildingManager\Block\Adminhtml;

use Magento\Backend\Block\Template;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory as User;
use CustomModule\BuildingManager\Model\ResourceModel\Room\CollectionFactory as Room;
use CustomModule\BuildingManager\Model\ResourceModel\Project\CollectionFactory as Project;
use CustomModule\BuildingManager\Model\ResourceModel\Model\CollectionFactory as Model;
use CustomModule\BuildingManager\Model\ResourceModel\Device\CollectionFactory as Device;

class Dashboard extends Template
{
    protected $_collectionUser;
    protected $_collectionRoom;
    protected $_collectionProject;
    protected $_collectionModel;
    protected $_collectionDevice;

    public function __construct(Template\Context $context, array $data = [],
                                User $collectionUser,
                                Room $collectionRoom,
                                Project $collectionProject,
                                Model $collectionModel,
                                Device $collectionDevice)
    {
        $this->_collectionUser = $collectionUser;
        $this->_collectionRoom = $collectionRoom;
        $this->_collectionProject = $collectionProject;
        $this->_collectionModel = $collectionModel;
        $this->_collectionDevice = $collectionDevice;

        parent::__construct($context, $data);
    }

    public function CountRecord()
    {
        $user = $this->_collectionUser->create()->getData();
        $room = $this->_collectionRoom->create()->getData();
        $project = $this->_collectionProject->create()->getData();
        $model = $this->_collectionModel->create()->getData();
        $device = $this->_collectionDevice->create()->getData();
        $total = array(
            'user'=>sizeof($user),
            'room'=>sizeof($room),
            'project'=>sizeof($project),
            'model'=>sizeof($model),
            'device'=>sizeof($device),
        );

        return $total;

    }


}