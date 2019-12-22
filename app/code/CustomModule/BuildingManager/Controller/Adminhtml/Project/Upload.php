<?php
/**
 * cms-nckh - Upload.php
 *
 * Initial version by: linhphung
 * Initial version create on : 22/07/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Project;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Upload extends \Magento\Backend\App\Action
{
    public $imageUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \CustomModule\BuildingManager\Model\ImageUploader $imageUploader
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomModule_BuildingManager::project');
    }
}