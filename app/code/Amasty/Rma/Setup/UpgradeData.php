<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Setup;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class UpgradeData
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var Operation\UpgradeDataTo200
     */
    private $upgradeDataTo200;

    /**
     * @var State
     */
    private $appState;

    public function __construct(
        Operation\UpgradeDataTo200 $upgradeDataTo200,
        State $appState
    ) {
        $this->upgradeDataTo200 = $upgradeDataTo200;
        $this->appState = $appState;
    }

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     * @throws \Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (!$context->getVersion() || version_compare($context->getVersion(), '2.0.0', '<')) {
            $this->appState->emulateAreaCode(
                Area::AREA_ADMINHTML,
                [$this->upgradeDataTo200, 'execute'],
                [$setup, $context->getVersion()]
            );
        }
    }
}
