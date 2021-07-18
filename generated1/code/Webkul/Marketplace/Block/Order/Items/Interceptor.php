<?php
namespace Webkul\Marketplace\Block\Order\Items;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Order\Items
 */
class Interceptor extends \Webkul\Marketplace\Block\Order\Items implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Model\Order $order, \Magento\Customer\Model\Customer $customer, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Element\Template\Context $context, \Magento\Sales\Model\Order\Address\Renderer $addressRenderer, \Magento\Downloadable\Model\Link\PurchasedFactory $purchasedFactory, \Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer $defaultRenderer, \Magento\Downloadable\Model\ResourceModel\Link\Purchased\Item\CollectionFactory $itemsFactory, \Webkul\Marketplace\Model\OrdersFactory $mpOrderModel, \Magento\Sales\Model\Order\Creditmemo $creditmemoModel, \Magento\Sales\Model\Order\Creditmemo\ItemFactory $creditmemoItem, \Magento\Sales\Model\Order\InvoiceFactory $invoiceModel, \Webkul\Marketplace\Model\SaleslistFactory $saleslistModel, \Webkul\Marketplace\Helper\Orders $ordersHelper, \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepository, \Magento\Shipping\Model\Config $shippingConfig, \Magento\Shipping\Model\CarrierFactory $carrierFactory, \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory $itemCollectionFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($order, $customer, $customerSession, $coreRegistry, $context, $addressRenderer, $purchasedFactory, $defaultRenderer, $itemsFactory, $mpOrderModel, $creditmemoModel, $creditmemoItem, $invoiceModel, $saleslistModel, $ordersHelper, $productRepository, $shippingConfig, $carrierFactory, $itemCollectionFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function isOrderCanShip($order)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isOrderCanShip');
        if (!$pluginInfo) {
            return parent::isOrderCanShip($order);
        } else {
            return $this->___callPlugins('isOrderCanShip', func_get_args(), $pluginInfo);
        }
    }
}
