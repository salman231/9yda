<?php
namespace Amasty\Rma\Controller\Guest\NewReturn;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Guest\NewReturn
 */
class Interceptor extends \Amasty\Rma\Controller\Guest\NewReturn implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Registry $registry, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\GuestCreateRequestProcessInterface $guestCreateRequestProcess, \Amasty\Rma\Api\CreateReturnProcessorInterface $createReturnProcessor, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($orderRepository, $registry, $configProvider, $guestCreateRequestProcess, $createReturnProcessor, $context);
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
