<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Utils;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Email
 */
class Email
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ScopeConfigInterface
     */
    private $configProvider;

    public function __construct(
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        LoggerInterface $logger,
        ScopeConfigInterface $configProvider
    ) {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $logger;
        $this->configProvider = $configProvider;
    }

    public function sendEmail(
        $emailTo = '',
        $storeId = 0,
        $templateIdentifier = '',
        $vars = [],
        $area = \Magento\Framework\App\Area::AREA_FRONTEND,
        $sendFrom = ''
    ) {
        try {
            /** @var \Magento\Store\Model\Store $store */
            $store = $this->storeManager->getStore($storeId);
            $data =  array_merge(
                [
                    'website_name'  => $store->getWebsite()->getName(),
                    'group_name'    => $store->getGroup()->getName(),
                    'store_name'    => $store->getName(),
                ],
                $vars
            );

            if (empty($sendFrom)) {
                $sendFrom = 'general';
            }

            if (!is_array($emailTo)) {
                $emailTo = [$emailTo];
            }

            foreach ($emailTo as $reciever) {
                $transport = $this->transportBuilder->setTemplateIdentifier(
                    $templateIdentifier
                )->setTemplateOptions(
                    ['area' => $area, 'store' => $store->getId()]
                )->setTemplateVars(
                    $data
                )->setFrom(
                    $sendFrom
                )->addTo(
                    $reciever
                )->getTransport();

                $transport->sendMessage();
            }
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }
}
