<?php
namespace Vertex\Tax\Block\Adminhtml\Config\Form\Field\ShippingCodes;

/**
 * Interceptor class for @see \Vertex\Tax\Block\Adminhtml\Config\Form\Field\ShippingCodes
 */
class Interceptor extends \Vertex\Tax\Block\Adminhtml\Config\Form\Field\ShippingCodes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Shipping\Model\Config $shippingConfig, \Magento\Store\Api\GroupRepositoryInterface $groupRepository, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $shippingConfig, $groupRepository, $data);
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
