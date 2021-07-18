<?php
namespace Amasty\Rma\Controller\Adminhtml\Request\CreateReturn;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Request\CreateReturn
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Request\CreateReturn implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\RequestRepositoryInterface $requestRepository, \Amasty\Rma\Model\ConfigProvider $configProvider, \Amasty\Rma\Api\CreateReturnProcessorInterface $createReturnProcessor, \Psr\Log\LoggerInterface $logger, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($requestRepository, $configProvider, $createReturnProcessor, $logger, $context);
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
