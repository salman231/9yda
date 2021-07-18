<?php
namespace Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Rma;

/**
 * Interceptor class for @see \Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Rma
 */
class Interceptor extends \Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Rma implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Temando\Shipping\Model\Config\ModuleConfigInterface $moduleConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $data);
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
