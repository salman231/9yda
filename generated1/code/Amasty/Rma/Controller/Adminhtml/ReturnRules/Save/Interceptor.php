<?php
namespace Amasty\Rma\Controller\Adminhtml\ReturnRules\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\ReturnRules\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\ReturnRules\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\ReturnRulesRepositoryInterface $rulesRepository, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Magento\Framework\DataObject $dataObject, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $rulesRepository, $coreRegistry, $dataPersistor, $dataObject, $logger);
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
