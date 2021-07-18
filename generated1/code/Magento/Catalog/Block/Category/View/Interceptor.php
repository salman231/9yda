<?php
namespace Magento\Catalog\Block\Category\View;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Category\View
 */
class Interceptor extends \Magento\Catalog\Block\Category\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Catalog\Model\Layer\Resolver $layerResolver, \Magento\Framework\Registry $registry, \Magento\Catalog\Helper\Category $categoryHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductListHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductListHtml');
        if (!$pluginInfo) {
            return parent::getProductListHtml();
        } else {
            return $this->___callPlugins('getProductListHtml', func_get_args(), $pluginInfo);
        }
    }
}
