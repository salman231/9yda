<?php
namespace Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Activation;

/**
 * Interceptor class for @see \Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Activation
 */
class Interceptor extends \Temando\Shipping\Block\Adminhtml\System\Config\Form\Field\Activation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Temando\Shipping\Model\Config\ModuleConfigInterface $moduleConfig, \Temando\Shipping\ViewModel\Config\Activation $viewModel, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleConfig, $viewModel, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element) : string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
