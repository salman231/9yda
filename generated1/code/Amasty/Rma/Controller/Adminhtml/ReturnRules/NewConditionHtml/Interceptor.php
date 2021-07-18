<?php
namespace Amasty\Rma\Controller\Adminhtml\ReturnRules\NewConditionHtml;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\ReturnRules\NewConditionHtml
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\ReturnRules\NewConditionHtml implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\Data\ReturnRulesInterfaceFactory $ruleFactory)
    {
        $this->___init();
        parent::__construct($context, $ruleFactory);
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
