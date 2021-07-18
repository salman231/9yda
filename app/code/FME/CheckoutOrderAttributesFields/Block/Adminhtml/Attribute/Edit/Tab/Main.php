<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab;

use Magento\Eav\Block\Adminhtml\Attribute\Edit\Main\AbstractMain;

/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Main extends AbstractMain
{
    /**
     * Adding product form elements for editing attribute
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        /** @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeObject */
        $attributeObject = $this->getAttributeObject();
        /* @var $form \Magento\Framework\Data\Form */
        $form = $this->getForm();
        /* @var $fieldset \Magento\Framework\Data\Form\Element\Fieldset */
        $fieldset = $form->getElement('base_fieldset');
        $fiedsToRemove = ['attribute_code', 'is_unique', 'frontend_class'];

        foreach ($fieldset->getElements() as $element) {
            /** @var \Magento\Framework\Data\Form\AbstractForm $element  */
            if (substr($element->getId(), 0, strlen('default_value')) == 'default_value') {
                $fiedsToRemove[] = $element->getId();
            }
        }
        foreach ($fiedsToRemove as $id) {
            $fieldset->removeField($id);
        }

        $frontendInputElm = $form->getElement('frontend_input');
        $additionalTypes = [];
        $additionalTypes = [
            ['value' => 'radio', 'label' => __('Radio')],
            ['value' => 'checkbox', 'label' => __('Checkbox')],
            ['value' => 'message', 'label' => __('Message')],
            ['value' => 'image', 'label' => __('Image')],
            ['value' => 'file', 'label' => __('File')],
        ];

        $response = new \Magento\Framework\DataObject();
        $response->setTypes([]);
        $this->_eventManager->dispatch(
            'adminhtml_checkoutorderattributesfields_attribute_types',
            ['response' => $response]
        );
        $_hiddenFields = [];
        foreach ($response->getTypes() as $type) {
            $additionalTypes[] = $type;
            if (isset($type['hide_fields'])) {
                $_hiddenFields[$type['value']] = $type['hide_fields'];
            }
        }
        $this->_coreRegistry->register('attribute_type_hidden_fields', $_hiddenFields);

        $frontendInputValues = array_merge($frontendInputElm->getValues(), $additionalTypes);
        $frontendInputElm->setValues($frontendInputValues);

        $this->_eventManager->dispatch(
            'checkoutorderattributesfields_form_build_main_tab',
            ['form' => $form]
        );

        return $this;
    }

    /**
     * Retrieve additional element types for product attributes
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        return ['apply' => 'FME\CheckoutOrderAttributesFields\Block\Adminhtml\Helper\Form\Apply'];
    }
}
