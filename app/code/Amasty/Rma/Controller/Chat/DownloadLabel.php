<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Controller\Chat;

use Amasty\Rma\Api\CustomerRequestRepositoryInterface;
use Amasty\Rma\Controller\Adminhtml\RegistryConstants;
use Amasty\Rma\Utils\FileUpload;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Response\Http\FileFactory;

/**
 * Class DownloadLabel
 */
class DownloadLabel extends Action
{
    /**
     * @var CustomerRequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * @var FileUpload
     */
    private $fileUpload;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    public function __construct(
        CustomerRequestRepositoryInterface $requestRepository,
        FileUpload $fileUpload,
        Filesystem $filesystem,
        FileFactory $fileFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->requestRepository = $requestRepository;
        $this->fileUpload = $fileUpload;
        $this->filesystem = $filesystem;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        $hash = $this->getRequest()->getParam('hash');
        $requestId = (int)$this->getRequest()->getParam(RegistryConstants::REQUEST_ID);

        if ($hash && $requestId) {
            $request = $this->requestRepository->getByHash($hash);
            $file = $request->getShippingLabel();

            if (!$file) {
                return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
            }
            $relativePath = $this->filesystem->getDirectoryRead(
                DirectoryList::MEDIA
            )->getRelativePath(FileUpload::MEDIA_PATH . $requestId . DIRECTORY_SEPARATOR . $file);

            try {
                $this->fileFactory->create(
                    "shipping-label-$requestId",
                    [
                        'type' => 'filename',
                        'value' => $relativePath
                    ],
                    DirectoryList::MEDIA
                );
            } catch (\Exception $e) {
                return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
            }
            /** @codingStandardsIgnoreStart */
            exit(0);
            /** @codingStandardsIgnoreEnd */
        }

        return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
    }
}
