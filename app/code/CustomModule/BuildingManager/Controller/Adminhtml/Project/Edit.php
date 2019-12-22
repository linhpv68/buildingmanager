<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 11/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Project;



use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{

    protected $_pageFactory;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
    }

    public function execute()
    {

        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Sửa thông tin'));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $params = $this->getRequest()->getParams();
        if (isset($params['name'])) {
            if (isset($params['image'])) {
                $params['image'] = $params['image'][0]['url'];
            }
            if (isset($params['ImageList'])) {
                $imageList ="";
                $sizeImageList = sizeof($params['ImageList']);
                foreach ($params['ImageList'] as $key => $value){
                    if ($key == $sizeImageList-1){
                        $imageList = $imageList.$value['url'];
                    }else{
                        $imageList = $imageList.$value['url'].",";
                    }
                }
                $params['ImageList'] = $imageList;
            }
            try {
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\Project');
                $model->setData($params);
                $model->save();
                $this->messageManager->addSuccessMessage("Bạn đã sửa thành công");
                $this->_redirect('buildingmanager/project/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addErrorMessage(__("Sửa không thành công"));
                $this->_redirect('buildingmanager/project/edit');
            }


        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

}