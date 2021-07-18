<?php
namespace Amasty\CronScheduleList\Controller\Adminhtml\Schedule\RunCron;

/**
 * Interceptor class for @see \Amasty\CronScheduleList\Controller\Adminhtml\Schedule\RunCron
 */
class Interceptor extends \Amasty\CronScheduleList\Controller\Adminhtml\Schedule\RunCron implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\CacheInterface $cache, \Magento\Framework\Shell $shell, \Symfony\Component\Process\PhpExecutableFinder $phpExecutableFinder)
    {
        $this->___init();
        parent::__construct($context, $cache, $shell, $phpExecutableFinder);
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
