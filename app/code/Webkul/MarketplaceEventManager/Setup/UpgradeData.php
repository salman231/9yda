<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var Magento\Sales\Setup\SalesSetupFactory
     */
    protected $_salesSetupFactory;
 
    /**
     * @var Magento\Quote\Setup\QuoteSetupFactory
     */
    protected $_quoteSetupFactory;

    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->_salesSetupFactory = $salesSetupFactory;
        $this->_quoteSetupFactory = $quoteSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        //add custom quote and order attributes
        $salesInstaller = $this->_salesSetupFactory
                        ->create(
                            [
                                'setup' => $setup
                            ]
                        );
        /** @var \Magento\Quote\Setup\QuoteSetup $quoteInstaller */
        $quoteInstaller = $this->_quoteSetupFactory
                        ->create(
                            [
                                'setup' => $setup
                            ]
                        );
 
        $this->addQuoteAttributes($quoteInstaller);
        $this->addOrderAttributes($salesInstaller);
    }

    /**
     * add attribute in quote address
     * @param object $installer
     */
    public function addQuoteAttributes($installer)
    {
        $installer->addAttribute('quote_item', 'wkmp_event_start', ['type' => 'text']);
        $installer->addAttribute('quote_item', 'wkmp_event_end', ['type' => 'text']);
        $installer->addAttribute('quote_item', 'wkmp_event_location', ['type' => 'text']);
        $installer->addAttribute('quote_item', 'wkmp_event_qrprefix', ['type' => 'text']);
    }
 
    /**
     * add attribute in sales_order
     * @param object $installer
     */
    public function addOrderAttributes($installer)
    {
        $installer->addAttribute('order_item', 'wkmp_event_start', ['type' => 'text']);
        $installer->addAttribute('order_item', 'wkmp_event_end', ['type' => 'text']);
        $installer->addAttribute('order_item', 'wkmp_event_location', ['type' => 'text']);
        $installer->addAttribute('order_item', 'wkmp_event_qrprefix', ['type' => 'text']);
    }
}
