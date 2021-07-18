<?php
namespace Amasty\Rma\Controller\Account\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Account\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Account\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Registry $registry, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $requestRepository, \Amasty\Rma\Controller\FrontendRma $frontendRma, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($customerSession, $orderRepository, $registry, $configProvider, $requestRepository, $frontendRma, $context);
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
