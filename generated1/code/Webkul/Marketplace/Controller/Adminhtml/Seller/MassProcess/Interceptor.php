<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Seller\MassProcess;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Seller\MassProcess
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Seller\MassProcess implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Store\Model\StoreManagerInterface $storeManager, \Webkul\Marketplace\Model\ResourceModel\Seller\CollectionFactory $collectionFactory, \Magento\Customer\Model\CustomerFactory $customerFactory, \Webkul\Marketplace\Helper\Data $mpHelper, \Webkul\Marketplace\Helper\Email $mpEmailHelper)
    {
        $this->___init();
        parent::__construct($context, $filter, $date, $storeManager, $collectionFactory, $customerFactory, $mpHelper, $mpEmailHelper);
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
