<?php
namespace Magento\CatalogSearch\Model\Adapter\Aggregation\Checker\Query\CatalogView;

/**
 * Interceptor class for @see \Magento\CatalogSearch\Model\Adapter\Aggregation\Checker\Query\CatalogView
 */
class Interceptor extends \Magento\CatalogSearch\Model\Adapter\Aggregation\Checker\Query\CatalogView implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Magento\Store\Model\StoreManagerInterface $storeManager, $name)
    {
        $this->___init();
        parent::__construct($categoryRepository, $storeManager, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicable(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isApplicable');
        if (!$pluginInfo) {
            return parent::isApplicable($request);
        } else {
            return $this->___callPlugins('isApplicable', func_get_args(), $pluginInfo);
        }
    }
}
