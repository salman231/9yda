<?php
namespace Webkul\MarketplaceEventManager\Controller\Event\Save;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Event\Save
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Event\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Webkul\MarketplaceEventManager\Controller\Event\SaveProduct $saveProduct, \Magento\Catalog\Model\ResourceModel\Product $productResourceModel, \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Webkul\MarketplaceEventManager\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $saveProduct, $productResourceModel, $categoryLinkManagement, $marketplaceHelper, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
