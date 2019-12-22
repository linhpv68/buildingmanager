<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 25/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\HistoryRoom;


use Magento\Backend\App\Action;

class Delete extends Action
{
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $history = $this->_objectManager->create('CustomModule\BuildingManager\Model\HistoryRoom')->load($id);
            $history->delete();
            $this->messageManager->addSuccess(__('Bạn đã xóa thành công.'));
        } catch (\Exception $e) {
            $message = __('Lỗi! bạn vui lòng kiểm tra lại. Eg: kiểm tra ràng buộc');
            $this->messageManager->addErrorMessage($message);
           // $this->messageManager->addErrorMessage($e->getMessage());
        }
        $this->_redirect('buildingmanager/historyroom/index');

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::historyroom');
    }
}