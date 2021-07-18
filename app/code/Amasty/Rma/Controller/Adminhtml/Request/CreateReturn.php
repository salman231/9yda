<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Controller\Adminhtml\Request;

use Amasty\Rma\Api\CreateReturnProcessorInterface;
use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\RequestItemInterface;
use Amasty\Rma\Api\RequestRepositoryInterface;
use Amasty\Rma\Controller\Adminhtml\RegistryConstants;
use Amasty\Rma\Model\ConfigProvider;
use Amasty\Rma\Model\OptionSource\ItemStatus;
use Magento\Backend\App\Action;
use Psr\Log\LoggerInterface;

/**
 * Class CreateReturn
 */
class CreateReturn extends Action
{
    const ADMIN_RESOURCE = 'Amasty_Rma::rma_create';

    /**
     * @var RequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * @var CreateReturnProcessorInterface
     */
    private $createReturnProcessor;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        RequestRepositoryInterface $requestRepository,
        ConfigProvider $configProvider,
        CreateReturnProcessorInterface $createReturnProcessor,
        LoggerInterface $logger,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->requestRepository = $requestRepository;
        $this->createReturnProcessor = $createReturnProcessor;
        $this->configProvider = $configProvider;
        $this->logger = $logger;
    }

    public function execute()
    {
        $orderId = $this->getRequest()->getParam(RequestInterface::ORDER_ID);
        $items = $this->getRequest()->getParam('return_items');

        if ($this->getRequest()->getParams() && $orderId && $items) {
            if ($returnOrder = $this->createReturnProcessor->process($orderId, true)) {
                $request = $this->requestRepository->getEmptyRequestModel();
                $request->setNote($this->getRequest()->getParam(RequestInterface::NOTE, ''))
                    ->setStatus($this->getRequest()->getParam(RequestInterface::STATUS))
                    ->setCustomerId($returnOrder->getOrder()->getCustomerId())
                    ->setManagerId($this->getRequest()->getParam(RequestInterface::MANAGER_ID))
                    ->setOrderId($orderId)
                    ->setStoreId($returnOrder->getOrder()->getStoreId())
                    ->setCustomerName(
                        $returnOrder->getOrder()->getBillingAddress()->getFirstname()
                        . ' ' . $returnOrder->getOrder()->getBillingAddress()->getLastname()
                    );

                if ($customFields = $this->configProvider->getCustomFields($request->getStoreId())) {
                    $customFieldsData = [];
                    $formCustomFields = $this->getRequest()->getParam(RequestInterface::CUSTOM_FIELDS, []);
                    foreach ($customFields as $code => $label) {
                        if (!empty($formCustomFields[$code])) {
                            $customFieldsData[$code] = $formCustomFields[$code];
                        }
                    }
                    $request->setCustomFields($customFieldsData);
                }

                $items = $this->processItems($returnOrder->getItems(), $items);
                if ($items) {
                    $request->setRequestItems($items);

                    try {
                        $this->requestRepository->save($request);

                        return $this->_redirect(
                            'amrma/request/view',
                            [RegistryConstants::REQUEST_ID => $request->getRequestId()]
                        );
                    } catch (\Exception $e) {
                        $this->logger->critical($e);
                    }
                }
            }
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }

    /**
     * @param \Amasty\Rma\Api\Data\ReturnOrderItemInterface[] $orderItems
     * @param array $items
     *
     * @return \Amasty\Rma\Api\Data\RequestItemInterface[]
     */
    public function processItems($orderItems, $items)
    {
        $result = [];
        foreach ($items as $itemGroup) {
            if ($item = $this->processItemGroup($orderItems, $itemGroup)) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @param \Amasty\Rma\Api\Data\ReturnOrderItemInterface[] $orderItems
     * @param array $itemGroup
     *
     * @return \Amasty\Rma\Api\Data\RequestItemInterface|bool
     */
    public function processItemGroup($orderItems, $itemGroup)
    {
        foreach ($itemGroup as $item) {
            if (!empty($item[RequestItemInterface::REQUEST_ITEM_ID])
                && !empty($item[RequestItemInterface::QTY])
                && !empty($item[RequestItemInterface::CONDITION_ID])
                && !empty($item[RequestItemInterface::REASON_ID])
                && !empty($item[RequestItemInterface::RESOLUTION_ID])
                && $orderItem = $this->getOrderItemByOrderItemId($orderItems, (int)$item['order_item_id'])
            ) {
                if ($orderItem->getAvailableQty() > 0.0001
                    && $orderItem->getAvailableQty() >= (double)$item[RequestItemInterface::QTY]) {
                    if (!empty($item[RequestItemInterface::ITEM_STATUS])
                        && $item[RequestItemInterface::ITEM_STATUS] == 'true'
                    ) {
                        $itemStatus = ItemStatus::AUTHORIZED;
                    } else {
                        $itemStatus = 0;
                    }

                    $requestItem = $this->requestRepository->getEmptyRequestItemModel();
                    $requestItem->setItemStatus($itemStatus)
                        ->setOrderItemId($orderItem->getItem()->getItemId())
                        ->setConditionId($item[RequestItemInterface::CONDITION_ID])
                        ->setReasonId($item[RequestItemInterface::REASON_ID])
                        ->setResolutionId($item[RequestItemInterface::RESOLUTION_ID])
                        ->setRequestQty($item[RequestItemInterface::QTY])
                        ->setQty($item[RequestItemInterface::QTY]);

                    return $requestItem;
                }
            }
        }

        return false;
    }

    /**
     * @param \Amasty\Rma\Api\Data\ReturnOrderItemInterface[] $orderItems
     * @param int $orderItemId
     *
     * @return \Amasty\Rma\Api\Data\ReturnOrderItemInterface|bool
     */
    public function getOrderItemByOrderItemId($orderItems, $orderItemId)
    {
        foreach ($orderItems as $orderItem) {
            if ((int)$orderItem->getItem()->getItemId() === $orderItemId) {
                return $orderItem;
            }
        }

        return false;
    }
}
