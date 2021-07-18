<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Sellerflag\MassStatus;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Sellerflag\MassStatus
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Sellerflag\MassStatus implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\App\ResourceConnection $resource, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Webkul\Marketplace\Model\ResourceModel\SellerFlagReason\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $resource, $date, $collectionFactory);
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
