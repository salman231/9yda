<?php
namespace Webkul\MarketplaceEventManager\Controller\Upcoming\Check;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Upcoming\Check
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Upcoming\Check implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Json\Helper\Data $jsonData, \Magento\Catalog\Model\ProductFactory $product, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Magento\CatalogInventory\Helper\Stock $stockFilter, \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool)
    {
        $this->___init();
        parent::__construct($context, $jsonData, $product, $cacheTypeList, $timezone, $stockFilter, $cacheFrontendPool);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
