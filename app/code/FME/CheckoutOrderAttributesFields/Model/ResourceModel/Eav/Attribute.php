<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
// @codingStandardsIgnoreFile

namespace FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav;

use Magento\Catalog\Model\Attribute\LockValidatorInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Stdlib\DateTime\DateTimeFormatterInterface;

/**
 * Catalog attribute model
 *
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Attribute extends \Magento\Catalog\Model\ResourceModel\Eav\Attribute
{
 

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'checkoutorderattributesfields';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'catalog_entity_checkoutorderattributesfields';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute');
    }

    /**
     * Processing object before save data
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function beforeSave()
    {
        $this->setData('modulePrefix', self::MODULE_NAME);
        if (in_array($this->getFrontendInput(),['checkbox','radio'])) {
            if (is_array($this->getDefault())) {
                $this->setDefaultValue(implode(",",$this->getDefault()));
            } else {
                $this->setDefaultValue($this->getDefault());
            }
        }
        $default = $this->getDefaultValue();
        $visible = $this->getIsVisibleInAdvancedSearch();
        parent::beforeSave();
        $this->setDefaultValue($default);
        $this->setIsVisibleInAdvancedSearch($visible);
        return $this;
    }

    /**
     * Detect default value using frontend input type
     *
     * @param string $type frontend_input field name
     * @return string default_value field value
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getDefaultValueByInput($type)
    {
        $field = '';
        switch ($type) {
            case 'select':
            case 'gallery':
            case 'media_image':
                break;
            case 'multiselect':
                $field = null;
                break;

            case 'text':
            case 'price':
            case 'weight':
                $field = 'default_value_text';
                break;

            case 'textarea':
                $field = 'default_value_textarea';
                break;

            case 'date':
                $field = 'default_value_date';
                break;

            case 'boolean':
                $field = 'default_value_yesno';
                break;
            case 'message':
                $field = 'default_value_editor';
                break;
            case 'image':
                $field = 'default_value_image';
                break;
            case 'file':
                $field = 'default_value_file';
                break;
            default:
                break;
        }

        return $field;
    }
}