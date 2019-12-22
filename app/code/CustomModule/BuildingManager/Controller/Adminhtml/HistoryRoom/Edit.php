<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 26/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\HistoryRoom;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use mysql_xdevapi\Exception;

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
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\HistoryRoom');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__("Bạn đã sửa thành công"));
            }catch (\Exception $e){
                $this->messageManager->addErrorMessage($e->getMessage());
            }
            $this->_redirect('buildingmanager/historyroom/index');
        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

}