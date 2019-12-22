<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Device;


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
            $hotelCollection = $this->_objectManager->create('CustomModule\BuildingManager\Model\Device')->load($id);
            $hotelCollection->delete();
            $this->messageManager->addSuccess(__('Bạn đã xóa thành công'));
        } catch (\Exception $e) {
            $message = __('Lỗi! Hiện Thiêt bị này đang có Căn hộ sử dụng. Vui lòng kiểm tra lại.');
            $this->messageManager->addErrorMessage($message);
//            $this->messageManager->addErrorMessage(__("Bạn đã không xóa thành công"));
        }
        $this->_redirect('buildingmanager/device/index');

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::device');
    }
}