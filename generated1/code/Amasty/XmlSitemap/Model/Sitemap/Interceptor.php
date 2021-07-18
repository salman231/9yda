<?php
namespace Amasty\XmlSitemap\Model\Sitemap;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Model\Sitemap
 */
class Interceptor extends \Amasty\XmlSitemap\Model\Sitemap implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Filesystem\Io\File $ioFile, \Magento\Framework\Filesystem\DirectoryList $dir, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Filesystem $filesystem, \Magento\Catalog\Model\Product\Visibility $productVisibility, \Magento\Framework\Module\Manager $moduleManager, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory, \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory, \Magento\Framework\Message\ManagerInterface $messageManager, \Amasty\XmlSitemap\Helper\Data $helper, \Magento\Catalog\Helper\Image $imageHelper, \Magento\Catalog\Model\Product\Gallery\ReadHandler $galleryReadHandler, \Magento\CatalogInventory\Helper\Stock $stockHelper, \Magento\Store\Model\App\Emulation $appEmulation, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Amasty\XmlSitemap\Model\Hreflang\XmlTagsProviderFactory $hreflangTagsProviderFactory, \Magento\Framework\Escaper $escaper, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $ioFile, $dir, $dateTime, $storeManager, $filesystem, $productVisibility, $moduleManager, $productCollectionFactory, $categoryCollectionFactory, $pageCollectionFactory, $messageManager, $helper, $imageHelper, $galleryReadHandler, $stockHelper, $appEmulation, $categoryRepository, $hreflangTagsProviderFactory, $escaper, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductUrl($product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductUrl');
        if (!$pluginInfo) {
            return parent::getProductUrl($product);
        } else {
            return $this->___callPlugins('getProductUrl', func_get_args(), $pluginInfo);
        }
    }
}
