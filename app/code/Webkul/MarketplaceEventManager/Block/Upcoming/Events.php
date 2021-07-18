<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Block\Upcoming;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class Events extends \Magento\Catalog\Block\Product\ListProduct
{

    protected $_mpproduct;
    protected $_product;
    protected $_filesystem;
    protected $_storeManager;
    protected $_imageFactory;
    protected $_memhelper;
    protected $_productCollection = null;
    protected $_mphelper;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param Product                                $product
     * @param array                                  $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Webkul\Marketplace\Model\Product $mpproduct,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Webkul\MarketplaceEventManager\Helper\Data $memhelper,
        \Webkul\Marketplace\Helper\Data $mphelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\CatalogInventory\Helper\Stock $stockFilter,
        \Magento\Catalog\Helper\Image $imageHelper,
        array $data = []
    ) {
        $this->_mpproduct = $mpproduct;
        $this->_product = $product;
        $this->_filesystem = $context->getFilesystem();
        $this->_storeManager = $context->getStoreManager();
        $this->_imageFactory = $imageFactory;
        $this->_memhelper = $memhelper;
        $this->_mphelper = $mphelper;
        $this->timezone = $timezone;
        $this->_stockFilter = $stockFilter;
        $this->imageHelper = $imageHelper;
        parent::__construct(
            $context,
            $postDataHelper,
            $layerResolver,
            $categoryRepository,
            $urlHelper,
            $data
        );
    }
    
    public function _getProductCollection()
    {
        $collection = $this->_product->create()
                                    ->getCollection()
                                    ->addAttributeToSelect('*')
                                    ->addFieldToFilter('type_id', ['eq' => 'etickets']);
        $this->_stockFilter->addInStockFilterToCollection($collection);
        if ($this->_memhelper->getEventToDate()) {
            $collection->addFieldToFilter('event_start_date', ['lteq' => $this->_memhelper->getEventToDate()]);
        }
        if ($this->_memhelper->getEventFromDate()) {
            $collection->addFieldToFilter('event_start_date', ['gteq' => $this->_memhelper->getEventFromDate()]);
        }
        if (!$this->_memhelper->getEventToDate() && !$this->_memhelper->getEventFromDate()) {
            $today = $this->timezone->date()->format('Y-m-d H:i:s');
            $collection->addFieldToFilter('event_start_date', ['gteq' => $today]);
        }
        $query = $this->getRequest()->getParam('q');
        if ($query) {
            $collection->addFieldToFilter('name', ['like'=>'%'.$query.'%']);
        }
        $toolbar = $this->getToolbarBlock();
        $this->configureProductToolbar($toolbar, $collection);

        $this->_eventManager->dispatch(
            'catalog_block_product_list_collection',
            ['collection' => $collection]
        );

        $this->_productCollection = $collection;

        return $collection;
    }

    public function getProductModel($pid)
    {
        return $this->_product->create()->load($pid);
    }

    public function imageResize($image)
    {
        if (!$image || $image == 'no_selection') {
            return $this->getViewFileUrl('Magento_Catalog::images/product/placeholder/small_image.jpg');
        }
        if ($image) {
            $absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()
            . 'catalog/product'.$image;
            $imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('resized/').$image;
            $imageResize = $this->_imageFactory->create();
            $imageResize->open($absPath);
            $imageResize->constrainOnly(true);
            $imageResize->keepTransparency(true);
            $imageResize->keepFrame(false);
            $imageResize->keepAspectRatio(true);
            $imageResize->resize(300);
            $dest = $imageResized ;
            $imageResize->save($dest);
            $resizedURL= $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'resized/'.$image;
            return $resizedURL;
        }
    }
    public function checkSellerStatus($id)
    {
        $data = $this->_mphelper->getSellerDataBySellerId($id);
        foreach ($data as $key => $value) {
            return $value->getIsSeller();
        }
    }
    public function getProductById($id)
    {
        return $this->_product->create()->load($id);
    }



    public function configureProductToolbar($toolbar, $collection)
    {
        $availableOrders = $this->getAvailableOrders();
        if (isset($availableOrders['position'])) {
            unset($availableOrders['position']);
        }
        if ($availableOrders) {
            $toolbar->setAvailableOrders($availableOrders);
        }
        $sortBy = $this->getSortBy();
        if ($sortBy) {
            $toolbar->setDefaultOrder($sortBy);
        }
        $defaultDirection = $this->getDefaultDirection();
        if ($defaultDirection) {
            $toolbar->setDefaultDirection($defaultDirection);
        }
        $sortModes = $this->getModes();
        if ($sortModes) {
            $toolbar->setModes($sortModes);
        }
        // set collection to toolbar and apply sort
        $toolbar->setCollection($collection);
        $this->setChild('toolbar', $toolbar);
    }

    public function getDefaultDirection()
    {
        return 'asc';
    }

    public function getSortBy()
    {
        return 'name';
    }

    public function getProductImage($_product)
    {
        $image_url = $this->imageHelper->init($_product, 'product_page_image_large')->getUrl();
        return $image_url;
    }
    
    public function getLocaleTime($dateTime)
    {
        return $this->converToTz(
            $dateTime,
            $this->timezone->getConfigTimezone(),
            $this->timezone->getDefaultTimezone()
        );
    }

    protected function converToTz($dateTime = "", $toTz = '', $fromTz = '')
    {
        $date = new \DateTime($dateTime, new \DateTimeZone($fromTz));
        $date->setTimezone(new \DateTimeZone($toTz));
        $dateTime = $date->format('m/d/Y H:i:s');
        return $dateTime;
    }
}
