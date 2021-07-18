<?php
namespace Amasty\Rma\Controller\Account\View;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Account\View
 */
class Interceptor extends \Amasty\Rma\Controller\Account\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Customer\Model\Session $customerSession, \Magento\Framework\Registry $registry, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $customerRequestRepository, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($customerSession, $registry, $configProvider, $customerRequestRepository, $context);
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
