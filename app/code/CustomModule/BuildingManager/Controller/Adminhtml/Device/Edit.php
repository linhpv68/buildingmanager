<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Device;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\View\Result\PageFactory;
use CustomModule\BuildingManager\Model\DeviceFactory;

class Edit extends Action
{
    protected $_pageFactory;
    protected $_deviceFactory;
    protected $_filesystem;
    protected $_file;

    public function __construct(Action\Context $context,
                                PageFactory $pageFactory,
                                DeviceFactory $deviceFactory,
                                Filesystem $_filesystem,
                                File $file)
    {
        $this->_pageFactory = $pageFactory;
        $this->_deviceFactory = $deviceFactory;
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Sửa"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['type'])) {
            if (isset($params['user_guide'])) {
                if (isset($params['user_guide'][0])) {
                    $params['user_guide'] = $params['user_guide'][0]['name'];
                }
            }else{
                $params['user_guide'] = "";
            }
            try {
                // Get the old source file name.
                $OldSource = $this->_deviceFactory->create()->load($params['id'])->getData('user_guide');
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Device');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage("Bạn đã sửa thành công");
                if (isset($OldSource)) {
                    $this->RemoveFileOld($OldSource, $params['user_guide']);
                }
                $this->_redirect('buildingmanager/device/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_redirect('buildingmanager/device/index');
            }


        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

    public function RemoveFileOld($fileOld, $fileNew)
    {
        if ($fileOld != $fileNew && $fileOld != null) {
            $mediaRootDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
            $mediaRootDir = $mediaRootDir.'buildingmanager/files/';
            if ($this->_file->isExists($mediaRootDir . $fileOld)) {
                try{
                    $this->_file->deleteFile($mediaRootDir . $fileOld);
                    // $this->getMessageManager()->addSuccessMessage(__('Bạn đã xóa file thành công'));
                }
                catch (\Exception $exception){
                    $this->getMessageManager()->addErrorMessage(__('Xóa File cũ không thành công'));
                }
            }
        }
    }

}