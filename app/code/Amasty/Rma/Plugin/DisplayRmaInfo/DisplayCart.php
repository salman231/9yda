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
 * Class DisplayCart
 */
class DisplayCart
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
     * @param \Magento\Checkout\Block\Cart\Item\Renderer $subject
     * @param array $result
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetOptionList($subject, $result)
    {
        if (!$this->configProvider->isEnabled()
            && !$this->configProvider->isShowRmaInfoCart($this->storeManager->getStore()->getId())
        ) {
            return $result;
        }
        $resolutions = $this->returnRulesProcessor->getResolutionsForProduct($subject->getProduct());

        foreach ($resolutions as $resolutionData) {
            $result[] = [
                'label' => $resolutionData['resolution']->getLabel() . ' period',
                'value' => $resolutionData['value'] . ' days'
            ];
        }

        return $result;
    }
}
