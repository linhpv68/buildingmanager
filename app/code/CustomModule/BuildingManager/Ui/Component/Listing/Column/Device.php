<?php
/**
 * cms-nckh - Model.php
 *
 * Initial version by: linhphung
 * Initial version create on : 18/08/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column;


use CustomModule\BuildingManager\Model\DeviceFactory;
use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Device extends Column
{
    protected $productRepository;
    protected $_deviceFactory;
    protected $storeManager;
    protected $assetRepo;

    protected $url;
    protected $_backendUrl;

    /**
     * ConventIdToName constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ProductRepository $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Repository $assetRepo
     * @param DeviceFactory $deviceFactory
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        DeviceFactory $deviceFactory,
        UrlInterface $url,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
        $this->productRepository = $productRepository;
        $this->_deviceFactory = $deviceFactory;
        $this->url = $url;
        $this->_backendUrl = $backendUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     * @throws
     */
    public function prepareDataSource(array $dataSource)
    {
        $path = $this->storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'buildingmanager/files/';
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                // Render List Images
                if ($item['user_guide']) {
                    $url = $path.$item['user_guide'];
                    //$urlDelete = 'admin/buildingmanager/upload/unfile/name/'.$item['user_guide'];
                    $params = array(
                        'id'=>$item['id'],
                        'method'=>"device"
                    );
                    $urlDelete = $this->_backendUrl->getUrl("buildingmanager/upload/unfile/", $params);
                    $imagesContainer = "<a href=".$url.">".$item['user_guide']."</a><br/><a href='".$urlDelete."'>Xóa File</a>";
                    $item['user_guide'] = html_entity_decode($imagesContainer);
                }
            }
        }
        return $dataSource;
    }
}