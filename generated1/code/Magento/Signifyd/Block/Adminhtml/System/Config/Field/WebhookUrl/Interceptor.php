<?php
namespace Magento\Signifyd\Block\Adminhtml\System\Config\Field\WebhookUrl;

/**
 * Interceptor class for @see \Magento\Signifyd\Block\Adminhtml\System\Config\Field\WebhookUrl
 */
class Interceptor extends \Magento\Signifyd\Block\Adminhtml\System\Config\Field\WebhookUrl implements \Magento\Framework\Interception\InterceptorInterface
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
