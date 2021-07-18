<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request\DataProvider;

use Amasty\Rma\Api\Data\ConditionInterface;
use Amasty\Rma\Api\Data\MessageInterface;
use Amasty\Rma\Api\Data\ReasonInterface;
use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\RequestItemInterface;
use Amasty\Rma\Api\Data\ResolutionInterface;
use Amasty\Rma\Api\RequestRepositoryInterface;
use Amasty\Rma\Model\ConfigProvider;
use Amasty\Rma\Model\Chat\ResourceModel\CollectionFactory as MessageCollectionFactory;
use Amasty\Rma\Model\OptionSource\ItemStatus;
use Amasty\Rma\Model\Request\ResourceModel\CollectionFactory;
use Amasty\Rma\Utils\FileUpload;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;
use Magento\Framework\App\RequestInterface as HttpRequest;
use Magento\Framework\View\Asset\Repository as AssetRepository;

/**
 * Class Form
 */
class Form extends AbstractDataProvider
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var RequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var AddressRenderer
     */
    private $addressRenderer;

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var FileUpload
     */
    private $fileUpload;

    /**
     * @var \Magento\Framework\Url
     */
    private $frontendUrl;

    /**
     * @var AssetRepository
     */
    private $assetRepository;

    /**
     * @var MessageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Image
     */
    private $imageHelper;

    /**
     * @var Data\FormInformation
     */
    private $formInformation;

    public function __construct(
        CollectionFactory $collectionFactory,
        OrderRepositoryInterface $orderRepository,
        ConfigProvider $configProvider,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        AddressRenderer $addressRenderer,
        RequestRepositoryInterface $requestRepository,
        GroupRepositoryInterface $groupRepository,
        ProductRepositoryInterface $productRepository,
        MessageCollectionFactory $messageCollectionFactory,
        Image $imageHelper,
        AssetRepository $assetRepository,
        HttpRequest $httpRequest,
        FileUpload $fileUpload,
        \Magento\Framework\Url $frontendUrl,
        Data\FormInformation $formInformation,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->configProvider = $configProvider;
        $this->requestRepository = $requestRepository;
        $this->orderRepository = $orderRepository;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->addressRenderer = $addressRenderer;
        $this->httpRequest = $httpRequest;
        $this->groupRepository = $groupRepository;
        $this->fileUpload = $fileUpload;
        $this->frontendUrl = $frontendUrl;
        $this->assetRepository = $assetRepository;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->formInformation = $formInformation;
    }

    public function getData()
    {
        $data = parent::getData();

        if (!$data['totalRecords']) {
            return [];
        }
        $request = $this->requestRepository->getById($data['items'][0][RequestInterface::REQUEST_ID]);
        $data[$request->getRequestId()] = $request->getData();

        $data[$request->getRequestId()][RequestInterface::CUSTOM_FIELDS] = [];
        if ($customFields = $this->configProvider->getCustomFields($request->getStoreId())) {
            $customFieldsData = $request->getCustomFields();
            foreach ($customFields as $code => $label) {
                if (!empty($customFieldsData[$code])) {
                    $data[$request->getRequestId()][RequestInterface::CUSTOM_FIELDS][] = [
                        'label' => $label,
                        'value' => $customFieldsData[$code]
                    ];
                }
            }
        }

        $data[$request->getRequestId()][RequestInterface::REQUEST_ITEMS] = [];
        $order = $this->orderRepository->get($request->getOrderId());

        $returnItems = [];
        foreach ($request->getRequestItems() as $requestItem) {
            foreach ($order->getItems() as $item) {
                if ($item->getItemId() == $requestItem->getOrderItemId()) {
                    break;
                }
            }

            try {
                $product = $this->productRepository->get($item->getSku());
                $image = $this->imageHelper->init($product, 'product_thumbnail_image')->getUrl();
                $url = $this->url->getUrl('catalog/product/edit', ['id' => $product->getId()]);
            } catch (NoSuchEntityException $e) {
                $url = false;
                $image = false;
            }

            $itemData = [
                    RequestItemInterface::REQUEST_ITEM_ID => $requestItem->getRequestItemId(),
                    RequestItemInterface::ORDER_ITEM_ID => $requestItem->getOrderItemId(),
                    'name' => $item->getName(),
                    'sku' => $item->getSku(),
                    'status' => $requestItem->getItemStatus(),
                    'is_decimal' => $item->getIsQtyDecimal(),
                    'condition_id' => $requestItem->getConditionId(),
                    'reason_id' => $requestItem->getReasonId(),
                    'is_returnable' => true,
                    'resolution_id' => $requestItem->getResolutionId(),
                    'url' => $url,
                    RequestItemInterface::QTY => $requestItem->getQty(),
                    'image' => $image,
                    'is_editable' => true
            ];
            if (empty($returnItems[$requestItem->getOrderItemId()])) {
                $itemData[RequestItemInterface::REQUEST_QTY] = $requestItem->getRequestQty();
            }
            $returnItems[$requestItem->getOrderItemId()][] = $itemData;
        }

        $data[$request->getRequestId()]['return_items'] = array_merge($returnItems);

        $data[$request->getRequestId()][RequestInterface::TRACKING_NUMBERS] = [];
        foreach ($request->getTrackingNumbers() as $trackingNumber) {
            $data[$request->getRequestId()][RequestInterface::TRACKING_NUMBERS][] = [
                'id' => $trackingNumber->getTrackingId(),
                'customer' => $trackingNumber->isCustomer(),
                'code' => $trackingNumber->getTrackingCode(),
                'number' => $trackingNumber->getTrackingNumber()
            ];
        }
        $messageCollection = $this->messageCollectionFactory->create();
        $lastMessage = $messageCollection->addFieldToFilter(MessageInterface::REQUEST_ID, $request->getRequestId())
            ->addOrder(MessageInterface::MESSAGE_ID)
            ->addFieldToSelect(MessageInterface::MESSAGE_ID)
            ->setPageSize(1)
            ->setCurPage(1)
            ->getData();

        if ($lastMessage) {
            $data[$request->getRequestId()]['last_message_id'] = $lastMessage[0][MessageInterface::MESSAGE_ID];
        }

        $orderStore = $this->storeManager->getStore($order->getStoreId());
        $data[$request->getRequestId()]['information'] = [
            'order' => [
                'entity_id' => $order->getEntityId(),
                'increment_id' => '#' . $order->getIncrementId(),
                'created' => $order->getCreatedAt(),
                'status' => $order->getStatus(),
                'link' => $this->url->getUrl(
                    'sales/order/view',
                    ['order_id' => $order->getEntityId()]
                ),
                'direct_link' => $this->frontendUrl->setScope($request->getStoreId())->getUrl(
                    $this->configProvider->getUrlPrefix($request->getStoreId()) . '/guest/view',
                    ['request' => $request->getUrlHash(), '_nosid' => true]
                ),
                'store' => [
                    'website' => $this->storeManager->getWebsite($orderStore->getWebsiteId())->getName(),
                    'group' => $this->storeManager->getGroup($orderStore->getStoreGroupId())->getName(),
                    'view' => $orderStore->getName()
                ]
            ],
            'customer' => [
                'name' => $order->getBillingAddress()->getFirstname() . ' '
                    . $order->getBillingAddress()->getLastname(),
                'address' => $this->addressRenderer->format($order->getBillingAddress(), 'html'),
                'email' => $order->getBillingAddress()->getEmail(),
                'customer_group' => $this->groupRepository->getById($order->getCustomerGroupId())->getCode()
            ]
        ];
        if ($shippingLabel = $request->getShippingLabel()) {
            $data[$request->getRequestId()][RequestInterface::SHIPPING_LABEL] = [
                [
                    'name' => $shippingLabel,
                    'url' => $this->fileUpload->getLabelUrl($shippingLabel, $request->getRequestId()),
                    'previewUrl' => $this->assetRepository->getUrl('Amasty_Rma::images/shipping.png')
                ]
            ];
        }
        return $data;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();
        if ($requestId = $this->httpRequest->getParam('request_id')) {
            try {
                $request = $this->requestRepository->getById($requestId);
                if ($customFields = $this->configProvider->getCustomFields($request->getStoreId())) {
                    $meta['rma_details']['arguments']['data']['config']['custom_fields_label'] =
                        $this->configProvider->getCustomFieldsLabel($request->getStoreId()) ?: __('Custom Fields');
                }

                if ($quickReplies = $this->configProvider->getQuickReplies($request->getStoreId())) {
                    foreach ($quickReplies as $key => $quickReply) {
                        $meta['chat_container']['children']['message']['arguments']['data']['config']
                            ['quick_replies'][] = ['value' => $key, 'label' => $quickReply];
                    }
                }

                if ($carriers = $this->configProvider->getCarriers($request->getStoreId())) {
                    $meta['tracking_details']['children']['tracking']
                    ['arguments']['data']['config']['carriers'] = $carriers;

                }
                //Items To Return Meta
                $meta['rma_return_order']['arguments']['data']['config']['header'] = [
                    __('Product'),
                    __('RMA Details'),
                    __('Who Pays for Shipping'),
                    __('Return QTY'),
                    __('Authorized'),
                    __('Received'),
                    __('Resolved'),
                    __('Reject'),
                    __('Action')
                ];

                $meta['rma_return_order']['arguments']['data']['config']['resolutions'] =
                    $this->formInformation->getResolutionList();
                $meta['rma_return_order']['arguments']['data']['config']['conditions'] =
                    $this->formInformation->getConditionList();
                $meta['rma_return_order']['arguments']['data']['config']['reasons'] =
                    $this->formInformation->getReasonList();
            } catch (\Exception $e) {
                null;
            }
        }

        return $meta;
    }
}
