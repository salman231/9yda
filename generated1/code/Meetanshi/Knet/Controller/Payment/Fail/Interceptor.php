<?php
namespace Meetanshi\Knet\Controller\Payment\Fail;

/**
 * Interceptor class for @see \Meetanshi\Knet\Controller\Payment\Fail
 */
class Interceptor extends \Meetanshi\Knet\Controller\Payment\Fail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $registry, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Framework\App\Request\Http $request, \Magento\Sales\Model\Order\Payment\Transaction\Builder $transactionBuilder, \Meetanshi\Knet\Helper\Data $helper, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Sales\Model\OrderNotifier $orderSender, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Framework\DB\TransactionFactory $transactionFactory, \Magento\Sales\Model\Service\InvoiceService $invoiceService)
    {
        $this->___init();
        parent::__construct($context, $registry, $checkoutSession, $storeManager, $scopeConfig, $orderFactory, $request, $transactionBuilder, $helper, $resultPageFactory, $orderSender, $invoiceSender, $transactionFactory, $invoiceService);
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
