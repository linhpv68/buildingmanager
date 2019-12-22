<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 02/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Room;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

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
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Room');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess("Bạn đã xóa thành công");

            } catch (\Exception $e) {
                $message = __('Lỗi! bạn vui lòng kiểm tra lại. Eg: kiểm tra ràng buộc');
                $this->messageManager->addErrorMessage($message);
                //$this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('buildingmanager/room/index');
        return $this->_pageFactory->create();
        // TODO: Implement execute() method.
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::room');
    }

}