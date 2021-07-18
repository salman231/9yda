<?php
namespace Yotpo\Yotpo\Block\Yotpo;

/**
 * Interceptor class for @see \Yotpo\Yotpo\Block\Yotpo
 */
class Interceptor extends \Yotpo\Yotpo\Block\Yotpo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Yotpo\Yotpo\Model\Config $yotpoConfig, \Magento\Framework\Registry $coreRegistry, \Magento\Catalog\Helper\Image $catalogImageHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $yotpoConfig, $coreRegistry, $catalogImageHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
