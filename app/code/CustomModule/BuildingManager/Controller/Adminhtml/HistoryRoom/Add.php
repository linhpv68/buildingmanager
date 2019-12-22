<?php
/**
 * cms-nckh - Add.php
 *
 * Initial version by: linhphung
 * Initial version create on : 25/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\HistoryRoom;


use Exception;
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
        $params = $this->getRequest()->getParams();
        if (isset($params['datecreate'])){
            $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\HistoryRoom');
            try{
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage(__('Bạn đã thêm thành công'));
            }catch (Exception $e){
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
            $this->_redirect('buildingmanager/historyroom/add');
        }
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Thêm mới"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        return $resultPage;
        // TODO: Implement execute() method.
    }

}