<?php
namespace Amasty\CronScheduleList\Controller\Adminhtml\Schedule\MassDelete;

/**
 * Interceptor class for @see \Amasty\CronScheduleList\Controller\Adminhtml\Schedule\MassDelete
 */
class Interceptor extends \Amasty\CronScheduleList\Controller\Adminhtml\Schedule\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory $jobsCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $jobsCollectionFactory);
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
