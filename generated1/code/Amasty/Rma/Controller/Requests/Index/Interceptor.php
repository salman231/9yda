<?php
namespace Amasty\Rma\Controller\Requests\Index;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Requests\Index
 */
class Interceptor extends \Amasty\Rma\Controller\Requests\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Controller\FrontendRma $frontendRma, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($frontendRma, $context);
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
