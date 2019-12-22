<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 27/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\RoomDevice;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
class Edit extends Action
{
    protected $_pageFactory;
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Sửa"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['roomID'])){
            try{
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\RoomDevice');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Bạn đã sửa thành công"));
            }
            catch (\Exception $exception){
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
            $this->_redirect('buildingmanager/roomdevice/index');
        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::roomdevice');
    }

}