<?php
namespace Amasty\Rma\Controller\Guest\Login;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Guest\Login
 */
class Interceptor extends \Amasty\Rma\Controller\Guest\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Model\ConfigProvider $configProvider, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($configProvider, $context);
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
