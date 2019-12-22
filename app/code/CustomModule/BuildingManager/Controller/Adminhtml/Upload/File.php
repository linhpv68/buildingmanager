<?php
/**
 * cms-nckh - file.php
 *
 * Initial version by: linhphung
 * Initial version create on : 18/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Upload;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class File   extends \Magento\Backend\App\Action
{
    protected $_fileUpload;

    public function __construct(
        Action\Context $context,
        \CustomModule\BuildingManager\Model\FileUpload $fileUpload)
    {
        parent::__construct($context);
        $this->_fileUpload = $fileUpload;
    }

    public function execute()
    {
        $field = $this->getRequest()->getParam('param_name');
        try {
            //$result = $this->_fileUpload->saveFileToTmpDir('source');
            $result = $this->_fileUpload->saveFileToTmpDir($field);
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
        // TODO: Implement execute() method.
    }

}