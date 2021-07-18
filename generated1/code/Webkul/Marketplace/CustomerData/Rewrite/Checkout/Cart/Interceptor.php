<?php
namespace Webkul\Marketplace\CustomerData\Rewrite\Checkout\Cart;

/**
 * Interceptor class for @see \Webkul\Marketplace\CustomerData\Rewrite\Checkout\Cart
 */
class Interceptor extends \Webkul\Marketplace\CustomerData\Rewrite\Checkout\Cart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Catalog\Model\ResourceModel\Url $catalogUrl, \Magento\Checkout\Model\Cart $checkoutCart, \Magento\Checkout\Helper\Data $checkoutHelper, \Magento\Checkout\CustomerData\ItemPoolInterface $itemPoolInterface, \Magento\Framework\View\LayoutInterface $layout, \Webkul\Marketplace\Helper\Data $marketplaceHelper, array $data = [])
    {
        $this->___init();
        parent::__construct($checkoutSession, $catalogUrl, $checkoutCart, $checkoutHelper, $itemPoolInterface, $layout, $marketplaceHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSectionData');
        if (!$pluginInfo) {
            return parent::getSectionData();
        } else {
            return $this->___callPlugins('getSectionData', func_get_args(), $pluginInfo);
        }
    }
}
