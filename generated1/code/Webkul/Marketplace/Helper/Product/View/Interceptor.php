<?php
namespace Webkul\Marketplace\Helper\Product\View;

/**
 * Interceptor class for @see \Webkul\Marketplace\Helper\Product\View
 */
class Interceptor extends \Webkul\Marketplace\Helper\Product\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Catalog\Model\Session $catalogSession, \Magento\Catalog\Model\Design $catalogDesign, \Magento\Catalog\Helper\Product $catalogProduct, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $categoryUrlPathGenerator, \Webkul\Marketplace\Helper\Product $mpProductHelper, \Magento\Framework\Stdlib\StringUtils $string, array $messageGroups = [])
    {
        $this->___init();
        parent::__construct($context, $catalogSession, $catalogDesign, $catalogProduct, $coreRegistry, $messageManager, $categoryUrlPathGenerator, $mpProductHelper, $string, $messageGroups);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAndRender(\Magento\Framework\View\Result\Page $resultPage, $productId, $controller, $params = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prepareAndRender');
        if (!$pluginInfo) {
            return parent::prepareAndRender($resultPage, $productId, $controller, $params);
        } else {
            return $this->___callPlugins('prepareAndRender', func_get_args(), $pluginInfo);
        }
    }
}
