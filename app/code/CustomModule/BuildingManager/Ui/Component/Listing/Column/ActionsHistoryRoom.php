<?php
/**
 * cms-nckh - ActionsHistoryRoom.php
 *
 * Initial version by: linhphung
 * Initial version create on : 25/07/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use CustomModule\BuildingManager\Model\UserFactory;
use CustomModule\BuildingManager\Model\RoomFactory;

class ActionsHistoryRoom extends Column
{

    const GRID_URL_PATH_EDIT = 'buildingmanager/historyroom/edit';
    const GRID_URL_PATH_DELETE = 'buildingmanager/historyroom/delete';
    protected $_roomFactory;
    protected $_userFactory;

    /** @var UrlInterface */
    protected $urlBuilder;
    /**
     * @var string
     */

    /**
     * @param ContextInterface $context
     * @param UserFactory $userFactory
     * @param RoomFactory $roomFactory
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param UrlInterface $urlBuilder
     * @param array $data
     */

    public function __construct(ContextInterface $context,
                                UserFactory $userFactory,
                                RoomFactory $roomFactory,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                UrlInterface $urlBuilder,
                                array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        $this->_roomFactory = $roomFactory;
        $this->_userFactory = $userFactory;
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
                            'message' => __('Bạn có muốn xóa "${ $.$data.id }" này?')
                        ]
                    ];
                }

                // Convent Id To Name
                if (isset($item['roomID'])) {
                    $roomID = $item['roomID'];
                    $html = $this->_roomFactory->create()->load($roomID)->getName();
                    $item['roomID'] = html_entity_decode($html);
                }
                if (isset($item['userID'])) {
                    $userID = $item['userID'];
                    $html = $this->_userFactory->create()->load($userID)->getFullname();
                    $item['userID'] = html_entity_decode($html);
                }

            }
        }
        return $dataSource;
    }


}