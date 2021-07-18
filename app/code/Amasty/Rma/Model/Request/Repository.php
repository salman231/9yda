<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request;

use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\RequestItemInterface;
use Amasty\Rma\Api\RequestRepositoryInterface;
use Amasty\Rma\Api\StatusRepositoryInterface;
use Amasty\Rma\Observer\RmaEventNames;
use Magento\Framework\Data\Collection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Repository
 */
class Repository implements RequestRepositoryInterface
{
    /**
     * @var \Amasty\Rma\Api\Data\RequestInterfaceFactory
     */
    private $requestFactory;

    /**
     * @var \Amasty\Rma\Api\Data\RequestItemInterfaceFactory
     */
    private $requestItemFactory;

    /**
     * @var \Amasty\Rma\Api\Data\TrackingInterfaceFactory
     */
    private $trackingFactory;

    /**
     * @var ResourceModel\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ResourceModel\RequestItemCollectionFactory
     */
    private $requestItemCollectionFactory;

    /**
     * @var ResourceModel\TrackingCollectionFactory
     */
    private $trackingCollectionFactory;

    /**
     * @var ResourceModel\Request
     */
    private $requestResource;

    /**
     * @var ResourceModel\RequestItem
     */
    private $requestItemResource;

    /**
     * @var \Amasty\Rma\Api\Data\RequestInterface[]
     */
    private $requests;

    /**
     * @var StatusRepositoryInterface
     */
    private $statusRepository;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * @var ResourceModel\Tracking
     */
    private $trackingResource;

    public function __construct(
        \Amasty\Rma\Api\Data\RequestInterfaceFactory $requestFactory,
        \Amasty\Rma\Api\Data\RequestItemInterfaceFactory $requestItemFactory,
        \Amasty\Rma\Api\Data\TrackingInterfaceFactory $trackingFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Amasty\Rma\Api\StatusRepositoryInterface $statusRepository,
        \Amasty\Rma\Model\Request\ResourceModel\Request $requestResource,
        \Amasty\Rma\Model\Request\ResourceModel\Tracking $trackingResource,
        \Amasty\Rma\Model\Request\ResourceModel\RequestItem $requestItemResource,
        \Amasty\Rma\Model\Request\ResourceModel\CollectionFactory $collectionFactory,
        \Amasty\Rma\Model\Request\ResourceModel\RequestItemCollectionFactory $requestItemCollectionFactory,
        \Amasty\Rma\Model\Request\ResourceModel\TrackingCollectionFactory $trackingCollectionFactory
    ) {
        $this->requestFactory = $requestFactory;
        $this->requestItemFactory = $requestItemFactory;
        $this->trackingFactory = $trackingFactory;
        $this->collectionFactory = $collectionFactory;
        $this->requestItemCollectionFactory = $requestItemCollectionFactory;
        $this->trackingCollectionFactory = $trackingCollectionFactory;
        $this->requestResource = $requestResource;
        $this->requestItemResource = $requestItemResource;
        $this->statusRepository = $statusRepository;
        $this->eventManager = $eventManager;
        $this->trackingResource = $trackingResource;
    }

    /**
     * @inheritdoc
     */
    public function getById($requestId)
    {
        if (!isset($this->requests[$requestId])) {
            /** @var \Amasty\Rma\Api\Data\RequestInterface $request */
            $request = $this->requestFactory->create();
            $this->requestResource->load($request, $requestId);
            if (!$request->getRequestId()) {
                throw new NoSuchEntityException(__('Request with specified ID "%1" not found.', $requestId));
            }
            /** @var ResourceModel\RequestItemCollection $requestItemCollection */
            $requestItemCollection = $this->requestItemCollectionFactory->create();
            $requestItemCollection->addFieldToFilter(
                RequestItemInterface::REQUEST_ID,
                $request->getRequestId()
            )->addOrder(RequestItemInterface::REQUEST_ITEM_ID, Collection::SORT_ORDER_ASC)
            ->addOrder(RequestItemInterface::ORDER_ITEM_ID, Collection::SORT_ORDER_ASC);
            $request->setRequestItems($requestItemCollection->getItems());

            /** @var ResourceModel\TrackingCollection $trackingCollection */
            $trackingCollection = $this->trackingCollectionFactory->create();
            $trackingCollection->addFieldToFilter(
                RequestItemInterface::REQUEST_ID,
                $request->getRequestId()
            );
            $request->setTrackingNumbers($trackingCollection->getItems());

            $this->requests[$requestId] = $request;
        }

        return $this->requests[$requestId];
    }

    /**
     * @inheritDoc
     */
    public function getByHash($hash)
    {
        if (!($requestId = $this->requestResource->getRequestIdByHash($hash))) {
            throw new NoSuchEntityException(__('Request doesn\'t exsists'));
        }
        $request = $this->getById((int)$requestId);

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function save(\Amasty\Rma\Api\Data\RequestInterface $request)
    {
        try {
            $itemsToDelete = [];
            if ($request->getRequestId()) {
                $request = $this->getById($request->getRequestId())->addData($request->getData());
            } else {
                //phpcs:ignore
                $request->setUrlHash(md5(mt_rand()));
            }

            if (!$request->getStatus()) {
                $request->setStatus($this->statusRepository->getInitialStatusId());
            }

            $this->requestResource->save($request);

            $requestItemIds = [];
            foreach ($request->getRequestItems() as $item) {
                $item->setRequestId($request->getRequestId());
                $this->requestItemResource->save($item);
                $requestItemIds[] = $item->getRequestItemId();
            }
            $this->requestItemResource->removeDeletedItems($request->getRequestId(), $requestItemIds);

            $origRating = $request->getOrigData(RequestInterface::RATING);
            if (!$origRating && $request->getRating()) {
                $this->eventManager->dispatch(
                    RmaEventNames::RMA_RATED,
                    ['request' => $request]
                );
            }

            $origStatus = (int)$request->getOrigData(RequestInterface::STATUS);
            if ($origStatus !== null && $origStatus !== $request->getStatus()) {
                $this->eventManager->dispatch(
                    RmaEventNames::STATUS_CHANGED,
                    ['request' => $request, 'original_status' => $origStatus, 'new_status' => $request->getStatus()]
                );
            }

            unset($this->requests[$request->getRequestId()]);
        } catch (\Exception $e) {
            if ($request->getRequestId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save request with ID %1. Error: %2',
                        [$request->getRequestId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new request. Error: %1', $e->getMessage()));
        }

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function saveTracking(\Amasty\Rma\Api\Data\TrackingInterface $tracking)
    {
        try {
            $this->trackingResource->save($tracking);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save new request. Error: %1', $e->getMessage()));
        }

        return $tracking;
    }

    /**
     * @inheritDoc
     */
    public function getTrackingById($trackingId)
    {
        /** @var \Amasty\Rma\Api\Data\TrackingInterface $tracking */
        $tracking = $this->trackingFactory->create();
        $this->trackingResource->load($tracking, $trackingId);
        if (!$tracking->getTrackingId()) {
            throw new NoSuchEntityException(__('Request with specified ID "%1" not found.', $trackingId));
        }

        return $tracking;
    }

    /**
     * @inheritDoc
     */
    public function deleteTrackingById($trackingId)
    {
        $this->trackingResource->delete($this->getTrackingById($trackingId));
    }

    /**
     * @inheritdoc
     */
    public function getEmptyRequestModel()
    {
        return $this->requestFactory->create();
    }

    /**
     * @inheritdoc
     */
    public function getEmptyRequestItemModel()
    {
        return $this->requestItemFactory->create();
    }

    /**
     * @inheritdoc
     */
    public function getEmptyTrackingModel()
    {
        return $this->trackingFactory->create();
    }
}
