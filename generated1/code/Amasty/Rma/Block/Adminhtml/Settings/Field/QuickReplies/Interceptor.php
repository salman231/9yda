<?php
namespace Amasty\Rma\Block\Adminhtml\Settings\Field\QuickReplies;

/**
 * Interceptor class for @see \Amasty\Rma\Block\Adminhtml\Settings\Field\QuickReplies
 */
class Interceptor extends \Amasty\Rma\Block\Adminhtml\Settings\Field\QuickReplies implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Amasty\Rma\Block\Adminhtml\Settings\Field\Elements\Textarea $textareaRenderer, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $textareaRenderer, $data);
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
