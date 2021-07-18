<?php
namespace Webkul\Marketplace\Controller\Seller\Collection;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Seller\Collection
 */
class Interceptor extends \Webkul\Marketplace\Controller\Seller\Collection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $helper);
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
