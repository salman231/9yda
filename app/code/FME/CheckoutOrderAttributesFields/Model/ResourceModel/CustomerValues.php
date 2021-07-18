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
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Catalog attribute resource model
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class CustomerValues extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('fme_checkoutorderattributesfields_orders', 'entity_id');
    }
    /**
     * Save order value
     *
     * @param string
     * @param string|int|array
     * @param int
     * @param int
     * @return void
     */
    public function saveOrderValue($code, $value, $order_id, $entityTypeId)
    {
        if ($order_id > 0 && $entityTypeId > 0 && $code != '') {
            $connection = $this->getConnection();
            $select = $connection->select()->from(
                $this->getTable('fme_checkoutorderattributesfields_orders'),
                ['entity_id']
            )
            ->where('attribute_code = ?', $code)
            ->where('order_id = ?', $order_id);
            $existingData = $connection->fetchOne($select);
            if ($existingData > 0) {
                $entityRow = ['value' => $value];
                $this->getConnection()->update(
                    $this->getTable('fme_checkoutorderattributesfields_orders'),
                    $entityRow,
                    ['entity_id = ?' => (int)$existingData]
                );
            } else {
                $select = $connection->select()->from(
                    $this->getTable('eav_attribute'),
                    ['attribute_id','fme_pdf','fme_email','frontend_label']
                )
                ->where('attribute_code = ?', $code)
                ->where('entity_type_id = ?', $entityTypeId);
                $attribute_info = $connection->fetchRow($select);
                $entityRow = [
                    'order_id' => $order_id, 'attribute_id' => $attribute_info['attribute_id'],
                    'fme_pdf' => $attribute_info['fme_pdf'],'fme_email' => $attribute_info['fme_email'],
                    'admin_label'=>$attribute_info['frontend_label'],
                    'attribute_code' => $code, 'value' => $value
                ];
                $this->getConnection()->insert(
                    $this->getTable('fme_checkoutorderattributesfields_orders'),
                    $entityRow
                );
            }
        }
    }
    public function saveAdminOrderValue($data, $order_id, $storeId, $checkoutDetails, $entityTypeId)
    {
        if ($order_id > 0 && is_array($data)) {
            foreach ($data as $code => $value) {
                $label = $checkoutDetails[$code]['label'];
                $frontendType = $checkoutDetails[$code]['type'];
                if (in_array($frontendType, ['checkbox','multiselect'])) {
                    $value = $this->getOptionValueById($value, $storeId, true);
                } elseif (in_array($frontendType, ['radio','select'])) {
                    $value = $this->getOptionValueById($value, $storeId, false);
                } elseif ($frontendType == 'boolean') {
                    $value = $value == 1? __('Yes'):__('No');
                }
                $checkoutDetails[$code]['value'] = $value;
            }
            $entityRow = ['coaf' => json_encode($checkoutDetails)];
            $this->getConnection()->update(
                $this->getTable('sales_order'),
                $entityRow,
                ['entity_id = ?' => (int)$order_id]
            );
        }
    }
    /**
     * Get Option by value Id
     *
     * @param int
     * @param int
     * @return string|null
     */
    public function getOptionValueById($id, $storeId, $retArray = false)
    {
        if ($id > 0) {
            $id = is_array($id)?implode(",", $id):$id;
            $connection = $this->getConnection();
            $select = $connection->select()->from(
                $this->getTable('eav_attribute_option_value')
            )->where(
                'option_id in ('.$id.')'
            )->where(
                'store_id in ('.$storeId.',0)'
            )->order('FIELD(store_id, "'.$storeId.'","0")');
            $result = $connection->fetchAll($select);
            if ($result) {
                $default = [];
                foreach ($result as $option) {
                    if (!isset($default[$option['option_id']])) {
                        $default[$option['option_id']] = $option['value'];
                    }
                }
                if ($retArray == true) {
                    return $default;
                }
                return implode(",", $default);
            }
        }
        return;
    }
    /**
     * Retrieve attribute Id and label
     *
     * @return int
     */
    public function getDependableAttributes($entityTypeId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('eav_attribute'),
            ['attribute_id','frontend_label']
        )
        ->where('entity_type_id = ?', $entityTypeId)
        ->where("frontend_input in ('select','multiselect','radio','checkbox','boolean')");
        return $connection->fetchAll($select);
    }
}
