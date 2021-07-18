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
namespace Webkul\MarketplaceEventManager\Block;

class Checkstatus extends \Magento\Framework\View\Element\Template
{
    protected $_product;
    protected $_customerSession;
    protected $_saleslist;
    protected $_mpevent;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $_objectManager;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;
    
    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param Product                                $product
     * @param array                                  $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Sales\Model\OrderFactory $order,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Webkul\Marketplace\Model\Saleslist $saleslist,
        \Webkul\MarketplaceEventManager\Model\Mpevent $mpevent,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_order = $order;
        $this->productFactory = $productFactory;
        $this->_customerSession = $customerSession;
        $this->_saleslist = $saleslist;
        $this->_mpevent = $mpevent;
        $this->groupRepository = $groupRepository;
        $this->_objectManager = $objectManager;
        $this->_storeManager = $context->getStoreManager();
        parent::__construct($context, $data);
    }
    public function getCustomerId()
    {
        if ($this->_customerSession->getCustomer()->getId()) {
            return $this->_customerSession->getCustomer()->getId();
        }
        return false;
    }
     public function getLoggedInSellerId()
    {
        
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
        
        return $this->_customerSession->getCustomer()->getId();
    }
    public function getEventProduct($orderId, $qrcode, $itemId)
    {
        $collection  = $this->_saleslist
            ->getCollection()
            ->addFieldToFilter('order_id', ['eq' => $orderId])
            ->addFieldToFilter('order_item_id', ['eq' => $itemId])
            ->addFieldToFilter('qrcode', ['eq' => $qrcode]);
    
        if ($collection->getSize() > 0) {
            foreach ($collection as $col) {
                $productid = $col->getMageproductId();
                break;
            }
        }
        return $this->productFactory->create()->load($productid);
    }
    
    public function getQrCollection($qrcode)
    {
        return $this->_mpevent
            ->getCollection()
            ->addFieldToFilter('qrcode', ['eq'=>$qrcode]);
    }
    public function getImageUrl($image)
    {
        if ($image) {
            return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .'catalog/product'.$image;
        } else {
            return $this->getViewFileUrl('Magento_Catalog::images/product/placeholder/small_image.jpg');
        }
    }
    public function getRealOrderIdVal()
    {
        return $this->_order->create()->load($this->getRequest()->getParam('order_id'))->getRealOrderId();
    }
}
