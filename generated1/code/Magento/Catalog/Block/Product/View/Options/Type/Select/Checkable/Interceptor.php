<?php
namespace Magento\Catalog\Block\Product\View\Options\Type\Select\Checkable;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\View\Options\Type\Select\Checkable
 */
class Interceptor extends \Magento\Catalog\Block\Product\View\Options\Type\Select\Checkable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \Magento\Catalog\Helper\Data $catalogData, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $pricingHelper, $catalogData, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOption');
        if (!$pluginInfo) {
            return parent::getOption();
        } else {
            return $this->___callPlugins('getOption', func_get_args(), $pluginInfo);
        }
    }
}
