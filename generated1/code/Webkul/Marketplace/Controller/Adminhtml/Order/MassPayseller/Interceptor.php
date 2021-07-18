<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Order\MassPayseller;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Order\MassPayseller
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Order\MassPayseller implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Sales\Model\OrderRepository $orderRepository, \Webkul\Marketplace\Model\ResourceModel\Saleslist\CollectionFactory $collectionFactory, \Webkul\Marketplace\Helper\Data $mpHelper, \Webkul\Marketplace\Helper\Email $mpEmailHelper, \Webkul\Marketplace\Model\SellertransactionFactory $sellertransaction, \Webkul\Marketplace\Model\SaleperpartnerFactory $saleperpartner, \Webkul\Marketplace\Model\OrdersFactory $ordersModel, \Webkul\Marketplace\Helper\Notification $notificationHelper, \Magento\Customer\Model\CustomerFactory $customerModel)
    {
        $this->___init();
        parent::__construct($context, $filter, $date, $dateTime, $orderRepository, $collectionFactory, $mpHelper, $mpEmailHelper, $sellertransaction, $saleperpartner, $ordersModel, $notificationHelper, $customerModel);
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
