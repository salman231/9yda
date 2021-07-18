<?php
namespace Amasty\Rma\Controller\Adminhtml\ReturnRules\Edit;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\ReturnRules\Edit
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\ReturnRules\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\ReturnRulesRepositoryInterface $repository, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($context, $repository, $registry);
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
