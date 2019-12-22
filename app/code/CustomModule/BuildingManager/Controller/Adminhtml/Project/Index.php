<?php
/**
 * cms-nckh - Index.php
 *
 * Initial version by: linhphung
 * Initial version create on : 11/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Project;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
class Index extends Action
{
    protected $_pageFactory;
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory= $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Thông tin Công trình/Dự án'));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        return $resultPage;
        // TODO: Implement execute() method.
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::project');
    }

}