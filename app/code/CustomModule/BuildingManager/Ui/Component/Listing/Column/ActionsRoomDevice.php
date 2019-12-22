<?php
/**
 * cms-nckh - ActionsRoomDevice.php
 *
 * Initial version by: linhphung
 * Initial version create on : 28/07/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column;


use CustomModule\BuildingManager\Model\RoomFactory;
use CustomModule\BuildingManager\Model\DeviceFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ActionsRoomDevice extends Column
{

    const GRID_URL_PATH_EDIT = 'buildingmanager/roomdevice/edit';
    const GRID_URL_PATH_DELETE = 'buildingmanager/roomdevice/delete';
    /** @var UrlInterface */
    protected $urlBuilder;
    protected $_roomFactory;
    protected $_deviceFactory;
    /**
     * @var string
     */

    /**
     * @param ContextInterface $context
     * @param RoomFactory $roomFactory
     * @param DeviceFactory $deviceFactory
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param UrlInterface $urlBuilder
     * @param array $data
     */

    public function __construct(ContextInterface $context,
                                RoomFactory $roomFactory,
                                DeviceFactory $deviceFactory,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                UrlInterface $urlBuilder,
                                array $data = [])
    {
        $this->_roomFactory = $roomFactory;
        $this->_deviceFactory = $deviceFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $temp = $dataSource;
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {

                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::GRID_URL_PATH_EDIT, ['id' => $item['id']]),
                        'label' => __('Sửa')
                    ];

                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::GRID_URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Xóa'),
                        'confirm' => [
                            'title' => __('Xóa "${ $.$data.id }"'),
                            'message' => __('Bạn muốn xóa "${ $.$data.id }" này?')
                        ]
                    ];
                }

                // Convent Id To Name
                if (isset($item['roomID'])) {
                    $roomID = $item['roomID'];
                    $html = $this->_roomFactory->create()->load($roomID)->getName();
                    $item['roomID'] = html_entity_decode($html);
                }
                if (isset($item['deviceID'])) {
                    $deviceID = $item['deviceID'];
                    $html = $this->_deviceFactory->create()->load($deviceID)->getType();
                    $item['deviceID'] = html_entity_decode($html);
                }
            }
        }
        return $dataSource;
    }


}