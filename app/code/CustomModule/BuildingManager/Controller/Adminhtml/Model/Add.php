<?php
/**
 * cms-nckh - Add.php
 *
 * Initial version by: linhphung
 * Initial version create on : 01/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Model;


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
        $resultPage->getConfig()->getTitle()->prepend(__("Thêm Mới"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['name'])) {
            if (isset($params['source'])){
                $params['source'] = $params['source'][0]['name'];
            }
            try {
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Model');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage("Bạn đã thêm thành công");
                $this->_redirect('buildingmanager/model/add');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_redirect('buildingmanager/model/add');
            }


        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

}