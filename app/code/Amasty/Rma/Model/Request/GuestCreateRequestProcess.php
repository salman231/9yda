<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request;

use Amasty\Rma\Api\GuestCreateRequestProcessInterface;

/**
 * Class GuestCreateRequestProcess
 */
class GuestCreateRequestProcess implements GuestCreateRequestProcessInterface
{
    /**
     * @var ResourceModel\GuestCreateRequest
     */
    private $guestCreateRequestResource;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var \Amasty\Rma\Api\Data\GuestCreateRequestInterfaceFactory
     */
    private $createRequestFactory;

    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Amasty\Rma\Api\Data\GuestCreateRequestInterfaceFactory $createRequestFactory,
        \Amasty\Rma\Model\Request\ResourceModel\GuestCreateRequest $guestCreateRequestResource
    ) {
        $this->guestCreateRequestResource = $guestCreateRequestResource;
        $this->orderRepository = $orderRepository;
        $this->createRequestFactory = $createRequestFactory;
    }

    /**
     * @inheritdoc
     */
    public function process(\Amasty\Rma\Api\Data\GuestCreateRequestInterface $guestCreateRequest)
    {
        try {
            $continue = true;
            $order = $this->orderRepository->get((int)$guestCreateRequest->getOrderId());

            if (mb_strtolower($order->getBillingAddress()->getLastname())
                !== mb_strtolower($guestCreateRequest->getBillingLastName())
            ) {
                $continue = false;
            }

            if (!empty($guestCreateRequest->getEmail())
                && mb_strtolower($order->getCustomerEmail())
                !== mb_strtolower($guestCreateRequest->getEmail())
            ) {
                $continue = false;
            }

            if (!empty($guestCreateRequest->getZip())
                && mb_strtolower($order->getBillingAddress()->getPostcode())
                !== mb_strtolower($guestCreateRequest->getZip())
            ) {
                $continue = false;
            }

            if (!$continue) {
                return false;
            }

            //phpcs:ignore
            $guestCreateRequest->setSecretCode(md5(mt_rand()));
            $this->guestCreateRequestResource->save($guestCreateRequest);

            return $guestCreateRequest->getSecretCode();
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getEmptyCreateRequest()
    {
        return $this->createRequestFactory->create();
    }

    /**
     * @inheritdoc
     */
    public function getOrderIdBySecretKey($secretKey)
    {
        return $this->guestCreateRequestResource->findOrderBySecretKey($secretKey);
    }

    /**
     * @inheritdoc
     */
    public function deleteBySecretKey($secretKey)
    {
        $this->guestCreateRequestResource->deleteBySecretKey($secretKey);
    }
}
