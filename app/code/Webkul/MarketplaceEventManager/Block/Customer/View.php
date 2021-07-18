<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Block\Customer;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @var \Webkul\MarketplaceEventManager\Model\Mpevent
     */
    protected $_mpevent;

    /**
     * @param \Magento\Backend\Block\Template\Context       $context
     * @param \Magento\Customer\Model\Session               $customerSession
     * @param \Magento\Sales\Model\Order                    $order
     * @param \Magento\Catalog\Model\Product                $product
     * @param \Webkul\MarketplaceEventManager\Model\Mpevent $mpevent
     * @param array                                         $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\OrderFactory $order,
        \Magento\Catalog\Model\ProductFactory $product,
        \Webkul\MarketplaceEventManager\Model\Mpevent $mpevent,
        array $data = []
    ) {
        $this->_order = $order;
        $this->_product = $product;
        $this->_customerSession = $customerSession;
        $this->_mpevent = $mpevent;
        parent::__construct($context, $data);
    }
    public function getTicketDetails()
    {
        $pid = $this->getRequest()->getParam('pid');
        $oid = $this->getRequest()->getParam('oid');
        $customerId = $this->_customerSession->getCustomer()->getId();
        $itemdetails = '';
        $order = $this->_order->create()->load($oid);
        if ($order->getCustomerId() == $customerId) {
            foreach ($order->getAllVisibleItems() as $item) {
                if ($item->getProductId() == $pid) {
                    $itemdetails = $item;
                }
            }
        }
        return $itemdetails;
    }
    
    public function getRealOrderIdVal()
    {
        return $this->_order->create()->load($this->getRequest()->getParam('oid'))->getRealOrderId();
    }
    public function getProductDetails($id, $item)
    {
        $product = $this->_product->create()->load($id);
        if (!$item->getWkmpEventStart() && $product && $product->getId()) {
            return $product;
        } else {
            $item->setEventTicketPrefix($item->getWkmpEventQrprefix());
            $item->setEventVenue($item->getWkmpEventLocation());
            $item->setEventStartDate($item->getWkmpEventStart());
            $item->setEventEndDate($item->getWkmpEventEnd());
            return $item;
        }
    }
    public function getTicketDetailsCollection($orderId, $itemId, $optionid)
    {
        return $this->_mpevent
            ->getCollection()
            ->addFieldToFilter('order_id', ['eq' => $orderId])
            ->addFieldToFilter('item_id', ['eq' => $itemId])
            ->addFieldToFilter('option_id', ['eq'=>$optionid]);
    }
}
