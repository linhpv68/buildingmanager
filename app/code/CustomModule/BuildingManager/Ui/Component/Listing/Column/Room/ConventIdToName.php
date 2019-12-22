<?php
/**
 * cms-nckh - Product.php
 *
 * Initial version by: linhphung
 * Initial version create on : 02/08/2019
 *
 */

namespace CustomModule\BuildingManager\Ui\Component\Listing\Column\Room;

use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ConventIdToName extends Column
{
    protected $productRepository;
    protected $_projectFactory;
    protected $_modelFactory;
    protected $storeManager;
    protected $assetRepo;

    protected $url;

    /**
     * ConventIdToName constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Repository $assetRepo
     * @param \CustomModule\BuildingManager\Model\ProjectFactory $projectFactory
     * @param \CustomModule\BuildingManager\Model\ModelFactory $modelFactory
     * @param \Magento\Backend\Model\UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        \CustomModule\BuildingManager\Model\ProjectFactory $projectFactory,
        \CustomModule\BuildingManager\Model\ModelFactory $modelFactory,
        \Magento\Backend\Model\UrlInterface $url,
        array $components = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
        $this->productRepository = $productRepository;
        $this->_projectFactory = $projectFactory;
        $this->_modelFactory = $modelFactory;
        $this->url = $url;
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
        if (isset($dataSource['data']['items'])) {
            $path = $this->storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'buildingmanager/image/';


            $baseImage = $this->assetRepo->getUrl('CustomModule_BuildingManager::images/logo.png');
            foreach ($dataSource['data']['items'] as & $item) {
                try {
                    if (isset($item[$this->getData('name')])) {
                        $projectID = $item[$this->getData('name')];
                        $html = $this->_projectFactory->create()->load($projectID)->getName();
                        $item[$this->getData('name')] = html_entity_decode($html);
                    }
                    if (isset($item['modelID'])) {
                        $modelID = $item['modelID'];
                        $html = $this->_modelFactory->create()->load($modelID)->getName();
                        $item['modelID'] = html_entity_decode($html);
                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {

                }
                //Show Avatar
                if ($item['image']) {
                    $item['image' . '_src'] = $item['image'];
                    $item['image' . '_alt'] = "Ảnh đại diện";
                    $item['image' . '_orig_src'] = $item['image'];
                } else {
                    $item['image' . '_src'] = $baseImage;
                    $item['image' . '_alt'] = 'Ảnh mặc định ';
                    $item['image' . '_orig_src'] = $baseImage;
                }
                // Render List Images
                if ($item['ImageList']) {
                    $listImages = explode(",", $item['ImageList']);
                    $item['ImageList'] = html_entity_decode($this->renderMultipleImages($listImages));
                    $item['ImageList' . '_src'] = html_entity_decode($this->renderMultipleImages($listImages));
                }
            }
        }
        return $dataSource;
    }


    public function renderMultipleImages($listImages)
    {
        $imagesContainer = '';
        foreach ($listImages as $image) {
            $imageUrl = $image;
            $imagesContainer = $imagesContainer . "<a href=".$imageUrl."><img src=" . $imageUrl . " width='50px' height='50px' style='display:inline-block;margin:2px'/></a>";
        }
        return $imagesContainer;
    }

}