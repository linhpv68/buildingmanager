<?php
/**
 * cms-nckh - Add.php
 *
 * Initial version by: linhphung
 * Initial version create on : 28/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\UserRoom;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Add extends Action
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
        $resultPage->getConfig()->getTitle()->prepend(__("Tài khoản căn hộ"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['userID'])) {
            try {
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\UserRoom');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Bạn đã thêm thành công"));


            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e));
            }
            $this->_redirect("buildingmanager/userroom/add");
        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

}