<?php
/**
 * cms-nckh - Index.php
 *
 * Initial version by: linhphung
 * Initial version create on : 23/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Device;


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

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Quản lý thiết bị"));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        return $resultPage;
        // TODO: Implement execute() method.
    }

}