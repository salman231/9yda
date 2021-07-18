<?php
namespace Webkul\MarketplaceEventManager\Controller\Index\Invalidate;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Index\Invalidate
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Index\Invalidate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\MarketplaceEventManager\Model\Mpevent $mpevent)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $mpevent);
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
