<?php
namespace Webkul\MarketplaceEventManager\Block\Upcoming\Events;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Block\Upcoming\Events
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Block\Upcoming\Events implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Data\Helper\PostHelper $postDataHelper, \Magento\Catalog\Model\Layer\Resolver $layerResolver, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Magento\Framework\Url\Helper\Data $urlHelper, \Webkul\Marketplace\Model\Product $mpproduct, \Magento\Catalog\Model\ProductFactory $product, \Magento\Framework\Image\AdapterFactory $imageFactory, \Webkul\MarketplaceEventManager\Helper\Data $memhelper, \Webkul\Marketplace\Helper\Data $mphelper, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Magento\CatalogInventory\Helper\Stock $stockFilter, \Magento\Catalog\Helper\Image $imageHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $mpproduct, $product, $imageFactory, $memhelper, $mphelper, $timezone, $stockFilter, $imageHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewsSummaryHtml(\Magento\Catalog\Model\Product $product, $templateType = false, $displayIfNoReviews = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getReviewsSummaryHtml');
        if (!$pluginInfo) {
            return parent::getReviewsSummaryHtml($product, $templateType, $displayIfNoReviews);
        } else {
            return $this->___callPlugins('getReviewsSummaryHtml', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
