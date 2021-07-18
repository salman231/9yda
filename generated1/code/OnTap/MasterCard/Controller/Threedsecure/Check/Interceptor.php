<?php
namespace OnTap\MasterCard\Controller\Threedsecure\Check;

/**
 * Interceptor class for @see \OnTap\MasterCard\Controller\Threedsecure\Check
 */
class Interceptor extends \OnTap\MasterCard\Controller\Threedsecure\Check implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Payment\Gateway\Command\CommandPoolFactory $commandPoolFactory, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Payment\Gateway\Data\PaymentDataObjectFactory $paymentDataObjectFactory, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($commandPoolFactory, $checkoutSession, $paymentDataObjectFactory, $jsonFactory, $context);
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
