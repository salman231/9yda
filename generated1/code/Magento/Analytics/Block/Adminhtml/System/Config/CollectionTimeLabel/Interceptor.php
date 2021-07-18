<?php
namespace Magento\Analytics\Block\Adminhtml\System\Config\CollectionTimeLabel;

/**
 * Interceptor class for @see \Magento\Analytics\Block\Adminhtml\System\Config\CollectionTimeLabel
 */
class Interceptor extends \Magento\Analytics\Block\Adminhtml\System\Config\CollectionTimeLabel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [], ?\Magento\Framework\Locale\ResolverInterface $localeResolver = null)
    {
        $this->___init();
        parent::__construct($context, $data, $localeResolver);
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
