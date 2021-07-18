<?php
namespace Magento\Catalog\ViewModel\Product\Breadcrumbs;

/**
 * Interceptor class for @see \Magento\Catalog\ViewModel\Product\Breadcrumbs
 */
class Interceptor extends \Magento\Catalog\ViewModel\Product\Breadcrumbs implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\Data $catalogData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, ?\Magento\Framework\Serialize\Serializer\Json $json = null, ?\Magento\Framework\Escaper $escaper = null)
    {
        $this->___init();
        parent::__construct($catalogData, $scopeConfig, $json, $escaper);
    }

    /**
     * {@inheritdoc}
     */
    public function isCategoryUsedInProductUrl() : bool
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isCategoryUsedInProductUrl');
        if (!$pluginInfo) {
            return parent::isCategoryUsedInProductUrl();
        } else {
            return $this->___callPlugins('isCategoryUsedInProductUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonConfigurationHtmlEscaped() : string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getJsonConfigurationHtmlEscaped');
        if (!$pluginInfo) {
            return parent::getJsonConfigurationHtmlEscaped();
        } else {
            return $this->___callPlugins('getJsonConfigurationHtmlEscaped', func_get_args(), $pluginInfo);
        }
    }
}
