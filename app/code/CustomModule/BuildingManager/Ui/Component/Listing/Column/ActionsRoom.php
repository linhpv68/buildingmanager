<?php
/**
 * cms-nckh - ActionsRoomDevice.php
 *
 * Initial version by: linhphung
 * Initial version create on : 28/07/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ActionsRoom extends Column
{

    const GRID_URL_PATH_EDIT = 'buildingmanager/room/edit';
    const GRID_URL_PATH_DELETE = 'buildingmanager/room/delete';
    /** @var UrlInterface */
    protected $urlBuilder;
    /**
     * @var string
     */

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $data
     */

    public function __construct(ContextInterface $context,
                                UiComponentFactory $uiComponentFactory,
                                array $components = [],
                                UrlInterface $urlBuilder,
                                array $data = [])
    {
        $this->urlBuilder=$urlBuilder;
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
                        'href' => $this->urlBuilder->getUrl(self::GRID_URL_PATH_EDIT,['id' => $item['id']]),
                        'label' => __('Sửa')
                    ];

                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::GRID_URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Xóa'),
                        'confirm' => [
                            'title' => __('Xóa "${ $.$data.name }"'),
                            'message' => __('Bạn có muốn xóa "${ $.$data.name }" này?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }


}