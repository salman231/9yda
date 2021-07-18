<?php
namespace Amasty\Rma\Controller\Chat\DeleteMessage;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Chat\DeleteMessage
 */
class Interceptor extends \Amasty\Rma\Controller\Chat\DeleteMessage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Model\Request\CustomerRequestRepository $requestRepository, \Amasty\Rma\Api\ChatRepositoryInterface $chatRepository, \Magento\Framework\App\Action\Context $context)
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
