<?php
namespace Amasty\Rma\Controller\Adminhtml\TrackingNumber\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\TrackingNumber\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\TrackingNumber\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\CustomerRequestRepositoryInterface $requestRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($requestRepository, $context);
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
