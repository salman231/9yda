<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute;

/**
 * Catalog product EAV additional attribute resource collection
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
{

    /**
     * Resource model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Magento\Catalog\Model\ResourceModel\Eav\Attribute',
            'Magento\Eav\Model\ResourceModel\Entity\Attribute'
        );
    }

    /**
     * Initialize select object
     *
     * @return $this
     */
    public function _initSelect()
    {
        $entityTypeId = (int)$this->_eavEntityFactory->create()->setType(
            \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY
        )->getTypeId();
        $columns = $this->getConnection()->describeTable($this->getResource()->getMainTable());
        unset($columns['attribute_id']);
        $retColumns = [];
        foreach ($columns as $labelColumn => $columnData) {
            $retColumns[$labelColumn] = $labelColumn;
            if ($columnData['DATA_TYPE'] == \Magento\Framework\DB\Ddl\Table::TYPE_TEXT) {
                $retColumns[$labelColumn] = 'main_table.' . $labelColumn;
            }
        }
        $this->getSelect()->from(
            ['main_table' => $this->getResource()->getMainTable()],
            $retColumns
        )->join(
            ['additional_table' => $this->getTable('catalog_eav_attribute')],
            'additional_table.attribute_id = main_table.attribute_id'
        )->join(
            ['store_table' => $this->getTable('fme_checkoutorderattributesfields_stores')],
            'store_table.attribute_id = main_table.attribute_id',
            new \Zend_Db_Expr("GROUP_CONCAT(`store_table`.`store_id` ORDER BY `store_table`.`store_id` SEPARATOR ',') as 'store_id'")
        )->join(
            ['group_table' => $this->getTable('fme_checkoutorderattributesfields_customer_group')],
            'group_table.attribute_id = main_table.attribute_id',
            new \Zend_Db_Expr("GROUP_CONCAT(`group_table`.`group_id` ORDER BY `group_table`.`group_id` SEPARATOR ',') as 'group_id'")
        )->joinLeft(
            ['product_table' => $this->getTable('fme_checkoutorderattributesfields_product')],
            'product_table.attribute_id = main_table.attribute_id',
            new \Zend_Db_Expr("GROUP_CONCAT(`product_table`.`product_id` ORDER BY `product_table`.`product_id` SEPARATOR ',') as 'product_id'")
        )->joinLeft(
            ['category_table' => $this->getTable('fme_checkoutorderattributesfields_category')],
            'category_table.attribute_id = main_table.attribute_id',
            new \Zend_Db_Expr("GROUP_CONCAT(`category_table`.`category_id` ORDER BY `category_table`.`category_id` SEPARATOR ',') as 'category_id'")
        )

        ->where(
            'main_table.entity_type_id = ?',
            $entityTypeId
        )->group('attribute_id');
        return $this;
    }

    /**
     * Specify attribute entity type filter.
     * Entity type is defined.
     *
     * @param  int $typeId
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }

    /**
     * Specify filter by "is_visible" field
     *
     * @return $this
     */
    public function addVisibleFilter()
    {
        //return $this->addFieldToFilter('additional_table.is_visible', 1);
        return $this->addFieldToFilter('additional_table.is_visible_on_front', 1);
    }

    /**
     * Specify filter by "Billing" step
     *
     * @return $this
     */
    public function addStepFilter()
    {
        return $this->addFieldToFilter('additional_table.is_global', ['in'=>'1,2,3,4']);
    }

    /**
     * Specify filter by "Billing" step
     *
     * @return $this
     */
    public function addBillingFilter()
    {
        return $this->addFieldToFilter('additional_table.is_global', 1);
    }

    /**
     * Specify filter by "Shipping" step
     *
     * @return $this
     */
    public function addShippingFilter()
    {
        return $this->addFieldToFilter('additional_table.is_global', 2);
    }

    /**
     * Specify filter by "shipping method" step
     *
     * @return $this
     */
    public function addShippingMethodFilter()
    {
        return $this->addFieldToFilter('additional_table.is_global', 3);
    }

    /**
     * Specify filter by "shipping method" step
     *
     * @return $this
     */
    public function addPaymentStepFilter()
    {
        return $this->addFieldToFilter('additional_table.is_global', 4);
    }

    /**
     * Specify filter by "shipping method" step
     *
     * @return $this
     */
    public function addStoreFilters($store_id)
    {
        $stores = [0, $store_id];
        return $this->addFieldToFilter('store_table.store_id', ['in' => implode(',', $stores)]);
    }
    /**
     * filter categories
     *
     * @param array
     * @return $this
     */
    public function addCatalogFilter($catalog_ids)
    {
        $productIds = $catalog_ids['product_ids'];
        $categoryIds = $catalog_ids['category_ids'];
        $this->getSelect()->where(
            "(`product_table`.`product_id` IN(".implode(',', $productIds).") OR `category_table`.`category_id` IN(".implode(',', $categoryIds).")) OR  (`product_table`.`product_id` IS NULL AND `category_table`.`category_id` IS NULL)"
        );

        return $this;
    }

    /**
     * Specify filter by "shipping method" step
     *
     * @return $this
     */
    public function addCustomerGroupFilter($group_id = 0)
    {
        return $this->addFieldToFilter('group_table.group_id', $group_id);
    }

    /**
     * apply Sort
     *
     * @return $this
     */
    public function applySort()
    {
        return $this->setOrder('additional_table.position', 'ASC');
    }
    /**
     * apply Sort
     *
     * @return $this
     */
    public function applyGroup()
    {
        $this->getSelect()->group('main_table.attribute_id');
    }
    /**
     * Specify "is_searchable" filter
     *
     * @return $this
     */
    public function addIsSearchableFilter()
    {
        return $this->addFieldToFilter('additional_table.is_searchable', 1);
    }
}
