<?php
namespace Webkul\MarketplaceEventManager\Controller\Event\Add;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Event\Add
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Event\Add implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $customerSession, \Webkul\MarketplaceEventManager\Controller\Event\Builder $productBuilder)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $customerSession, $productBuilder);
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
