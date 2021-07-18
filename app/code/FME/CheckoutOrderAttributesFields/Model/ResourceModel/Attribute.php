<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model\ResourceModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Attribute\LockValidatorInterface;

/**
 * Catalog attribute resource model
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Attribute extends \Magento\Catalog\Model\ResourceModel\Attribute
{
    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $applyTo = $object->getApplyTo();
        if (is_array($applyTo)) {
            $object->setApplyTo(implode(',', $applyTo));
        }
        if (is_array($object->getDefaultValue())) {
            $object->setDefaultValue(implode(',', $object->getDefaultValue()));
        }
        return parent::_beforeSave($object);
    }

    /**
     * Perform actions after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->_updateRelatedSave($object);
        $this->_clearUselessAttributeValues($object);
        $this->_saveselectedProducts($object);
        $this->_saveselectedcategories($object);
        return parent::_afterSave($object);
    }
    /**
     * save selected categories
     *
     * @param Object
     * @return void
     */
    protected function _saveselectedcategories(\Magento\Framework\Model\AbstractModel $object)
    {
        $delCondition = [
            'attribute_id = ?' => $object->getId()
        ];
        $this->getConnection()->delete(
            $this->getTable('fme_checkoutorderattributesfields_category'),
            $delCondition
        );
        
        $categories_ids = $object->getCategoriesIds();
        foreach ($categories_ids as $category_id) {
            if ($category_id == 0) {
                continue;
            }
            $entityRow = ['attribute_id' => $object->getId(),'category_id' => $category_id];
            $this->getConnection()->insert(
                $this->getTable('fme_checkoutorderattributesfields_category'),
                $entityRow
            );
        }
    }
    /**
     * Save selected products
     *
     * @param object
     * @return void
     */
    protected function _saveselectedProducts(\Magento\Framework\Model\AbstractModel $object)
    {
        $condition = $this->getConnection()->quoteInto(
            'attribute_id = ?',
            $object->getId()
        );
        $this->getConnection()->delete(
            $this->getTable('fme_checkoutorderattributesfields_product'),
            $condition
        );
        
        $product_ids = $object->getProductIds();
        foreach ($product_ids as $product_id) {
            if ($product_id == 0) {
                continue;
            }
            $entityRow = ['attribute_id' => $object->getId(),'product_id' => $product_id];
            $this->getConnection()->insert(
                $this->getTable('fme_checkoutorderattributesfields_product'),
                $entityRow
            );
        }
    }

    /**
     * Clear useless attribute values
     *
     * @param  \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _clearUselessAttributeValues(\Magento\Framework\Model\AbstractModel $object)
    {
        return $this;
    }

    /**
     * Perform actions after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _updateRelatedSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $delCondition = [
            'attribute_id = ?' => $object->getId()
        ];
        $this->getConnection()->delete(
            $this->getTable('fme_checkoutorderattributesfields_customer_group'),
            $delCondition
        );
        $this->getConnection()->delete(
            $this->getTable('fme_checkoutorderattributesfields_stores'),
            $delCondition
        );
        $store_ids = $object->getStoreIds();
        foreach ($store_ids as $store_id) {
            $entityRow = ['attribute_id' => $object->getId(),'store_id' => $store_id];
            $this->getConnection()->insert(
                $this->getTable('fme_checkoutorderattributesfields_stores'),
                $entityRow
            );
        }
        $customer_groups = $object->getCustomerGroup();
        foreach ($customer_groups as $customer_group) {
            $entityRow = ['attribute_id' => $object->getId(),'group_id' => $customer_group];
            $this->getConnection()->insert(
                $this->getTable('fme_checkoutorderattributesfields_customer_group'),
                $entityRow
            );
        }
    }
    /**
     * Update default value
     *
     * @param object
     * @param int
     * @param int
     * @param int|string
     * @return $defaultValue
     */
    public function _updateDefaultValue($object, $optionId, $intOptionId, &$defaultValue)
    {
        if (in_array($optionId, $object->getDefault())) {
            $frontendInput = $object->getFrontendInput();
            if ($frontendInput === 'multiselect' || $frontendInput === 'checkbox') {
                $defaultValue[] = $intOptionId;
            } elseif ($frontendInput === 'select' || $frontendInput === 'radio') {
                $defaultValue = [$intOptionId];
            }
        }
    }
    /**
     * After Load
     *
     * @param object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var $entityType \Magento\Eav\Model\Entity\Type */
        $entityType = $object->getData('entity_type');
        if ($entityType) {
            $additionalTable = $entityType->getAdditionalAttributeTable();
        } else {
            $additionalTable = $this->getAdditionalAttributeTable($object->getEntityTypeId());
        }

        if ($additionalTable) {
            $connection = $this->getConnection();
            $bind = [':attribute_id' => $object->getId()];
            $select = $connection->select()->from(
                $this->getTable($additionalTable)
            )->where(
                'attribute_id = :attribute_id'
            );

            $result = $connection->fetchRow($select, $bind);
            if ($result) {
                $object->addData($result);
            }
        }
        $connection = $this->getConnection();
        $bind = [':attribute_id' => $object->getId()];
        $select = $connection->select()->from(
            ['fme_stores' => $this->getTable('fme_checkoutorderattributesfields_stores')],
            ['store_id']
        )->where(
            'attribute_id = :attribute_id'
        );

        $result['store_ids'] = $connection->fetchCol($select, $bind);

        $select = $connection->select()->from(

            ['fme_group' => $this->getTable('fme_checkoutorderattributesfields_customer_group')],
            ['group_id']
        )->where(
            'attribute_id = :attribute_id'
        );

        $result['customer_group'] = $connection->fetchCol($select, $bind);


        $select = $connection->select()->from(

            ['fme_selectedproducts' => $this->getTable('fme_checkoutorderattributesfields_product')],
            ['product_id']
        )->where(
            'attribute_id = :attribute_id'
        );
        $productIds = $connection->fetchCol($select, $bind);
        $result['product_id'] =$productIds;
        $jsonEncoded = [];
        foreach ($productIds as $productId) {
            $jsonEncoded[$productId] = "";
        }

        $result['category_products'] = json_encode($jsonEncoded);
        // for categories

        $select = $connection->select()->from(
            ['fme_selectedcategories' => $this->getTable('fme_checkoutorderattributesfields_category')],
            ['category_id']
        )->where(
            'attribute_id = :attribute_id'
        );
        $categoriesIds = $connection->fetchCol($select, $bind);
        $result['categories_ids'] = $categoriesIds;

        $object->addData($result);
        return $this;
    }
    /**
     * Get Option value by Id
     *
     * @param int
     * @param int
     * @return string|null
     */
    public function getOptionValueById($id, $storeId)
    {
        $default = '';
        if ($id > 0) {
            $connection = $this->getConnection();
            $bind = [':option_id' => $id];
            $select = $connection->select()->from(
                $this->getTable('eav_attribute_option_value')
            )->where(
                'option_id = :option_id'
            );
            $result = $connection->fetchRow($select, $bind);
            if ($result) {
                foreach ($result as $option) {
                    if (isset($option['store_id']) and $option['store_id'] == $storeId) {
                        return $option['value'];
                    } elseif (isset($option['store_id']) and $option['store_id'] == 0) {
                        $default = $option['value'];
                    }
                }
                return $default;
            }
        }
        return $default;
    }
}
