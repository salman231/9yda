<?php
namespace Magento\Paypal\Block\Adminhtml\System\Config\Payflowlink\Info;

/**
 * Interceptor class for @see \Magento\Paypal\Block\Adminhtml\System\Config\Payflowlink\Info
 */
class Interceptor extends \Magento\Paypal\Block\Adminhtml\System\Config\Payflowlink\Info implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
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
