<?php
/**
 * cms-nckh - ConventIdToName.php
 *
 * Initial version by: linhphung
 * Initial version create on : 07/08/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column\UserRoom;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use CustomModule\BuildingManager\Model\UserFactory;
use CustomModule\BuildingManager\Model\RoomFactory;

class ConventIdToName extends Column
{
    protected $_userFactory;
    protected $_roomFactory;
    public function __construct(ContextInterface $context,
                                UserFactory $userFactory,
                                RoomFactory $roomFactory,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                array $data = [])
    {
        $this->_userFactory = $userFactory;
        $this->_roomFactory = $roomFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                try {
                    if (isset($item[$this->getData('name')])){
                        $userID =  $item[$this->getData('name')];
                        $html = $this->_userFactory->create()->load($userID)->getFullname();
                        $item[$this->getData('name')] = html_entity_decode($html);
                    }
                    if (isset($item['roomID'])){
                        $roomID =  $item['roomID'];
                        $html = $this->_roomFactory->create()->load($roomID)->getName();
                        $item['roomID'] = html_entity_decode($html);
                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {

                }
            }
        }

        return $dataSource;
    }
}