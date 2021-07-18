<?php
namespace Mageplaza\Osc\Block\Adminhtml\Config\Backend\StaticBlock;

/**
 * Interceptor class for @see \Mageplaza\Osc\Block\Adminhtml\Config\Backend\StaticBlock
 */
class Interceptor extends \Mageplaza\Osc\Block\Adminhtml\Config\Backend\StaticBlock implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Data\Form\Element\Factory $elementFactory, \Mageplaza\Osc\Model\System\Config\Source\StaticBlockPosition $blockPosition, \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $elementFactory, $blockPosition, $blockFactory, $data);
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
