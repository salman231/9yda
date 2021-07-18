<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Controller\Adminhtml\Request\ShippingLabel;

use Amasty\Rma\Utils\FileUpload;
use Amasty\Rma\Model\Request\Repository;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Delete
 */
class Delete extends Action
{
    /**
     * @var FileUpload
     */
    private $fileUpload;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(
        Action\Context $context,
        FileUpload $fileUpload,
        Repository $repository
    ) {
        parent::__construct($context);
        $this->fileUpload = $fileUpload;
        $this->repository = $repository;
    }

    public function execute()
    {
        if (!$requestId = $this->getRequest()->getParam('request_id')) {
            return null;
        }
        $request = $this->repository->getById($requestId);

        if (!$shippingLabel = $request->getShippingLabel()) {
            return null;
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result = $this->fileUpload->deleteShippingLabel($shippingLabel, $requestId);

        if ($result) {
            $request->setShippingLabel(null);
            $this->repository->save($request);

            return $resultJson->setData(['deleted' => true]);
        } else {
            return $resultJson->setData(['deleted' => false]);
        }
    }
}
