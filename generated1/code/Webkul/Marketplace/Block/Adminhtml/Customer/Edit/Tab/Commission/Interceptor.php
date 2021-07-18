<?php
namespace Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\Commission;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\Commission
 */
class Interceptor extends \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\Commission implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Registry $registry, \Magento\Backend\Block\Widget\Context $context, \Webkul\Marketplace\Block\Adminhtml\Customer\Edit $customerEdit, array $data = [], ?\Magento\Framework\Pricing\Helper\Data $pricingHelper = null)
    {
        $this->___init();
        parent::__construct($registry, $context, $customerEdit, $data, $pricingHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
