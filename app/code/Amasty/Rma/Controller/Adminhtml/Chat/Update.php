<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Controller\Adminhtml\Chat;

use Amasty\Rma\Api\ChatRepositoryInterface;
use Amasty\Rma\Model\Request\CustomerRequestRepository;
use Amasty\Rma\Utils\FileUpload;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Update
 */
class Update extends \Magento\Backend\App\Action
{
    /**
     * @var ChatRepositoryInterface
     */
    private $chatRepository;

    /**
     * @var CustomerRequestRepository
     */
    private $customerRequestRepository;

    /**
     * @var FileUpload
     */
    private $fileUpload;

    public function __construct(
        ChatRepositoryInterface $chatRepository,
        CustomerRequestRepository $customerRequestRepository,
        FileUpload $fileUpload,
        Context $context
    ) {
        parent::__construct($context);
        $this->chatRepository = $chatRepository;
        $this->customerRequestRepository = $customerRequestRepository;
        $this->fileUpload = $fileUpload;
    }

    public function execute()
    {
        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        if ($hash = $this->getRequest()->getParam('hash')) {
            try {
                $request = $this->customerRequestRepository->getByHash($hash);
            } catch (\Exception $e) {
                return $response->setData([]);
            }
            $result = [];
            foreach ($this->chatRepository->getMessagesByRequestId(
                $request->getRequestId(),
                $this->getRequest()->getParam('lastId'),
                false
            ) as $message) {
                $result[] = [
                    'is_manager' => $message->isManager(),
                    'left' => !$message->isManager(),
                    'is_system' => $message->isSystem(),
                    'message' => $message->getMessage(),
                    'username' => $message->getName(),
                    'created' => $message->getCreatedAt(),
                    'files' => $this->fileUpload
                        ->prepareMessageFiles($message->getMessageFiles(), $request->getRequestId(), true),
                    'message_id' => $message->getMessageId()
                ];
            }

            return $response->setData($result);
        }

        return $response->setData([]);
    }
}
