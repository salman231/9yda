<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request\DataProvider;

use Amasty\Rma\Api\CreateReturnProcessorInterface;
use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\RequestItemInterface;
use Amasty\Rma\Controller\Adminhtml\RegistryConstants;
use Amasty\Rma\Model\ConfigProvider;
use Amasty\Rma\Model\OptionSource\NoReturnableReasons;
use Amasty\Rma\Model\Request\ResourceModel\CollectionFactory;
use Magento\Catalog\Helper\Image;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\App\RequestInterface as HttpRequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class CreateForm
 */
class CreateForm extends AbstractDataProvider
{
    /**
     * @var CreateReturnProcessorInterface
     */
    private $createReturnProcessor;

    /**
     * @var HttpRequestInterface
     */
    private $request;

    /**
     * @var \Amasty\Rma\Api\Data\ReturnOrderInterface
     */
    private $returnOrder;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

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
     * @var Image
     */
    private $imageHelper;

    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var Data\FormInformation
     */
    private $formInformation;

    public function __construct(
        CreateReturnProcessorInterface $createReturnProcessor,
        HttpRequestInterface $request,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        GroupRepositoryInterface $groupRepository,
        AddressRenderer $addressRenderer,
        ConfigProvider $configProvider,
        Image $imageHelper,
        Data\FormInformation $formInformation,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->createReturnProcessor = $createReturnProcessor;
        $this->request = $request;
        $this->configProvider = $configProvider;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->addressRenderer = $addressRenderer;
        $this->imageHelper = $imageHelper;
        $this->groupRepository = $groupRepository;
        $this->formInformation = $formInformation;
    }

    public function getData()
    {
        $order = $this->returnOrder->getOrder();
        $orderStore = $this->storeManager->getStore($order->getStoreId());
        $data[null]['return_items'] = [];
        foreach ($this->returnOrder->getItems() as $item) {
            $tempItem = clone $item;
            $itemData = $tempItem->getData();
            unset($itemData['product_item']);
            unset($itemData['item']);
            if ($item->getProductItem()) {
                $image = $this->imageHelper->init(
                    $item->getProductItem(),
                    'product_thumbnail_image'
                )->getUrl();
            } else {
                $image = false;
            }
            $itemData = [
                RequestItemInterface::REQUEST_ITEM_ID => $item->getItem()->getItemId(),
                'name' => $item->getItem()->getName(),
                'sku' => $item->getItem()->getSku(),
                'url' => $this->url->getUrl(
                    'catalog/product/edit',
                    ['id' => $item->getItem()->getProductId()]
                ),
                'shipped_qty' => (double)$item->getItem()->getQtyShipped(),
                'refunded_qty' => (double)$item->getItem()->getQtyRefunded(),
                RequestItemInterface::REQUEST_QTY => (double)$item->getAvailableQty(),
                RequestItemInterface::QTY =>  (double)$item->getAvailableQty(),
                RequestItemInterface::ORDER_ITEM_ID => $item->getItem()->getItemId(),
                RequestItemInterface::ITEM_STATUS  => 0,
                'is_decimal' => (bool)$item->getItem()->getIsQtyDecimal(),
                'image' => $image,
                'is_returnable' => $item->isReturnable(),
                'no_returnable_reason' => $item->getNoReturnableReason(),
                RequestItemInterface::CONDITION_ID => '',
                RequestItemInterface::REASON_ID => '',
                RequestItemInterface::RESOLUTION_ID => ''
            ];
            if (!$item->isReturnable() && ($item->getNoReturnableReason() === NoReturnableReasons::ALREADY_RETURNED)) {
                $itemData['previous_requests'] = [];
                foreach ($item->getNoReturnableData() as $request) {
                    $itemData['previous_requests'][] = [
                        'url' => $this->url->getUrl(
                            'amrma/request/view',
                            [RegistryConstants::REQUEST_ID => $request[RequestInterface::REQUEST_ID]]
                        ),
                        'label' => '#' . str_pad($request[RequestInterface::REQUEST_ID], 9, '0', STR_PAD_LEFT)
                    ];
                }
            }

            $data[null]['return_items'][][] = $itemData;
        }
        $data[null][RequestInterface::ORDER_ID] = $order->getEntityId();
        $data[null]['information'] = [
            'order' => [
                'entity_id' => $order->getEntityId(),
                'increment_id' => '#' . $order->getIncrementId(),
                'created' => $order->getCreatedAt(),
                'status' => $order->getStatus(),
                'link' => $this->url->getUrl(
                    'sales/order/view',
                    ['order_id' => $order->getEntityId()]
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

        return $data;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();
        $this->returnOrder = $this->createReturnProcessor->process($this->request->getParam('order_id'), true);

        $storeId = $this->returnOrder->getOrder()->getStoreId();

        if ($customFields = $this->configProvider->getCustomFields($storeId)) {
            $meta['rma_details']['children']['custom_fields']['arguments']['data']['config']['label'] =
                $this->configProvider->getCustomFieldsLabel($storeId);
            foreach ($customFields as $code => $label) {
                $meta['rma_details']['children']['custom_fields']['children']
                ['custom_fields.' . $code]['arguments']['data']['config'] = [
                    'label' => $label,
                    'dataType' => 'text',
                    'formElement' => 'input',
                    'componentType' => 'field',
                    'source' => 'custom_fields.' . $code
                ];
            }
        }

        //Items To Return Meta
        $meta['rma_return_order']['arguments']['data']['config']['header'] = [
            __('Product'),
            __('Return Reason'),
            __('Item Condition'),
            __('Resolution'),
            __('Who Pays for Shipping'),
            __('Shipped QTY'),
            __('Refunded QTY'),
            __('Return QTY'),
            __('Authorized')
        ];

        $meta['rma_return_order']['arguments']['data']['config']['resolutions'] =
            $this->formInformation->getResolutionList();
        $meta['rma_return_order']['arguments']['data']['config']['conditions'] =
            $this->formInformation->getConditionList();
        $meta['rma_return_order']['arguments']['data']['config']['reasons'] =
            $this->formInformation->getReasonList();

        return $meta;
    }
}
