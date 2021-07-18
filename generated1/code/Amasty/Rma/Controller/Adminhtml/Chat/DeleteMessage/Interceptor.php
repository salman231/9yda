<?php
namespace Amasty\Rma\Controller\Adminhtml\Chat\DeleteMessage;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Chat\DeleteMessage
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Chat\DeleteMessage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\RequestRepositoryInterface $requestRepository, \Amasty\Rma\Api\ChatRepositoryInterface $chatRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($requestRepository, $chatRepository, $context);
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
