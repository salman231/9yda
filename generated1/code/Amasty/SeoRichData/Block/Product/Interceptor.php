<?php
namespace Amasty\SeoRichData\Block\Product;

/**
 * Interceptor class for @see \Amasty\SeoRichData\Block\Product
 */
class Interceptor extends \Amasty\SeoRichData\Block\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Page\Config $pageConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry, \Amasty\SeoRichData\Helper\Config $configHelper, \Magento\Catalog\Helper\Image $imageHelper, \Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewCollectionFactory, \Magento\Review\Model\RatingFactory $ratingFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $pageConfig, $storeManager, $stockRegistry, $configHelper, $imageHelper, $dateTime, $reviewCollectionFactory, $ratingFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaData($product, $key)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMetaData');
        if (!$pluginInfo) {
            return parent::getMetaData($product, $key);
        } else {
            return $this->___callPlugins('getMetaData', func_get_args(), $pluginInfo);
        }
    }
}
