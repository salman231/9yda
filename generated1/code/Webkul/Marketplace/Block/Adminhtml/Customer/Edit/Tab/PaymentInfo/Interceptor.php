<?php
namespace Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\PaymentInfo;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\PaymentInfo
 */
class Interceptor extends \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\PaymentInfo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Registry $registry, \Magento\Backend\Block\Widget\Context $context, \Webkul\Marketplace\Block\Adminhtml\Customer\Edit $customerEdit, array $data = [])
    {
        $this->___init();
        parent::__construct($registry, $context, $customerEdit, $data);
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
