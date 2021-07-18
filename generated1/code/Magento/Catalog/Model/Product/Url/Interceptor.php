<?php
namespace Magento\Catalog\Model\Product\Url;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Url
 */
class Interceptor extends \Magento\Catalog\Model\Product\Url implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\UrlFactory $urlFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Filter\FilterManager $filter, \Magento\Framework\Session\SidResolverInterface $sidResolver, \Magento\UrlRewrite\Model\UrlFinderInterface $urlFinder, array $data = [], ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null)
    {
        $this->___init();
        parent::__construct($urlFactory, $storeManager, $filter, $sidResolver, $urlFinder, $data, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(\Magento\Catalog\Model\Product $product, $params = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUrl');
        if (!$pluginInfo) {
            return parent::getUrl($product, $params);
        } else {
            return $this->___callPlugins('getUrl', func_get_args(), $pluginInfo);
        }
    }
}
