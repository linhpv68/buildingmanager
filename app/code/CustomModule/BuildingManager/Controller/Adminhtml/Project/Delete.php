<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 11/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Project;

use CustomModule\BuildingManager\Model\ResourceModel\Project\CollectionFactory;
use Magento\Backend\App\Action;

class Delete extends Action
{
    protected $_projectCollection;
   public function __construct(Action\Context $context, CollectionFactory $collectionFactory)
   {
       $this->_projectCollection = $collectionFactory;
       parent::__construct($context);
   }

    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
        if (isset($id)){
            try {
                $history = $this->_objectManager->create('CustomModule\BuildingManager\Model\Project')->load($id);
                $history->delete();
                $this->messageManager->addSuccess(__('Bạn đã xóa thành công.'));
            } catch (\Exception $e) {
                $message = __('Lỗi! Hiện dự án/công trình này đang có căn hộ. Vui lòng kiểm tra lại');
                $this->messageManager->addErrorMessage($message);
            }
        }
        $this->_redirect('buildingmanager/project/index');
        // TODO: Implement execute() method.
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::project');
    }
}