<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Plugin\DisplayRmaInfo;

use Amasty\Rma\Model\ConfigProvider;
use Amasty\Rma\Model\ReturnRules\ReturnRulesProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class DisplayProductPage
 */
class DisplayProductPage
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ReturnRulesProcessor
     */
    private $returnRulesProcessor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        ConfigProvider $configProvider,
        ReturnRulesProcessor $returnRulesProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->configProvider = $configProvider;
        $this->returnRulesProcessor = $returnRulesProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Catalog\Block\Product\View\Attributes $subject
     * @param array $data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetAdditionalData($subject, $data)
    {
        if (!$this->configProvider->isEnabled()
            && !$this->configProvider->isShowRmaInfoProductPage($this->storeManager->getStore()->getId())
        ) {
            return $data;
        }
        $resolutions = $this->returnRulesProcessor->getResolutionsForProduct($subject->getProduct());

        foreach ($resolutions as $resolutionData) {
            $resolution = $resolutionData['resolution'];
            $resolutionValue = $resolutionData['value'];
            $data['resolution_' . $resolution->getResolutionId()] =
                $this->prepareResolutionArray($resolution, $resolutionValue);
        }

        return $data;
    }

    /**
     * @param \Amasty\Rma\Model\Resolution\Resolution $resolution
     * @param int $value
     *
     * @return array
     */
    private function prepareResolutionArray($resolution, $value)
    {
        return [
            'code' => 'resolution_' . $resolution->getResolutionId(),
            'label' => $resolution->getLabel() . ' period',
            'value' => $value . ' days'
        ];
    }
}
