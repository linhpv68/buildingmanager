<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\User;


use Magento\Backend\App\Action;
use Magento\Setup\Exception;

class Delete extends Action
{
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $hotelCollection = $this->_objectManager->create('CustomModule\BuildingManager\Model\User')->load($id);
                $hotelCollection->delete();
                $this->messageManager->addSuccess(__('Bạn đã xóa thành công'));
            } catch (\Exception $exception) {
                $message = __('Lỗi! Hiện người dùng này đang có "Tài khoản căn hộ" Hoặc "Lịch sử sửa chữa căn hộ". Vui lòng kiểm tra lại.');
                $this->messageManager->addErrorMessage($message);
            }
        }

        $this->_redirect('buildingmanager/user/index');

    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::user');
    }
}