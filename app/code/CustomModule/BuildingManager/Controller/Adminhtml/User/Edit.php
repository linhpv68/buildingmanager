<?php
/**
 * cms-nckh - Edit.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\User;


use Magento\Backend\App\Action;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\View\Result\PageFactory;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;
use Magento\Setup\Exception;

class Edit extends Action
{
    protected $_pageFactory;
    protected $_collectionFactory;
    /**
     * @var Encryptor
     */
    private $encryptor;

    public function __construct(Action\Context $context,
                                PageFactory $pageFactory,
                                Encryptor $encryptor,
                                \CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory $collectionFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->encryptor = $encryptor;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $resultPage = $this->_pageFactory->create();
        $request = $this->getRequest()->getParams();
        $resultPage->getConfig()->getTitle()->prepend(__('Sửa thông tin'));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));
        $user = $this->_collectionFactory->create()->addFieldToFilter('id', $request['id'])->getFirstItem() ->getData();

        if (!empty($request) && isset($request['fullname'])){

            if ($request['new-password'] ==  $request['re-password']){
                $request['password'] = md5($request['new-password']);
                $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\User');
                try{
                    $model->setData($request);
                    $model->save();
                    $this->messageManager->addSuccessMessage(__('Bạn đã sửa thành công'));
                    $this->_redirect('buildingmanager/user/index');
                }catch (\Exception $exception){
                    $this->messageManager->addErrorMessage(__($exception));
                    $this->_redirect('buildingmanager/user/edit/id/'.$request['id']);
                }

            }
            else{
                $this->messageManager->addErrorMessage(__('Mật khẩu và Xác nhận Mật khẩu không trùng khớp'));
                $this->_redirect('buildingmanager/user/edit/id/'.$request['id']);
            }
        }
        return $resultPage;
        // TODO: Implement execute() method.
    }

    protected function createPasswordHash($password)
    {
        return $this->encryptor->getHash($password, true);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::user');
    }

}