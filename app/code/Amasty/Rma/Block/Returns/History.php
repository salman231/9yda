<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Block\Returns;

use Amasty\Rma\Api\Data\MessageInterface;
use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\RequestItemInterface;
use Amasty\Rma\Controller\RegistryConstants;
use Amasty\Rma\Model\Chat\ResourceModel\Message;
use Amasty\Rma\Model\Request\ResourceModel\RequestItem;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class History
 */
class History extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Amasty_Rma::account/returns/index.phtml';

    /**
     * @var bool
     */
    private $isGuest;

    /**
     * @var \Amasty\Rma\Model\Request\ResourceModel\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Amasty\Rma\Model\Request\ResourceModel\Collection
     */
    private $collection;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * @var \Amasty\Rma\Api\StatusRepositoryInterface
     */
    private $statusRepository;

    /**
     * @var \Amasty\Rma\Model\ConfigProvider
     */
    private $configProvider;

    public function __construct(
        \Amasty\Rma\Model\Request\ResourceModel\CollectionFactory $collectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Amasty\Rma\Model\ConfigProvider $configProvider,
        \Magento\Framework\Registry $registry,
        \Amasty\Rma\Api\StatusRepositoryInterface $statusRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->isGuest = !empty($data['isGuest']);
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->statusRepository = $statusRepository;
        $this->configProvider = $configProvider;
    }

    /**
     * Return Pager html for all pages
     *
     * @return string
     */
    public function getPagerHtml()
    {
        $pagerBlock = $this->getChildBlock('amasty_rma_pager');

        if ($pagerBlock instanceof \Magento\Framework\DataObject) {

            $pagerBlock->setUseContainer(
                false
            )->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setLimit(
                $this->getLimit()
            )->setCollection(
                $this->getCollection()
            );

            return $pagerBlock->toHtml();
        }

        return '';
    }

    public function getCollection()
    {
        if (!$this->collection) {
            $this->collection = $this->collectionFactory->create();
            $this->collection->join(
                'sales_order',
                'main_table.' . RequestInterface::ORDER_ID . ' = sales_order.' . OrderInterface::ENTITY_ID,
                [OrderInterface::INCREMENT_ID]
            );
            if ($this->isGuest) {
                $this->collection->addFieldToFilter(
                    'sales_order.' . OrderInterface::CUSTOMER_EMAIL,
                    $this->registry->registry(RegistryConstants::GUEST_DATA)['email']
                )->join(
                    'sales_order_address',
                    'main_table.order_id = sales_order_address.parent_id'
                    . ' and sales_order_address.address_type = \'billing\'',
                    []
                )->addFieldToFilter(
                    'sales_order_address.' . OrderAddressInterface::LASTNAME,
                    $this->registry->registry(RegistryConstants::GUEST_DATA)['lastname']
                );
            } else {
                $this->collection->addFieldToFilter(
                    'main_table.' . RequestInterface::CUSTOMER_ID,
                    $this->customerSession->getCustomerId()
                );
            }
            $this->collection->join(
                RequestItem::TABLE_NAME,
                'main_table.' . RequestInterface::REQUEST_ID
                . ' = ' . RequestItem::TABLE_NAME . '.' . RequestItemInterface::REQUEST_ID,
                [new \Zend_Db_Expr(
                    'sum(' . RequestItem::TABLE_NAME . '.' . RequestItemInterface::QTY . ') as qty'
                )]
            )->join(
                'sales_order_item',
                RequestItem::TABLE_NAME . '.' . RequestItemInterface::ORDER_ITEM_ID
                . '=' . 'sales_order_item.' . OrderItemInterface::ITEM_ID,
                ['sales_order_item.' . OrderItemInterface::PRODUCT_ID]
            );

            $this->collection->getSelect()->group('main_table.' . RequestInterface::REQUEST_ID);

            $this->collection->getSelect()->columns([
                new \Zend_Db_Expr(
                    '(select count(*) from ' . $this->collection->getTable(Message::TABLE_NAME) .' as `mess`'
                        .' where `mess`.`' . MessageInterface::REQUEST_ID
                        . '` = `main_table`.`' . RequestInterface::REQUEST_ID . '`'
                        . ' and `mess`.`' . MessageInterface::IS_READ . '` = 0'
                        . ' and (`mess`.`' . MessageInterface::IS_MANAGER .'` = 1'
                        . ' or `mess`.`' . MessageInterface::IS_SYSTEM . '` = 1)) as `new_message`'
                )
            ]);
//            $this->collection->getSelect()->joinLeft(
//                ['is_read' => $this->collection->getTable(Message::TABLE_NAME)],
//                '`main_table`.`' . RequestInterface::REQUEST_ID
//                    . '` = `is_read`.`' . MessageInterface::REQUEST_ID . '`'
//                    . ' and `is_read`.`is_read` = 1'
//                    . ' and (`is_read`.`' . MessageInterface::IS_MANAGER . '` = 1'
//                    . ' or `is_read`.`' . MessageInterface::IS_SYSTEM . '` = 1)',
//                MessageInterface::MESSAGE_ID
//            );
            $this->collection->setOrder('main_table.' . RequestInterface::REQUEST_ID, 'DESC');
            if ($this->getLimit()) {
                $curPage = (int)$this->getRequest()->getParam('p', 1);
                $this->collection->setCurPage($curPage);
                $this->collection->setPageSize($this->getLimit());
            }
        }

        return $this->collection;
    }

    public function getLimit()
    {
        return (int)$this->getRequest()->getParam('limit', 10);
    }

    public function getProceedData()
    {
        $data = $this->getCollection()->getData();
        $statuses = $this->statusRepository->getStatusesByStoreId(
            $this->_storeManager->getStore()->getId(),
            false,
            true
        );
        foreach ($data as &$item) {
            $item['product_url'] = $this->getProductImageUrl($item['product_id']);
            $item['view_url'] = ($this->isGuest)
                ? $this->_urlBuilder->getUrl(
                    $this->configProvider->getUrlPrefix() .'/guest/view',
                    ['request' => $item[RequestInterface::URL_HASH]]
                )
                : $this->_urlBuilder->getUrl(
                    $this->configProvider->getUrlPrefix() . '/account/view',
                    ['request' => $item[RequestInterface::REQUEST_ID]]
                );
            if (!empty($statuses[$item[RequestInterface::STATUS]])) {
                $item['status_label'] = $statuses[$item[RequestInterface::STATUS]]->getLabel();
                if (preg_match(
                    '/^#[0-9a-fA-F]{3,6}$/',
                    $statuses[$item[RequestInterface::STATUS]]->getColor()
                )) {
                    $item['status_color'] = $statuses[$item[RequestInterface::STATUS]]->getColor();
                }
            }
        }

        return $data;
    }

    public function getProductImageUrl($productId)
    {
        try {
            $product = $this->productRepository->getById($productId);

            return $this->imageHelper->init($product, 'product_base_image')->getUrl();
        } catch (\Exception $e) {
            return $this->imageHelper->getDefaultPlaceholderUrl('small_image');
        }
    }
}
