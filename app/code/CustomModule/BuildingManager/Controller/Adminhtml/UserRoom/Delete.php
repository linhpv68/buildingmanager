<?php
/**
 * cms-nckh - Delete.php
 *
 * Initial version by: linhphung
 * Initial version create on : 28/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\UserRoom;


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
            $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\UserRoom')->load($id);
            try{
                $model->delete();

                $this->messageManager->addSuccess(__('Bạn đã xóa thành công'));
            }catch (\Exception $e){
                $message = __('Lỗi! bạn vui lòng kiểm tra lại. Eg: kiểm tra ràng buộc');
                $this->messageManager->addErrorMessage($message);
//                $this->messageManager->addErrorMessage($e);
            }


            $this->_redirect('buildingmanager/userroom/index');
        }
        // TODO: Implement execute() method.
    }

}