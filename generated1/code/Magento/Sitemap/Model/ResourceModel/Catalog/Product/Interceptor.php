<?php
namespace Magento\Sitemap\Model\ResourceModel\Catalog\Product;

/**
 * Interceptor class for @see \Magento\Sitemap\Model\ResourceModel\Catalog\Product
 */
class Interceptor extends \Magento\Sitemap\Model\ResourceModel\Catalog\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Sitemap\Helper\Data $sitemapData, \Magento\Catalog\Model\ResourceModel\Product $productResource, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Model\Product\Visibility $productVisibility, \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus, \Magento\Catalog\Model\ResourceModel\Product\Gallery $mediaGalleryResourceModel, \Magento\Catalog\Model\Product\Gallery\ReadHandler $mediaGalleryReadHandler, \Magento\Catalog\Model\Product\Media\Config $mediaConfig, $connectionName = null, ?\Magento\Catalog\Model\Product $productModel = null, ?\Magento\Catalog\Helper\Image $catalogImageHelper = null, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null, ?\Magento\Catalog\Model\Product\Image\UrlBuilder $urlBuilder = null)
    {
        $this->___init();
        parent::__construct($context, $sitemapData, $productResource, $storeManager, $productVisibility, $productStatus, $mediaGalleryResourceModel, $mediaGalleryReadHandler, $mediaConfig, $connectionName, $productModel, $catalogImageHelper, $scopeConfig, $urlBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection($storeId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCollection');
        if (!$pluginInfo) {
            return parent::getCollection($storeId);
        } else {
            return $this->___callPlugins('getCollection', func_get_args(), $pluginInfo);
        }
    }
}
