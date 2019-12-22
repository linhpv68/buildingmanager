<?php
/**
 * cms-nckh - Add.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\User;


use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use mysql_xdevapi\Exception;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;

class Add extends Action
{
    protected $_pageFactory;
    protected $_collectionFactory;

    private $encryptor;

    public function __construct(Action\Context $context,
                                PageFactory $pageFactory,
                                Encryptor $encryptor, CollectionFactory $collectionFactory)
    {
        $this->encryptor = $encryptor;
        $this->_pageFactory = $pageFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Thêm mới Người dùng'));
        $resultPage->getConfig()->getTitle()->set(__('Quản lý công trình'));

        $request = $this->getRequest()->getParams();

        if (isset($request) && !empty($request)) {
            $request['status'] = '0';

            if (isset($request['id']) && !$request['id']) {
                unset($request['id']);
            }

            if (isset($request['new-password'])) {
                if ($request['new-password'] == $request['re-password']) {

                    $request['password'] = md5($request['new-password']);
                    $model = $this->_objectManager->create('CustomModule\BuildingManager\Model\User');
                    $testEmail = $this->_collectionFactory->create()->addFieldToFilter('email', $request['email'])->getData();
                    if (isset($testEmail) && $testEmail != []) {
                        $this->messageManager->addErrorMessage(__('Email đã tồn tại'));
                        $this->_redirect('buildingmanager/user/add');
                    }else{
                        $model->setData($request);
                        try {
                            $model->save();
                            $this->messageManager->addSuccessMessage(__('Bạn đã thêm thành công'));
                        } catch (\Exception $e) {
                            $this->messageManager->addErrorMessage($e);
                        }
                    }

                } else {
                    $this->messageManager->addErrorMessage(__('Mật khẩu không trùng khớp'));
                }
                $this->_redirect('buildingmanager/user/add');

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
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::User');
    }

}