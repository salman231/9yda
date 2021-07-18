<?php
namespace Amasty\Rma\Controller\Guest\LoginPost;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Guest\LoginPost
 */
class Interceptor extends \Amasty\Rma\Controller\Guest\LoginPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\GuestCreateRequestProcessInterface $guestCreateRequestProcess, \Amasty\Rma\Model\Cookie\HashChecker $hashChecker, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $customerRequestRepository, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($guestCreateRequestProcess, $hashChecker, $configProvider, $customerRequestRepository, $orderRepository, $searchCriteriaBuilder, $context);
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
