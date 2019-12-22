<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Model;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\View\Result\PageFactory;
use CustomModule\BuildingManager\Model\ModelFactory;
use mysql_xdevapi\Exception;

class Edit extends Action
{
    protected $_pageFactory;
    protected $_modelFactory;
    protected $_filesystem;
    protected $_file;


    public function __construct(Action\Context $context,
                                PageFactory $pageFactory,
                                ModelFactory $modelFactory,
                                Filesystem $_filesystem,
                                File $file)
    {
        $this->_pageFactory = $pageFactory;
        $this->_modelFactory = $modelFactory;
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Sửa Thông tin"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['name'])) {
            if ($params['source']) {
                if (isset($params['source'][0])) {
                    $params['source'] = $params['source'][0]['name'];
                }
            }else{
                $params['source'] = "";
            }
            try {
                // Get the old source file name.
                $OldSource = $this->_modelFactory->create()->load($params['id'])->getData('source');
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Model');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Bạn đã sửa thành công"));
                if (isset($OldSource)) {
                    $this->RemoveFileOld($OldSource, $params['source']);
                }
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
            $this->_redirect('buildingmanager/model/index');
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