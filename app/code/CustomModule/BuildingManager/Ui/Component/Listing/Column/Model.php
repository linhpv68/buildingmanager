<?php
/**
 * cms-nckh - Model.php
 *
 * Initial version by: linhphung
 * Initial version create on : 18/08/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column;


use CustomModule\BuildingManager\Model\ModelFactory;
use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Model extends Column
{
    protected $productRepository;
    protected $_modelFactory;
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
     * @param ModelFactory $modelFactory
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
        ModelFactory $modelFactory,
        UrlInterface $url,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
        $this->productRepository = $productRepository;
        $this->_modelFactory = $modelFactory;
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
                if ($item['source']) {
                    $url = $path.$item['source'];
                    //$urlDelete = 'admin/buildingmanager/upload/unfile/name/'.$item['source'];
                    $params = array(
                        'id'=>$item['id'],
                        'method'=>"model"
                    );
                    $urlDelete = $this->_backendUrl->getUrl("buildingmanager/upload/unfile/", $params);
                    $imagesContainer = "<a href=".$url.">".$item['source']."</a><br/><a href='".$urlDelete."'>Xóa File</a>";
                    $item['source'] = html_entity_decode($imagesContainer);
                }
            }
        }
        return $dataSource;
    }
}