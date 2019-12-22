<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 28/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\UserRoom;


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
        $result = $this->_pageFactory->create();
        $result->getConfig()->getTitle()->prepend(__("Sửa thông tin"));
        $result->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['userID'])) {
            try {
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\UserRoom');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Bạn đã sửa thành công"));


            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
            $this->_redirect("buildingmanager/userroom/index");
        }
        return $result;
        // TODO: Implement execute() method.
    }

}