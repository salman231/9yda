<?php
namespace Magento\Catalog\Block\Product\View\Attributes;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\View\Attributes
 */
class Interceptor extends \Magento\Catalog\Block\Product\View\Attributes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $priceCurrency, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdditionalData(array $excludeAttr = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAdditionalData');
        if (!$pluginInfo) {
            return parent::getAdditionalData($excludeAttr);
        } else {
            return $this->___callPlugins('getAdditionalData', func_get_args(), $pluginInfo);
        }
    }
}
