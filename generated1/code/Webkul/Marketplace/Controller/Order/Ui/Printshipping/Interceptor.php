<?php
namespace Webkul\Marketplace\Controller\Order\Ui\Printshipping;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Order\Ui\Printshipping
 */
class Interceptor extends \Webkul\Marketplace\Controller\Order\Ui\Printshipping implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Customer\Model\Session $customerSession, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory, \Webkul\Marketplace\Helper\Data $helper, \Magento\Customer\Model\Url $customerUrl, \Webkul\Marketplace\Model\ResourceModel\Orders\CollectionFactory $mpOrdersCollection, \Magento\Sales\Model\ResourceModel\Order\Shipment\Collection $shipmentCollection, \Webkul\Marketplace\Model\Order\Pdf\Shipment $shipmentPdf, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\App\Response\Http\FileFactory $fileFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $customerSession, $orderCollectionFactory, $helper, $customerUrl, $mpOrdersCollection, $shipmentCollection, $shipmentPdf, $date, $fileFactory);
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
