<?php
/**
 * cms-nckh - GetRoom.php
 *
 * Initial version by: linhphung
 * Initial version create on : 11/08/2019
 *
 */

namespace CustomModule\BuildingManager\Controller\Adminhtml\Ajax;


use Magento\Backend\App\Action;
use CustomModule\BuildingManager\Model\ResourceModel\Room\CollectionFactory;
use mysql_xdevapi\Exception;

class GetRoom extends Action
{
    protected $_collectionFactory;

    public function __construct(Action\Context $context, CollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //return Json type
        $resultJson = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $projectID = $this->getRequest()->getParam('projectID');
        $field = array('id', 'name');
        try {
            $listRoom = $this->_collectionFactory->create()->addFieldToSelect($field)->addFieldToFilter('projectID', $projectID)->getData();
            $resultJson->setData([
                    'success' => true,
                    'data' => $listRoom,
                ]
            );
        } catch (Exception $exception) {
            $resultJson->setData([
                    'success' => true,
                    'error' => $projectID,
                ]
            );
        }
        return $resultJson;
        // TODO: Implement execute() method.
    }

}