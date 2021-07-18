<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Observer\Rma;

use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\StatusInterface;
use Amasty\Rma\Model\OptionSource\State;
use Amasty\Rma\Model\Status\OptionSource\AutoEvents;
use Amasty\Rma\Observer\RmaEventNames;
use Magento\Framework\Data\Collection;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AutoStatusChange
 */
class AutoStatusChange implements ObserverInterface
{
    /**
     * @var \Amasty\Rma\Api\StatusRepositoryInterface
     */
    private $statusRepository;

    /**
     * @var \Amasty\Rma\Api\RequestRepositoryInterface
     */
    private $requestRepository;

    public function __construct(
        \Amasty\Rma\Api\StatusRepositoryInterface $statusRepository,
        \Amasty\Rma\Api\RequestRepositoryInterface $requestRepository
    ) {
        $this->statusRepository = $statusRepository;
        $this->requestRepository = $requestRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $autoEvent = false;
        switch ($observer->getEvent()->getName()) {
            case RmaEventNames::NEW_CHAT_MESSAGE:
                $autoEvent = AutoEvents::CUSTOMER_ADDED_COMMENT;
                break;
            case RmaEventNames::TRACKING_NUBMER_ADDED:
                $autoEvent = AutoEvents::CUSTOMER_ADDED_TRACKING_NUMBER;
                break;
            case RmaEventNames::RMA_RATED:
                $autoEvent = AutoEvents::CUSTOMER_RATED_RMA;
                break;
            case RmaEventNames::RMA_CANCELED:
                $autoEvent = AutoEvents::CUSTOMER_CANCELED_RMA;
                break;
        }

        /** @var \Amasty\Rma\Api\Data\RequestInterface $request */
        if ($autoEvent && ($request = $observer->getData('request'))) {
            if ($autoEvent == AutoEvents::CUSTOMER_CANCELED_RMA) {
                $statusCollection = $this->statusRepository->getEmptyStatusCollection();
                $statusCollection->addFieldToFilter(StatusInterface::IS_ENABLED, 1)
                    ->addFieldToFilter(StatusInterface::AUTO_EVENT, (int)$autoEvent)
                    ->addFieldToFilter(StatusInterface::STATE, State::CANCELED)
                    ->setPageSize(1)
                    ->setCurPage(1);
            } else {
                $currentStatus = $this->statusRepository->getById($request->getStatus());
                $statusCollection = $this->statusRepository->getEmptyStatusCollection();
                $statusCollection->addFieldToFilter(StatusInterface::IS_ENABLED, 1)
                    ->addFieldToFilter(StatusInterface::AUTO_EVENT, (int)$autoEvent)
                    ->setPageSize(1)
                    ->setCurPage(1);
                $statusCollection->getSelect()->order(
                    new \Zend_Db_Expr(
                        'FIELD(main_table.' . StatusInterface::STATE . ', ' . $currentStatus->getState() . ') DESC, '
                        . 'main_table.' . StatusInterface::STATE . ' ASC'
                    )
                );
            }
            /** @var \Amasty\Rma\Api\Data\StatusInterface $status */
            $status = $statusCollection->fetchItem();
            if ($status && ($status->getStatusId() != $request->getStatus())) {
                $request->setStatus($status->getStatusId());
                $this->requestRepository->save($request);
                $request->setOrigData(RequestInterface::STATUS, $request->getStatus());
            }
        }
    }
}
