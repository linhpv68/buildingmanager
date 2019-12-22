<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 27/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\RoomDevice;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use mysql_xdevapi\Exception;

class Delete extends Action
{
    protected $_pageFactory;

    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\RoomDevice');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage("Bạn đã xóa thành công");

            } catch (\Exception $e) {
                $message = __('Lỗi! bạn vui lòng kiểm tra lại. Eg: kiểm tra ràng buộc');
                $this->messageManager->addErrorMessage($message);
//                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('buildingmanager/roomdevice/index');
        return $this->_pageFactory->create();
        // TODO: Implement execute() method.
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::roomdevice');
    }

}