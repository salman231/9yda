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
namespace Webkul\MarketplaceEventManager\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Webkul MarketplaceEventManager CheckoutCartSaveBefore Observer.
 */
class CheckoutCartSaveAfterObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @param Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @param RequestInterface
     */
    protected $_request;

    protected $_date;

    /**
     * @param \Magento\Catalog\Model\Product\Option\Value $productOptionValues
     */
    protected $_productOptionValues;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Checkout\Model\Session             $checkoutSession
     * @param \Magento\Framework\App\RequestInterface     $request
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Catalog\Model\Product\Option\Value $productOptionValues,
        \Magento\Quote\Model\Quote\Item $item,
        ResultFactory $resultFactory
    ) {
        $this->messageManager = $messageManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_request = $request;
        $this->_product = $product;
        $this->_date = $date;
        $this->_productOptionValues = $productOptionValues;
        $this->resultFactory = $resultFactory;
        $this->_item = $item;
    }

    /**
     * Cart save after event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $paramData = $this->_request->getParams();
            if (isset($paramData['product'])) {
                $product = $this->_product->create()->load($paramData['product']);
                if ($product->getIsMpEvent()) {
                    $currenttime = strtotime($this->_date->gmtDate('Y-m-d G:i:s'));
                    $eventendTime = strtotime($product->getEventEndDate());
                    if ($currenttime > $eventendTime) {
                        $this->deleteQuoteItems($paramData['product']);
                        $this->messageManager->addError(__('Coupon has been expired.'));
                        return $resultRedirect->setPath('checkout/cart');
                    } else {
                        $options = $product->getOptions();
                        foreach ($options as $option) {
                            $optionValuesCollection = $this->_productOptionValues
                                ->getCollection()
                                ->addFieldToFilter('option_id', $option->getOptionId());
                            foreach ($optionValuesCollection as $optval) {
                                if (isset($paramData['options'])) {
                                    if ($paramData['options'][$optval->getOptionId()] == $optval->getOptionTypeId()) {
                                        if ($optval->getQty() < $paramData['qty']) {
                                            $this->deleteQuoteItems($paramData['product']);
                                            $msg = 'Coupon ticket '.strtoupper($optval->getTitle()).' is out of stock';
                                            $this->messageManager->addError(__($msg));
                                            return $resultRedirect->setPath('checkout/cart');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }
    public function deleteQuoteItems($id)
    {
        $allItems = $this->_checkoutSession->getQuote()->getAllVisibleItems();
        foreach ($allItems as $item) {
            $itemId = $item->getItemId();
            if ($id == $item->getProductId()) {
                $quoteItem = $this->_item->load($itemId);
                $quoteItem->delete();
            }
        }
    }
}
