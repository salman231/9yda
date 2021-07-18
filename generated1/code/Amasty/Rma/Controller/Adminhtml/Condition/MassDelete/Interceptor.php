<?php
namespace Amasty\Rma\Controller\Adminhtml\Condition\MassDelete;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Condition\MassDelete
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Condition\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\ConditionRepositoryInterface $repository, \Amasty\Rma\Model\Condition\ResourceModel\CollectionFactory $collectionFactory, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $repository, $collectionFactory, $filter, $logger);
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
