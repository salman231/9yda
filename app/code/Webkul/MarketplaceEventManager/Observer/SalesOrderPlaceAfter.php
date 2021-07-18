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
use Magento\Framework\App\Filesystem\DirectoryList;

class SalesOrderPlaceAfter implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var Magento\Sales\Model\Order
     */
    protected $_order;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @var \Webkul\Marketplace\Model\Product
     */
    protected $_mpproduct;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;

    /**
     * @var \Webkul\MarketplaceEventManager\Helper\Data
     */
    protected $_memhelper;

    /**
     * @var \Webkul\MarketplaceEventManager\Model\Qrgenerator
     */
    protected $_qrgenerator;

    /**
     * @var \Webkul\MarketplaceEventManager\Model\Mpevent
     */
    protected $_mpevent;

    /**
     * @var \Webkul\Customer\Model\Customer
     */
    protected $_customer;

    /**
     * @var \Webkul\Marketplace\Model\Saleslist
     */
    protected $_mpsaleslist;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;
    protected $_url;
    protected $_mpHelper;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param SessionManager                            $session
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Logger\Monolog $logger,
        \Magento\Sales\Model\OrderFactory $order,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $product,
        \Webkul\Marketplace\Model\Product $mpproduct,
        \Magento\Framework\Filesystem $fileSystem,
        \Webkul\MarketplaceEventManager\Helper\Data $memhelper,
        \Webkul\MarketplaceEventManager\Model\Qrgenerator $qrgenerator,
        \Webkul\MarketplaceEventManager\Model\Mpevent $mpevent,
        \Magento\Customer\Model\CustomerFactory $customer,
        \Webkul\Marketplace\Model\Saleslist $saleslist,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\UrlInterface $url,
        \Webkul\Marketplace\Helper\Data $mpHelper,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->_objectManager = $objectManager;
        $this->_logger = $logger;
        $this->_order = $order;
        $this->_customerSession = $session;
        $this->_storeManager = $storeManager;
        $this->_product = $product;
        $this->_mpproduct = $mpproduct;
        $this->_fileSystem = $fileSystem;
        $this->_memhelper = $memhelper;
        $this->_qrgenerator = $qrgenerator;
        $this->_mpevent = $mpevent;
        $this->_customer = $customer;
        $this->_mpsaleslist = $saleslist;
        $this->_date = $date;
        $this->_curl = $curl;
        $this->_url = $url;
        $this->_transportBuilder = $transportBuilder;
        $this->_mpHelper = $mpHelper;
        $this->inlineTranslation = $inlineTranslation;
    }

    /**
     * after place order event handler
     * Distribute Quantity for Pickup Stores
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $orders = [];
        if ($observer->getOrder() !== null) {
            $orders = [$observer->getOrder()];
        } elseif ($observer->getOrders() !== null) {
            $orders = $observer->getOrders();
        }
        foreach ($orders as $order) {
            $lastOrderId = $order->getId();
            $shippingmethod = $order->getShippingMethod();
            $allorderitems = $order->getAllItems();
            // $helper = Mage::helper('mpeticketsystem');
            $order = $this->_order->create()->load($lastOrderId);
            $customer_id = 0;
            $customerName = '';
            $customerEmail = '';
            if ($this->_customerSession->isLoggedIn()) {
                $customer_id = $this->_customerSession->getCustomer()->getId();
            } else {
                $customerEmail = $order->getCustomerEmail();
                $customerName = $order->getFirstName();
            }
            $storeId = $this->_storeManager->getStore()->getId();
            $emailvar = [];
            $seller_id = 0;
            $code_prefix = strtoupper($this->_memhelper->getGlobalEventPrefix());
            /*
            looping through the order items
            */
            $sellerEmailVar = '';
            $ticketscount = 0;
            foreach ($order->getAllVisibleItems() as $item) {
                $eventData = [];
                $unique_code = '';
                $eventData['item_qty'] = $item->getQtyOrdered();
                $eventData['item_id'] = $item->getId();
                $eventData['order_id'] =  $order->getId();
                $eventData['customer_id'] = $customer_id;
                $eventData['status'] =1;
                //$eventData['total_qty_ordered'] = $item->getData('total_qty_ordered');

                // echo "<pre>"; print_r($eventData); 
                // echo "...............";
                $product  = $this->_product->create()->load($item->getProductId());
                if ($product->getEventTicketPrefix()) {
                    $code_prefix = strtoupper($product->getEventTicketPrefix());
                }



                /*
                   Code to get seller id using product id
                 */
            
                $sellerProduct = $this->_mpproduct
                ->getCollection()
                ->addFieldToFilter('mageproduct_id', ['eq'=>$product->getId()]);
                $eventData['seller_id'] = 0;
                $seller_id = 0;
                if ($sellerProduct->getSize()) {
                    foreach ($sellerProduct as $seller) {
                        $eventData['seller_id'] = $seller->getSellerId();
                        $seller_id = $seller->getSellerId();
                    }
                }
                $eventData['product_id'] = $product->getId();

                if ($product->getIsMpEvent() && $product->getTypeId() == 'etickets') {
                    $item->setWkmpEventStart($product->getEventStartDate());
                    $item->setWkmpEventEnd($product->getEventEndDate());
                    $item->setWkmpEventLocation($product->getEventVenue());
                    $item->setWkmpEventQrprefix($product->getEventTicketPrefix());
                    $item->save();
                    $ticketscount++;
                    $options = $product->getProductOptionsCollection();

                    /*
                    getting product options from sales/order
                    */
                    $productoptions = $item['product_options'];
            
                    /*
                    creating directory structure for storing the qr image
                    */
                    if (!is_dir($this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('mpeticketsystem/'))) {
                        mkdir($this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('mpeticketsystem/'), 0755, true);
                    }
                    /*
                    unique code for validating the ticket
                    */
                    $unique_code_qr = $this->_memhelper->getRandId(10);
                    //$unique_code = $code_prefix.$unique_code_qr.'_'.$lastOrderId;
                    $unique_code = $unique_code_qr.'_'.$lastOrderId;
                    // $qrcode = $this->_qrgenerator->(Mage::getUrl('mpeticketsystem/index/checkticketstatus',array('unique_code'=>$unique_code_qr,'order_id'=>$lastOrderId)),'200');
                    $filepath = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('mpeticketsystem/');

                    $filename = $unique_code;
                    /*
                    generating the qr code image url
                    */
            
                    // $image_url  = $this->_qrgenerator->generate(
                    //     $this->_url->getUrl(
                    //         'marketplaceeventmanager/index/checkticketstatus',
                    //         ['unique_code'=>$unique_code_qr, 'order_id'=>$lastOrderId, 'item_id' => $eventData['item_id']]
                    //     ),
                    //     '200'
                    // );

                    $image_url  = $this->_qrgenerator->generate(
                        $this->_url->getUrl(
                            'marketplaceeventmanager/index/checkticketstatus',
                            ['unique_code'=>$unique_code_qr, 'order_id'=>$lastOrderId, 'item_id' => $eventData['item_id']]
                        ),
                        '200'
                    );
            
                    $image_type = 'png';
                    $filename   = $filename.'.'.$image_type;
                    $filepath   = $filepath.$filename;
                    $this->_curl->get(trim($image_url));
            
                    /*
                    uploading qr image to directory
                        */
                    file_put_contents($filepath, $this->_curl->getBody());

                    $optionTypeId = 0;
                    $ticketType = '';
                    $eventData['option_qty'] = $item->getQtyOrdered();
                    foreach ($options as $option) {
                        foreach ($option->getValues() as $opval) {
                            if ($opval['option_type_id'] == $productoptions['info_buyRequest']['options'][$opval->getOptionId()]) {
                                if ($product->getExtensionAttributes()->getStockItem()->getManageStock()) {
                                    $opval->setQty((int)$opval->getQty()-(int)$item->getQtyOrdered());
                                }
                                $eventData['option_qty'] = $item->getQtyOrdered();
                                $eventData['option_id'] = $opval->getOptionId();
                                $ticketType = $opval->getTitle();
                                $optionTypeId = $opval->getOptionTypeId();
                                $opval->save();
                            }
                        }
                    }
            
                    $eventData['option_type_id'] = $optionTypeId;
                    $eventData['option_title'] = $ticketType;
                    $eventData['qrcode'] = $unique_code;
                    $eventData['updated_at'] = date('Y-m-d H:i:s');
                    $eventData['created_at'] = date('Y-m-d H:i:s');
                    //echo Mage::helper('mpeticketsystem')->getQrImageUrl($eventData['qrcode']);die;
                    $this->_mpevent->setData($eventData)->save();
                    $salesList = $this->_mpsaleslist
                    ->getCollection()
                    ->addFieldToFilter('order_item_id', ['eq'=>$item->getId()]);
                    foreach ($salesList as $sl) {
                        $sl->setQrcode($eventData['qrcode']);
                        $sl->save();
                    }
                    if ($eventData['seller_id']) {
                        $seller = $this->_customer->create()->load($eventData['seller_id']);
                    }

            
                    if ($this->_customerSession->isLoggedIn()) {
                        $customer = $this->_customer->create()->load($customer_id);
                        $customerName = $customer->getName();
                        $customerEmail =$customer->getEmail();
                    }

                    //acc custom code as per qty display multiple QR code
                    $qr = '';
                    for($i=1;$i <= intVal($eventData['item_qty']);$i++){
                        $qr .= '<img src="'.$this->_memhelper->getQrImageUrl($eventData['qrcode']).'" alt="'.$this->_qrgenerator->generate($this->_storeManager->getStore()->getBaseUrl().'mpeticketsystem/index/checkticketstatus', ['unique_code'=>$unique_code_qr, 'order_id'=>$lastOrderId, 'item_id' => $eventData['item_id']], '200').'"  style="margin-bottom:10px;" border="0"/>';
                    }
                    //end
                    $sellerEmailVar .= '
                    <!-- [ header starts here] -->
                    <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0"  style="border:1px solid #E0E0E0;border-top:none">
                        <!-- [ middle starts here] -->
                        <tr>
                            <td valign="top">
                                <h1 style="font-size:19px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">Voucher QR Code :</h1>
                                 <p>
                                    '.$qr.'
                                 </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h2 style="font-size:18px; font-weight:normal; margin:0;">Your Coupons</h2>
                            </td>
                        </tr>
                        <tr>
                        <td>
                            <table cellspacing="0" cellpadding="0" border="0" style="border-bottom:5px dotted #ccc;margin-bottom:20px">
                        <tbody>
                            <tr>
                                <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF""><strong>Coupon Name:</strong></td>
                                 <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF"">'.$product->getName().'</td>
                             </tr>
                            
                             <tr>
                                <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF""><strong>Coupon Valid From:</strong></td>
                                <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF""><strong>'.$this->_date->date('g:ia \o\n l jS F Y', $product->getEventStartDate()).'</strong></td>
                                </tr>
                            <tr>
                                <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF"><strong>Coupon Expired On:</strong></td>
                                 <td align="left" width="325" bgcolor="#204395" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;color:#FFFFFF""><strong>'.$this->_date->date('g:ia \o\n l jS F Y', $product->getEventEndDate()).'</strong></td>
                            </tr> 
                        </tbody>
                    </table>';
                }
            }
            //echo "<pre>"; print_r($eventData); 


            /*
             * Send Ticket To Customer Email
             */
            if ($ticketscount) {
                $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->_storeManager->getStore()->getId()];
                if ($seller_id) {
                    $seller = $this->_customer->create()->load($seller_id);
                    $from = ['email' => $seller->getEmail(), 'name' => '9YDA DEALS'];
                } else {
                    $from = ['email' => $this->_mpHelper->getAdminEmailId(), 'name' => '9YDA DEALS'];
                }
                $emailTempVariables = [];
                $emailTempVariables['myvar1'] = $sellerEmailVar;
                $emailTempVariables['myvar2'] = $customerName;
                $emailTempVariables['myvar3'] = $ticketscount;
                try {
                    $transport = $this->_transportBuilder->setTemplateIdentifier($this->_memhelper->getOrderNotificationTemplate())
                        ->setTemplateOptions($templateOptions)
                        ->setTemplateVars($emailTempVariables)
                        ->setFrom($from)
                        ->addTo($customerEmail, $customerName)
                        ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch (\Exception $e) {
                }
            }
        }
    }
}
