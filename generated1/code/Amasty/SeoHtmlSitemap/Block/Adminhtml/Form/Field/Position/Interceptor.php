<?php
namespace Amasty\SeoHtmlSitemap\Block\Adminhtml\Form\Field\Position;

/**
 * Interceptor class for @see \Amasty\SeoHtmlSitemap\Block\Adminhtml\Form\Field\Position
 */
class Interceptor extends \Amasty\SeoHtmlSitemap\Block\Adminhtml\Form\Field\Position implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\SeoHtmlSitemap\Helper\Data $helper, \Magento\Backend\Block\Template\Context $context, \Magento\Framework\Module\Manager $manager)
    {
        $this->___init();
        parent::__construct($helper, $context, $manager);
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
