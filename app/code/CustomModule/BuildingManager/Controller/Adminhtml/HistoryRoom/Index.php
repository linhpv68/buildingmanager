<?php
/**
 * cms-nckh - Index.php
 *
 * Initial version by: linhphung
 * Initial version create on : 24/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\HistoryRoom;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
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
        $result->getConfig()->getTitle()->prepend(__("Thông tin Lịch sử"));
        $result->getConfig()->getTitle()->set(__('Quản lý công trình'));
        return $result;
        // TODO: Implement execute() method.
    }
}