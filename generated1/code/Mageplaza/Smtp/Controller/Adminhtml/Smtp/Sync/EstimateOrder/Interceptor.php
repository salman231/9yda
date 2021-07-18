<?php
namespace Mageplaza\Smtp\Controller\Adminhtml\Smtp\Sync\EstimateOrder;

/**
 * Interceptor class for @see \Mageplaza\Smtp\Controller\Adminhtml\Smtp\Sync\EstimateOrder
 */
class Interceptor extends \Mageplaza\Smtp\Controller\Adminhtml\Smtp\Sync\EstimateOrder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory, \Mageplaza\Smtp\Helper\EmailMarketing $emailMarketing)
    {
        $this->___init();
        parent::__construct($context, $orderCollectionFactory, $emailMarketing);
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
