<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Controller\Adminhtml\TrackingNumber;

use Amasty\Rma\Api\CustomerRequestRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Save
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var CustomerRequestRepositoryInterface
     */
    private $requestRepository;

    public function __construct(
        CustomerRequestRepositoryInterface $requestRepository,
        Context $context
    ) {
        parent::__construct($context);
        $this->requestRepository = $requestRepository;
    }

    public function execute()
    {
        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $number = $this->getRequest()->getParam('number');
        $code = $this->getRequest()->getParam('code');
        if (($hash = $this->getRequest()->getParam('hash')) && $number && $code) {
            $tracking = $this->requestRepository->getEmptyTrackingModel();
            $tracking->setTrackingCode($code)
                ->setTrackingNumber($number)
                ->setIsCustomer(false);
            try {
                $this->requestRepository->saveTracking($hash, $tracking);
            } catch (\Exception $e) {
                return $response->setData([]);
            }

            return $response->setData(['success' => true, 'id' => $tracking->getTrackingId()]);
        }

        return $response->setData([]);
    }
}
