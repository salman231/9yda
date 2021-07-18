<?php
namespace Amasty\Rma\Controller\Guest\View;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Guest\View
 */
class Interceptor extends \Amasty\Rma\Controller\Guest\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Registry $registry, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $customerRequestRepository, \Amasty\Rma\Model\ConfigProvider $configProvider, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($registry, $customerRequestRepository, $configProvider, $context);
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
