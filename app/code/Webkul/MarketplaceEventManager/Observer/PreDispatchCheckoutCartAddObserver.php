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
use Magento\Framework\App\RequestInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\HTTP\PhpEnvironment\Response;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Webkul MpSellerGroup PreDispatchCheckoutCartAddObserver Observer.
 */
class PreDispatchCheckoutCartAddObserver implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $_requestInterface;

    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    /**
     * @var Response
     */
    protected $_response;

    /**
     * @var ManagerInterface
     */
    private $_messageManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @param \Magento\Catalog\Model\Product\Option\Value $productOptionValues
     */
    protected $_productOptionValues;

    /**
     * @param \Webkul\MarketplaceEventManager\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @param ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @param \Magento\Wishlist\Model\ItemFactory
     */
    protected $itemFactory;

    /**
     * @param ProductRepositoryInterface     $productRepository
     * @param RequestInterface               $requestInterface
     * @param CheckoutSession                $checkoutSession
     * @param Response                       $response
     * @param ManagerInterface               $messageManager
     * @param UrlInterface                   $urlBuilder
     */
    public function __construct(
        \Webkul\MarketplaceEventManager\Helper\Data $dataHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        ProductRepositoryInterface $productRepository,
        RequestInterface $requestInterface,
        CheckoutSession $checkoutSession,
        Response $response,
        ManagerInterface $messageManager,
        UrlInterface $urlBuilder,
        \Magento\Wishlist\Model\ItemFactory $itemFactory,
        \Magento\Catalog\Model\Product\Option\Value $productOptionValues
    ) {
        $this->_dataHelper = $dataHelper;
        $this->productRepository = $productRepository;
        $this->_requestInterface = $requestInterface;
        $this->_checkoutSession = $checkoutSession;
        $this->_response = $response;
        $this->_date = $date;
        $this->_messageManager = $messageManager;
        $this->_urlBuilder = $urlBuilder;
        $this->itemFactory = $itemFactory;
        $this->_productOptionValues = $productOptionValues;
    }

    /**
     * Checkout cart product add event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if ($this->_dataHelper->isEventManagerEnable()) {
                $params = $this->_requestInterface->getParams();
                $productArray = [];
                if (isset($params['product'])) {
                    $paramProductId = $params['product'];
                    $product = $this->productRepository->getById($paramProductId);
                    $productArray[] = $product;
                } elseif (isset($params['item']) && $this->_requestInterface->getFullActionName() != 'wishlist_index_allcart') {
                    $item = $this->itemFactory->create()->load((int)$params['item']);
                    $product = $this->productRepository->getById($item->getProductId());
                    $productArray[(int)$params['item']] = $product;
                } elseif ($this->_requestInterface->getFullActionName() == 'wishlist_index_allcart' && isset($params['qty'])) {
                    $qty = $this->_requestInterface->getParam('qty');
                    foreach ($qty as $itemId => $proQty) {
                        $item = $this->itemFactory->create()->load((int)$itemId);
                        $product = $this->productRepository->getById($item->getProductId());
                        $productArray[$itemId] = $product;
                    }
                }
                foreach ($productArray as $key => $product) {
                    if ($product->getIsMpEvent()) {
                        $currenttime = strtotime($this->_date->gmtDate('Y-m-d G:i:s'));
                        $eventendTime = strtotime($product->getEventEndDate());
                        if ($currenttime > $eventendTime) {
                            $this->_messageManager->addNotice(__('Coupon has been expired.'));
                            if (isset($params['product'])) {
                                $observer->getRequest()->setParam('product', false);
                            } elseif (isset($params['item']) && $this->_requestInterface->getFullActionName() != 'wishlist_index_allcart') {
                                $observer->getRequest()->setParam('item', false);
                            } elseif ($this->_requestInterface->getFullActionName() == 'wishlist_index_allcart' && isset($params['qty'])) {
                                $this->itemFactory->create()->load((int)$key)->delete();
                            }
                            $url = $this->_urlBuilder->getUrl('checkout/cart');
                            $this->_response->setRedirect($url);
                            $this->_response->sendResponse();
                        } else {
                            $options = $product->getOptions();
                            foreach ($options as $option) {
                                $optionValuesCollection = $this->_productOptionValues
                                    ->getCollection()
                                    ->addFieldToFilter('option_id', $option->getOptionId());
                                foreach ($optionValuesCollection as $optval) {
                                    if (isset($params['options'])) {
                                        if ($params['options'][$optval->getOptionId()] == $optval->getOptionTypeId()) {
                                            if ($optval->getQty() < $params['qty']) {
                                                $msg = 'Event ticket '.strtoupper($optval->getTitle()).' is out of stock';
                                                $this->_messageManager->addNotice(__($msg));
                                                if (isset($params['product'])) {
                                                    $observer->getRequest()->setParam('product', false);
                                                } elseif (isset($params['item']) && $this->_requestInterface->getFullActionName() != 'wishlist_index_allcart') {
                                                    $observer->getRequest()->setParam('item', false);
                                                } elseif ($this->_requestInterface->getFullActionName() == 'wishlist_index_allcart' && isset($params['qty'])) {
                                                    $this->itemFactory->create()->load((int)$key)->delete();
                                                }
                                                $url = $this->_urlBuilder->getUrl('checkout/cart');
                                                $this->_response->setRedirect($url);
                                                $this->_response->sendResponse();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_messageManager->addError($e->getMessage());
        }
    }
}
