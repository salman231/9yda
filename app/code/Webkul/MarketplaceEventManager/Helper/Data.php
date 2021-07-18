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
namespace Webkul\MarketplaceEventManager\Helper;

use Magento\Framework\Message\ManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * Core store config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Webkul\Marketplace\Helper\Data
     */
    protected $_mpHelper;

    /**
     * @var Magento\Eav\Model\Entity
     */
    protected $_entity;

    /**
     * @var Magento\Eav\Model\Entity\Attribute\Set
     */
    protected $_entityset;
    /**
     * @var ProductCollection
     */
    protected $_productCollection;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    protected $_productOption;
    protected $_productOptionValues;
    protected $_product;
    /**
     * @var \Magento\Catalog\Model\Product\OptionFactory
     */
    protected $_option;

    /**
     * @param \Magento\Framework\App\Helper\Context        $context
     * @param \Webkul\SellerStorePickup\Model\StoreFactory $store
     * @param CookieManagerInterface                       $cookieManager
     * @param SessionManager                               $session
     * @param \Magento\Framework\ObjectManagerInterface    $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface   $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Webkul\Marketplace\Helper\Data $mpHelper,
        \Magento\Eav\Model\Entity $entity,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Eav\Model\Entity\Attribute\Set $entityset,
        \Magento\Catalog\Model\Product\Option $productOption,
        \Magento\Catalog\Model\Product\Option\Value $productOptionValues,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Customer\Model\Session $customersession,
        ManagerInterface $messageManager,
        ProductCollection $productCollectionFactory,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->_mpHelper = $mpHelper;
        $this->_entity = $entity;
        $this->_entityset = $entityset;
        $this->_product = $product;
        $this->_productOption = $productOption;
        $this->_productCollection = $productCollectionFactory;
        $this->_productOptionValues = $productOptionValues;
        $this->_customerSession = $customersession;
        $this->_cart = $cart;
        $this->_messageManager = $messageManager;
        $this->cacheTypeList = $cacheTypeList;
        $this->groupRepository = $groupRepository;
        parent::__construct($context);
    }
    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer()->getId();
    }
    //compatible with seller sub account
    public function getLoggedInSellerId()
    {
        if ($this->_moduleManager->isEnabled('Webkul_SellerSubAccount')) {
            $subAccountHelper = $this->_objectManager->create(
                'Webkul\SellerSubAccount\Helper\Data'
            );
            if ($subAccountHelper->manageSubAccounts()) {
                $groupId = $this->_customerSession->getCustomer()->getGroupId();
                $group = $this->groupRepository->getById($groupId);
                if ($group->getCode() == 'Sub Account') {
                    return $subAccountHelper->getSubAccountSellerId();
                }
            }
        }
        return $this->_customerSession->getCustomer()->getId();
    }
    public function isEventManagerEnable()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getExpiredAddToCartLabel()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/add_to_cart_label',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getConfigTerms()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/enable_terms',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getAllowedCategoryIds()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/allowed_category',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getEventFromDate()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/from_date',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getEventToDate()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/to_date',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getGlobalEventPrefix()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/event_prefix',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getRemainderTemplate()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/reminder_mail',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getOrderNotificationTemplate()
    {
        return $this->scopeConfig->getValue(
            'marketplaceeventmanager/settings/order_notification_mail',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getEventTicketPrefix($pid)
    {
        $product = $this->_product->create()->load($pid);
        $prefix = $this->getGlobalEventPrefix();
        if ($product->getEventTicketPrefix()) {
            $prefix = $product->getEventTicketPrefix();
        }
        return $prefix;
    }
    public function getAllowedAttributeSets()
    {
        $entityTypeId = $this->_entity
                ->setType('catalog_product')
                ->getTypeId();
        $data = [];
        $allowed = explode(',', $this->_mpHelper->getAllowedAttributesetIds());
        $attributeSetCollection = $this->_entityset
                        ->getCollection()
                        ->addFieldToFilter('attribute_set_id', ['in'=>$allowed])
                        ->setEntityTypeFilter($entityTypeId);
        foreach ($attributeSetCollection as $_attributeSet) {
            array_push(
                $data,
                [
                    'value'=>$_attributeSet->getData('attribute_set_id'),
                    'label'=>$_attributeSet->getData('attribute_set_name')
                ]
            );
        }
        return $data;
    }
    public function getEventProductList()
    {
        $ids = [];
        if ($this->isEventManagerEnable()) {
            $products = $this->_productCollection->create()
                ->addAttributeToFilter('type_id', ['eq' => 'etickets'])
                ->addAttributeToFilter('is_mp_event', ['eq'=>1]);
            $eventfromdate = $this->getEventFromDate();
            $eventtodate = $this->getEventToDate();
            count($products);
            if (!empty($eventfromdate) && !empty($eventtodate) && strtotime($eventfromdate) >= strtotime(date('Y-m-d'))) {
                $products
                    ->addAttributeToFilter('event_start_date', ['gteq'=>$eventfromdate])
                    ->addAttributeToFilter('event_end_date', ['lteq'=>$eventtodate]);
            } elseif (!empty($eventfromdate) && !empty($eventtodate) && strtotime($eventfromdate) < strtotime(date('Y-m-d'))) {
                $products
                    ->addAttributeToFilter('event_start_date', ['gteq'=>date('Y-m-d')])
                    ->addAttributeToFilter('event_end_date', ['lteq'=>$eventtodate]);
            } else {
                $products
                    ->addAttributeToFilter('event_end_date', ['gteq'=>date('Y-m-d')]);
            }
            $ids = $products->getColumnValues('entity_id');
        }
        return $ids;
    }
    public function getCalculatedQty($id)
    {
        $proCol = $this->_productCollection
            ->create()
            ->addFieldToFilter('entity_id', $id)->getData();
        foreach ($proCol as $key => $product) {
            if ($product['type_id'] == 'etickets') {
                $qty = $this->getAllOptionQty($id);
                return $qty;
            } else {
                return false;
            }
        }
    }
    public function getAllOptionQty($id)
    {
        $qty = 0;
        $optionId = [];
        $options = $this->_productOption
            ->getCollection()
            ->addFieldToFilter('product_id', $id);
        foreach ($options as $key => $value) {
            $optionId[$key] = $value->getOptionId();
        }

        $values = $this->_productOptionValues
            ->getCollection()
            ->addFieldToFilter('option_id', ['in' => $optionId]);
        foreach ($values as $key => $value) {
            $qty = $qty + $value->getQty();
        }
        return $qty;
    }
    public function getRandId($length)
    {
        if ($length>0) {
            $randId = "";
            for ($i=1; $i <= $length; $i++) {
                $num = random_int(1, 36);
                $randId .= $this->assignRandValue($num);
            }
        }
        return $randId;
    }
    public function isEventProduct($proId)
    {
        if ($this->_product->create()->load($proId)->getTypeId() == 'etickets') {
            return true;
        }
        return false;
    }
    public function checkStatus()
    {
        $cartModel = $this->getCart();
        $quote = $cartModel->getQuote();
        foreach ($quote->getAllVisibleItems() as $item) {
            $productId = $item->getProductId();
            if ($this->isEventProduct($productId)) {
                $itemId = $item->getId();
                $product = $item->getProduct();
                $options = $product->getOptions();
                $cartoption = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
                if (is_array($options)) {
                    foreach ($options as $option) {
                        $optionValuesCollection = $this->_productOptionValues
                            ->getCollection()
                            ->addFieldToFilter('option_id', $option->getOptionId());
                        foreach ($optionValuesCollection as $optval) {
                            if (isset($cartoption['info_buyRequest'])) {
                                if ($cartoption['info_buyRequest']['options'][$optval->getOptionId()] == $optval->getOptionTypeId()) {
                                    if ($optval->getQty() > 0 && $optval->getQty() < $item->getQty()) {
                                        $item->setQty($optval->getQty());
                                        $item->save();
                                        $this->_messageManager->addError(
                                            __(
                                                'Requested quantity is not available for selected 
                                                ticket type. Only %1 quantity is available for selected ticket type.',
                                                $optval->getQty()
                                            )
                                        );
                                    }
                                    if ($optval->getQty() <= 0) {
                                        $this->_messageManager->addError(
                                            __(
                                                'Event ticket %1 is out of stock',
                                                $optval->getTitle()
                                            )
                                        );
                                        $this->getCart()->removeItem($itemId)->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->getCart()->save();
    }
    /**
     * Get Cart
     *
     * @return object
     */
    public function getCart()
    {
        $cartModel = $this->_cart;
        return $cartModel;
    }
    public function assignRandValue($num)
    {
            // accepts 1 - 36
        switch ($num) {
            case "1":
                $rand_value = "A";
                break;
            case "2":
                $rand_value = "B";
                break;
            case "3":
                $rand_value = "C";
                break;
            case "4":
                $rand_value = "D";
                break;
            case "5":
                $rand_value = "E";
                break;
            case "6":
                $rand_value = "F";
                break;
            case "7":
                $rand_value = "G";
                break;
            case "8":
                $rand_value = "H";
                break;
            case "9":
                $rand_value = "I";
                break;
            case "10":
                $rand_value = "J";
                break;
            case "11":
                $rand_value = "K";
                break;
            case "12":
                $rand_value = "L";
                break;
            case "13":
                $rand_value = "M";
                break;
            case "14":
                $rand_value = "N";
                break;
            case "15":
                $rand_value = "O";
                break;
            case "16":
                $rand_value = "P";
                break;
            case "17":
                $rand_value = "Q";
                break;
            case "18":
                $rand_value = "R";
                break;
            case "19":
                $rand_value = "S";
                break;
            case "20":
                $rand_value = "T";
                break;
            case "21":
                $rand_value = "U";
                break;
            case "22":
                $rand_value = "V";
                break;
            case "23":
                $rand_value = "W";
                break;
            case "24":
                $rand_value = "X";
                break;
            case "25":
                $rand_value = "Y";
                break;
            case "26":
                $rand_value = "Z";
                break;
            case "27":
                $rand_value = "0";
                break;
            case "28":
                $rand_value = "1";
                break;
            case "29":
                $rand_value = "2";
                break;
            case "30":
                $rand_value = "3";
                break;
            case "31":
                $rand_value = "4";
                break;
            case "32":
                $rand_value = "5";
                break;
            case "33":
                $rand_value = "6";
                break;
            case "34":
                $rand_value = "7";
                break;
            case "35":
                $rand_value = "8";
                break;
            case "36":
                $rand_value = "9";
                break;
        }
        return $rand_value;
    }

    /**
     * Flush Cache
     */
    public function cacheFlush()
    {
        $types = ['full_page'];
        foreach ($types as $type) {
            $this->cacheTypeList->cleanType($type);
        }
    }

    public function getQrImageUrl($unique_code)
    {
        return $filepath = $this->_storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'mpeticketsystem/'.$unique_code.'.png';
    }
}
