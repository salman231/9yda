<?php
namespace OnTap\MasterCard\Controller\Webhook\Response;

/**
 * Interceptor class for @see \OnTap\MasterCard\Controller\Webhook\Response
 */
class Interceptor extends \OnTap\MasterCard\Controller\Webhook\Response implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $rawFactory, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Magento\Payment\Model\Method\LoggerFactory $loggerFactory, \Psr\Log\LoggerInterface $logger, \Magento\Payment\Gateway\Data\PaymentDataObjectFactory $paymentDataObjectFactory, \Magento\Payment\Gateway\Command\CommandPoolInterface $commandPool, array $configProviders = [])
    {
        $this->___init();
        parent::__construct($context, $rawFactory, $orderRepository, $transactionRepository, $searchCriteriaBuilder, $filterBuilder, $loggerFactory, $logger, $paymentDataObjectFactory, $commandPool, $configProviders);
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
