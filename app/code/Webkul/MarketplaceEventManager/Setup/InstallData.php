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

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Webkul\Marketplace\Model\ControllersRepository;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * @var ControllersRepository
     */
    private $controllersRepository;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ControllersRepository $controllersRepository
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->controllersRepository = $controllersRepository;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        $attributeGroup = 'Ticket Booking';

        /**
         * Add attributes to the eav/attribute
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'event_terms',
            [
                'group'          => $attributeGroup,
                'input'          => 'textarea',
                'type'           => 'text',
                'label'          => 'Event Terms',
                'visible'        => true,
                'required'         => false,
                'user_defined'         => false,
                'searchable'         => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'required-entry',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'event_venue',
            [
                'group'          => $attributeGroup,
                'input'          => 'textarea',
                'type'           => 'text',
                'label'          => 'Event Venue',
                'visible'        => true,
                'required'         => false,
                'user_defined'         => false,
                'searchable'         => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'required-entry',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'event_start_date',
            [
                'group'          => $attributeGroup,
                'input'          => 'hidden',
                'type'           => 'datetime',
                'label'          => 'Event Start Time',
                'visible'        => true,
                'required'         => false,
                'user_defined'         => false,
                'searchable'         => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'required-entry',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'event_end_date',
            [
                'group'          => $attributeGroup,
                'input'          => 'hidden',
                'type'           => 'datetime',
                'label'          => 'Event End Time',
                'visible'        => true,
                'required'         => false,
                'user_defined'         => false,
                'searchable'         => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'required-entry',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'is_mp_event',
            [
                'group'          => $attributeGroup,
                'input'          => 'boolean',
                'type'           => 'int',
                'label'          => 'Is Event Product',
                'visible'        => true,
                'required'       => false,
                'user_defined'   => false,
                'searchable'    => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => '',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'enable_event_terms',
            [
                'group'          => $attributeGroup,
                'input'          => 'boolean',
                'type'           => 'int',
                'label'          => 'Enable Terms',
                'visible'        => true,
                'required'       => false,
                'user_defined'   => false,
                'searchable'    => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'enable_event_terms',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'event_ticket_prefix',
            [
                'group'          => $attributeGroup,
                'input'          => 'text',
                'type'           => 'varchar',
                'label'          => 'Set Ticket Prefix',
                'visible'        => true,
                'required'       => false,
                'user_defined'   => false,
                'searchable'    => false,
                'filterable'         => false,
                'comparable'         => false,
                'visible_on_front'       => false,
                'visible_in_advanced_search' => false,
                'is_html_allowed_on_front'   => false,
                'used_for_promo_rules'       => true,
                'frontend_class'       => 'event_ticket_prefix',
                'global'         => ScopedAttributeInterface::SCOPE_GLOBAL
            ]
        );
        $setup->startSetup();
        /**
         * insert marketplace event manager controller's data
         */
        $data = [];
        if (!count($this->controllersRepository->getByPath('marketplaceeventmanager/event/eventlist'))) {
            $data[] = [
                'module_name' => 'Webkul_MarketplaceEventManager',
                'controller_path' => 'marketplaceeventmanager/event/eventlist',
                'label' => 'List Of Event Tickets',
                'is_child' => '0',
                'parent_id' => '0',
            ];
        }
        if (!count($this->controllersRepository->getByPath('marketplaceeventmanager/event/add'))) {
            $data[] = [
                'module_name' => 'Webkul_MarketplaceEventManager',
                'controller_path' => 'marketplaceeventmanager/event/add',
                'label' => 'Add Event',
                'is_child' => '0',
                'parent_id' => '0',
            ];
        }
        if (!count($this->controllersRepository->getByPath('marketplaceeventmanager/event/reminder'))) {
            $data[] = [
                'module_name' => 'Webkul_MarketplaceEventManager',
                'controller_path' => 'marketplaceeventmanager/event/reminder',
                'label' => 'Ticket Reminder Page',
                'is_child' => '0',
                'parent_id' => '0',
            ];
        }
        $setup->getConnection()
            ->insertMultiple($setup->getTable('marketplace_controller_list'), $data);
    }
}
