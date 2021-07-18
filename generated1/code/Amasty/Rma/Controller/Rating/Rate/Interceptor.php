<?php
namespace Amasty\Rma\Controller\Rating\Rate;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Rating\Rate
 */
class Interceptor extends \Amasty\Rma\Controller\Rating\Rate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Model\Request\CustomerRequestRepository $customerRequestRepository, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($customerRequestRepository, $context);
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
