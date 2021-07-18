<?php
namespace Webkul\Marketplace\Controller\Account\Dashboard\Tunnel;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Account\Dashboard\Tunnel
 */
class Interceptor extends \Webkul\Marketplace\Controller\Account\Dashboard\Tunnel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Webkul\Marketplace\Helper\Dashboard\Data $mpDashboardHelper, \Magento\Framework\HTTP\ZendClient $httpZendClient, \Webkul\Marketplace\Helper\Data $mpHelper)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $mpDashboardHelper, $httpZendClient, $mpHelper);
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
