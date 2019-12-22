<?php
/**
 * cms-nckh - UnFile.php
 *
 * Initial version by: linhphung
 * Initial version create on : 18/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Upload;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use mysql_xdevapi\Exception;

class UnFile extends Action
{

    protected $_filesystem;
    protected $_file;

    public function __construct(
        Context $context,
        Filesystem $_filesystem,
        File $file
    )
    {
        parent::__construct($context);
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $method = $this->getRequest()->getParam('method');
        switch ($method){
            case 'device':
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Device')->load($id);
                $fileName = $model->getData('user_guide');
                $field = array(
                    'fieldName'=>'user_guide',
                    'id'=>$id
                );
                $this->remoteFile($fileName,$model,$field);
                $this->_redirect('buildingmanager/device/index');
                break;
            case 'model':
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Model')->load($id);
                $fileName = $model->getData('source');
                $field = array(
                    'fieldName'=>'source',
                    'id'=>$id
                );
                $this->remoteFile($fileName,$model,$field);
                $this->_redirect('buildingmanager/model/index');
                break;
        }



    }

    public function remoteFile($fileName,$model,$field){
        if ($fileName){
            $mediaRootDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
            $mediaRootDir = $mediaRootDir.'buildingmanager/files/';
            if ($this->_file->isExists($mediaRootDir . $fileName)) {
                try{
                    $this->_file->deleteFile($mediaRootDir . $fileName);
                    //Delete
                    $data = array($field['fieldName']=>"",'id'=>$field['id']);
                    $model->setData($data);
                    $model->save();
                    $this->getMessageManager()->addSuccessMessage(__('Bạn đã xóa file thành công'));

                }
                catch (Exception $exception){
                    $this->getMessageManager()->addErrorMessage(__('Xóa không thành công'));
                }
            }
            // other logic codes
        }
    }
}