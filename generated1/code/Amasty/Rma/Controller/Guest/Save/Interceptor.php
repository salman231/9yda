<?php
namespace Amasty\Rma\Controller\Guest\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Guest\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Guest\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Registry $registry, \Amasty\Rma\Api\GuestCreateRequestProcessInterface $guestCreateRequestProcess, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $requestRepository, \Amasty\Rma\Controller\FrontendRma $frontendRma, \Amasty\Rma\Model\Cookie\HashChecker $hashChecker, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($orderRepository, $registry, $guestCreateRequestProcess, $configProvider, $requestRepository, $frontendRma, $hashChecker, $context);
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
