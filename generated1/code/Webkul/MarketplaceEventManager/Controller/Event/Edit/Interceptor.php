<?php
namespace Webkul\MarketplaceEventManager\Controller\Event\Edit;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Event\Edit
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Event\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\Marketplace\Controller\Product\Builder $productBuilder, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $productBuilder, $resultPageFactory, $customerSession);
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
