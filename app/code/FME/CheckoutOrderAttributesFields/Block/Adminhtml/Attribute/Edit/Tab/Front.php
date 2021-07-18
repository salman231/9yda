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

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Catalog\Model\Entity\Attribute;
use Magento\Eav\Block\Adminhtml\Attribute\PropertyLocker;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Framework\App\ObjectManager;
use FME\CheckoutOrderAttributesFields\Model\Source\CountryOption;
use Magento\Directory\Model\Config\Source\Country;

class Front extends Generic
{
    /**
     * @var countryList
     */
    private $countryList;
    /**
     * @var countryOption
     */
    private $countryOption;
    /**
     * @var Yesno
     */
    private $yesNo;

    /**
     * @var PropertyLocker
     */
    private $propertyLocker;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Yesno $yesNo
     * @param PropertyLocker $propertyLocker
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Yesno $yesNo,
        PropertyLocker $propertyLocker,
        array $data = []
    ) {
        $this->yesNo = $yesNo;
        $this->propertyLocker = $propertyLocker;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /** @var Attribute $attributeObject */
        $attributeObject = $this->_coreRegistry->registry('entity_attribute');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $yesnoSource = $this->yesNo->toOptionArray();

        $fieldset = $form->addFieldset(
            'front_fieldset',
            ['legend' => __('Storefront Properties'), 'collapsable' => $this->getRequest()->has('popup')]
        );
        $fieldset->addField(
            'is_visible_on_front',
            'select',
            [
                'name' => 'is_visible_on_front',
                'label' => __('Enabled on Checkout'),
                'title' => __('Enabled on Checkout'),
                'values' => $yesnoSource
            ]
        );

        $scopes = [
            1 => __('Billing Address'),
            2 => __('Shipping Address'),
            3 => __('Shipping Method'),
            4 => __('Payment/Review step')
        ];

        $fieldset->addField(
            'is_global',
            'select',
            [
                'name' => 'is_global',
                'label' => __('Checkkout Step'),
                'title' => __('Checkkout Step'),
                'note' => __('Declare attribute to show in step.'),
                'values' => $scopes
            ]
        );
        $fieldset->addField(
            'is_unique',
            'select',
            [
                'name' => 'is_unique',
                'label' => __('Is Dependent on country'),
                'title' => __('Is Dependent on country'),
                'values' => $yesnoSource,//$this->getCountryOption()
            ]
        );
        $countries = $this->getCountry();
        unset($countries[0]);
        $fieldset->addField(
            'fme_country',
            'multiselect',
            [
                'name' => 'fme_country',
                'label' => __('Dependent Country'),
                'title' => __('Dependent Country'),
                'required' => true,
                'values' => $countries
            ]
        );
        $fieldset->addField(
            'position',
            'text',
            [
                'name' => 'position',
                'label' => __('Position'),
                'title' => __('Position'),
                'required' => true,
                'note' => __(
                    'This will be used to sort the fields'
                ),
                'class' => 'validate-digits'
            ]
        );
        $fieldset->addField(
            'note',
            'text',
            [
                'name' => 'note',
                'label' => __('Tooltip'),
                'title' => __('Tooltip'),
                'required' => false,
                'note' => __(
                    'Enter content for the tooltip for this attribute, leave empty to disable tooltip'
                ),
                'class' => ''
            ]
        );
        $fieldset->addField(
            'is_searchable',
            'hidden',
            [
                'name'     => 'is_searchable',
                'label'    => __('Use in Search'),
                'title'    => __('Use in Search'),
                'value' => $attributeObject->getData('is_searchable') ?: 0,
            ]
        );

        $fieldset->addField(
            'is_visible_in_advanced_search',
            'hidden',
            [
                'name' => 'is_visible_in_advanced_search',
                'label' => __('Visible in Advanced Search'),
                'title' => __('Visible in Advanced Search'),
                'value' => $attributeObject->getData('is_visible_in_advanced_search') ?: 0,
            ]
        );

        $fieldset->addField(
            'is_comparable',
            'hidden',
            [
                'name' => 'is_comparable',
                'label' => __('Comparable on Storefront'),
                'title' => __('Comparable on Storefront'),
                'value' => $attributeObject->getData('is_comparable') ?: 0,
            ]
        );

        $this->_eventManager->dispatch(
            'checkoutorderattributesfields_attribute_form_build_front_tab',
            ['form' => $form]
        );

        $fieldset->addField(
            'is_used_for_promo_rules',
            'hidden',
            [
                'name' => 'is_used_for_promo_rules',
                'label' => __('Use for Promo Rule Conditions'),
                'title' => __('Use for Promo Rule Conditions'),
                'value' => $attributeObject->getData('is_used_for_promo_rules') ?: 0,
            ]
        );

        $fieldset->addField(
            'is_wysiwyg_enabled',
            'hidden',
            [
                'name' => 'is_wysiwyg_enabled',
                'label' => __('Enable WYSIWYG'),
                'title' => __('Enable WYSIWYG'),
                'value' => $attributeObject->getData('is_wysiwyg_enabled') ?: 0,
            ]
        );

        $fieldset->addField(
            'is_html_allowed_on_front',
            'hidden',
            [
                'name' => 'is_html_allowed_on_front',
                'label' => __('Allow HTML Tags on Storefront'),
                'title' => __('Allow HTML Tags on Storefront'),
                'value' => $attributeObject->getData('is_html_allowed_on_front') ?: 0,
            ]
        );

        $fieldset->addField(
            'used_in_product_listing',
            'hidden',
            [
                'name' => 'used_in_product_listing',
                'label' => __('Used in Product Listing'),
                'title' => __('Used in Product Listing'),
                'note' => __('Depends on design theme.'),
                'value' => $attributeObject->getData('used_in_product_listing') ?: 0,
            ]
        );

        $fieldset->addField(
            'used_for_sort_by',
            'hidden',
            [
                'name' => 'used_for_sort_by',
                'label' => __('Used for Sorting in Product Listing'),
                'title' => __('Used for Sorting in Product Listing'),
                'note' => __('Depends on design theme.'),
                'value' => $attributeObject->getData('used_for_sort_by') ?: 0,
            ]
        );

        $this->_eventManager->dispatch(
            'adminhtml_catalog_product_attribute_edit_frontend_prepare_form',
            ['form' => $form, 'attribute' => $attributeObject]
        );

        $this->setForm($form);
        $form->setValues($attributeObject->getData());
        $this->propertyLocker->lock($form);
        return parent::_prepareForm();
    }

    /**
     * Get Country options
     *
     * @return PropertyLocker
     */
    private function getCountryOption()
    {
        if (null === $this->countryOption) {
            $this->countryOption = ObjectManager::getInstance()->get(CountryOption::class);
        }
        return $this->countryOption->toOptionArray();
    }
    /**
     * Get Countries list
     *
     * @return PropertyLocker
     */
    private function getCountry()
    {
        if (null === $this->countryList) {
            $this->countryList = ObjectManager::getInstance()->get(Country::class);
        }
        return $this->countryList->toOptionArray();
    }
}
