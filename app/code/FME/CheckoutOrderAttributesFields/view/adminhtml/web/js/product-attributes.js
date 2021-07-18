/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/prompt',
    'uiRegistry',
    'collapsable'
], function ($, alert, prompt, rg) {
    'use strict';

    return function (optionConfig) {
        var checkoutorderAttributesFields = {
                frontendInput: $('#frontend_input'),
                isFilterable: $('#is_filterable'),
                isFilterableInSearch: $('#is_filterable_in_search'),
                backendType: $('#backend_type'),
                usedForSortBy: $('#used_for_sort_by'),
                frontendClass: $('#frontend_class'),
                isWysiwygEnabled: $('#is_wysiwyg_enabled'),
                isHtmlAllowedOnFront: $('#is_html_allowed_on_front'),
                isRequired: $('#is_required'),
                isUnique: $('#is_unique'),
                defaultValueText: $('#default_value_text'),
                defaultValueTextarea: $('#default_value_textarea'),
                defaultValueEditor: $('#default_value_editor'),
                defaultValueDate: $('#default_value_date'),
                defaultValueYesno: $('#default_value_yesno'),
                defaultValueFile: $('#default_value_file'),
                defaultValueImage: $('#default_value_image'),
                maxSize: $('#fme_max_size'),
                allowedExtensions: $('#fme_extensions'),
                isGlobal: $('#is_global'),
                useProductImageForSwatch: $('#use_product_image_for_swatch'),
                updateProductPreviewImage: $('#update_product_preview_image'),
                usedInProductListing: $('#used_in_product_listing'),
                isVisibleOnFront: $('#is_visible_on_front'),
                position: $('#position'),
                attrTabsFront: $('#product_attribute_tabs_front'),
                fmeCountry: $('#fme_country'),

                /**
                 * @returns {*|jQuery|HTMLElement}
                 */
                get tabsFront() {
                    return this.attrTabsFront.length ? this.attrTabsFront.closest('li') : $('#front_fieldset-wrapper');
                },
                selectFields: ['select', 'multiselect', 'radio', 'checkbox', 'price', 'swatch_text', 'swatch_visual'],

                /**
                 * @this {checkoutorderAttributesFields}
                 */
                toggleApplyVisibility: function (select) {
                    if ($(select).val() === 1) {
                        $(select).next('select').removeClass('no-display');
                        $(select).next('select').removeClass('ignore-validate');
                    } else {
                        $(select).next('select').addClass('no-display');
                        $(select).next('select').addClass('ignore-validate');
                        $(select).next('select option:selected').each(function () {
                            this.selected = false;
                        });
                    }
                },

                /**
                 * @this {checkoutorderAttributesFields}
                 */
                checkOptionsPanelVisibility: function () {
                    var selectOptionsPanel = $('#manage-options-panel'),
                        visualOptionsPanel = $('#swatch-visual-options-panel'),
                        textOptionsPanel = $('#swatch-text-options-panel');

                    this._hidePanel(selectOptionsPanel);
                    this._hidePanel(visualOptionsPanel);
                    this._hidePanel(textOptionsPanel);

                    switch (this.frontendInput.val()) {
                        case 'swatch_visual':
                            this._showPanel(visualOptionsPanel);
                            break;

                        case 'swatch_text':
                            this._showPanel(textOptionsPanel);
                            break;

                        case 'select':
                        case 'multiselect':
                        case 'radio':
                        case 'checkbox':
                            this._showPanel(selectOptionsPanel);
                            break;
                    }
                },

                /**
                 * @this {checkoutorderAttributesFields}
                 */
                bindAttributeInputType: function () {
                    this.checkOptionsPanelVisibility();
                    this.switchDefaultValueField();
                    this.showCountryDependence();
                    this.switchCountryField();

                    if (!~$.inArray(this.frontendInput.val(), this.selectFields)) {
                        // not in array
                        this.isFilterable.selectedIndex = 0;
                        this._disable(this.isFilterable);
                        this._disable(this.isFilterableInSearch);
                    } else {
                        // in array
                        this._enable(this.isFilterable);
                        this._enable(this.isFilterableInSearch);
                        this.backendType.val('int');
                    }

                    if (this.frontendInput.val() === 'multiselect' ||
                        this.frontendInput.val() === 'gallery' ||
                        this.frontendInput.val() === 'textarea'
                    ) {
                        this._disable(this.usedForSortBy);
                    } else {
                        this._enable(this.usedForSortBy);
                    }

                    if (this.frontendInput.val() === 'swatch_text') {
                        $('.swatch-text-field-0').addClass('required-option');
                    } else {
                        $('.swatch-text-field-0').removeClass('required-option');
                    }

                    this.setRowVisibility(this.isWysiwygEnabled, false);
                    this.setRowVisibility(this.isHtmlAllowedOnFront, false);

                    switch (this.frontendInput.val()) {
                        case 'textarea':
                            this.setRowVisibility(this.isWysiwygEnabled, true);

                            if (this.isWysiwygEnabled.val() === '0') {
                                this._enable(this.isHtmlAllowedOnFront);
                            }
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                            break;

                        case 'text':
                            this.setRowVisibility(this.isHtmlAllowedOnFront, true);
                            this._enable(this.frontendClass);
                            break;

                        case 'select':
                        case 'multiselect':
                        case 'radio':
                        case 'checkbox':
                            this.setRowVisibility(this.isHtmlAllowedOnFront, true);
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                            break;
                        default:
                            this.frontendClass.val('');
                            this._disable(this.frontendClass);
                    }

                    this.switchIsFilterable();
                },

                /**
                 * @this {checkoutorderAttributesFields}
                 */
                switchIsFilterable: function () {
                    this._enable(this.position);
                },
                showCountryDependence: function () {
                    if (this.isGlobal.val() < 3) {
                        this.setRowVisibility(this.isUnique, true);
                        this.switchCountryField();
                    } else {
                        this.setRowVisibility(this.isUnique, false); 
                        this.setRowVisibility(this.fmeCountry, false);
                        this._disable(this.fmeCountry);
                    }
                },
                /**
                 * @this {checkoutorderAttributesFields}
                 */
                switchCountryField: function () {
                    var currentValue = this.isUnique.val(),
                    optionCountryVisibility = false;
                    switch (currentValue) {
                        case '0':
                            optionCountryVisibility = false;
                            break;
                        case '1':
                            optionCountryVisibility = true;
                            break;
                        default:
                            optionCountryVisibility = false;
                            break;
                    }
                    this.setRowVisibility(this.fmeCountry, optionCountryVisibility);
                    if (optionCountryVisibility){
                        this._enable(this.fmeCountry);
                    } else {
                        this._disable(this.fmeCountry);
                    }
                },
                /**
                 * @this {checkoutorderAttributesFields}
                 */
                switchDefaultValueField: function () {
                    var currentValue = this.frontendInput.val(),
                        defaultValueTextVisibility = false,
                        defaultValueTextareaVisibility = false,
                        defaultValueEditorVisibility = false,
                        defaultValueDateVisibility = false,
                        defaultValueYesnoVisibility = false,
                        defaultValueFileVisibility = false,
                        defaultValueImageVisibility = false,
                        allowedExtensionsVisibility = false,
                        maxSizeVisibility = false,
                        scopeVisibility = true,
                        useProductImageForSwatch = false,
                        defaultValueUpdateImage = false,
                        optionDefaultInputType = '',
                        thing = this;

                    if (!this.frontendInput.length) {
                        return;
                    }

                    switch (currentValue) {
                        case 'select':
                            optionDefaultInputType = 'radio';
                            defaultValueTextVisibility = false;
                            break;

                        case 'multiselect':
                            optionDefaultInputType = 'checkbox';
                            break;
                        
                        case 'radio':
                            optionDefaultInputType = 'radio';
                            break;

                        case 'checkbox':
                            optionDefaultInputType = 'checkbox';
                            break;

                        case 'date':
                            defaultValueDateVisibility = true;
                            break;

                        case 'boolean':
                            defaultValueYesnoVisibility = true;
                            break;

                        case 'textarea':
                            defaultValueTextareaVisibility = true;
                            break;
                         case 'file':
                            defaultValueFileVisibility = true;
                            maxSizeVisibility = true;
                            allowedExtensionsVisibility = true;
                            break;
                        case 'image':
                            defaultValueImageVisibility = true;
                            maxSizeVisibility = true;
                            allowedExtensionsVisibility = true;
                            break;
                        case 'message':
                            defaultValueEditorVisibility = true;
                            break;

                        case 'media_image':
                            defaultValueTextVisibility = false;
                            break;

                        case 'price':
                            scopeVisibility = false;
                            break;

                        case 'swatch_visual':
                            useProductImageForSwatch = true;
                            defaultValueUpdateImage = true;
                            defaultValueTextVisibility = false;
                            break;

                        case 'swatch_text':
                            useProductImageForSwatch = false;
                            defaultValueUpdateImage = true;
                            defaultValueTextVisibility = false;
                            break;
                        default:
                            defaultValueTextVisibility = true;
                            break;
                    }

                    delete optionConfig.hiddenFields['swatch_visual'];
                    delete optionConfig.hiddenFields['swatch_text'];

                    if (currentValue === 'media_image') {
                        this.tabsFront.hide();
                        this.setRowVisibility(this.isRequired, false);
                       // this.setRowVisibility(this.isUnique, false);
                        this.setRowVisibility(this.frontendClass, false);
                    } else if (optionConfig.hiddenFields[currentValue]) {
                        $.each(optionConfig.hiddenFields[currentValue], function (key, option) {
                            switch (option) {
                                case '_front_fieldset':
                                    thing.tabsFront.hide();
                                    break;

                                case '_default_value':
                                    defaultValueTextVisibility = false;
                                    defaultValueTextareaVisibility = false;
                                    defaultValueEditorVisibility = false;
                                    defaultValueDateVisibility = false;
                                    defaultValueYesnoVisibility = false;
                                    defaultValueFileVisibility =false;
                                    defaultValueImageVisibility = false;
                                    break;

                                case '_scope':
                                    scopeVisibility = false;
                                    break;
                                default:
                                    thing.setRowVisibility($('#' + option), false);
                            }
                        });
                    } else {
                        this.tabsFront.show();
                        this.showDefaultRows();
                    }

                    this.setRowVisibility(this.defaultValueText, defaultValueTextVisibility);
                    this.setRowVisibility(this.defaultValueTextarea, defaultValueTextareaVisibility);
                    this.setRowVisibility(this.defaultValueEditor, defaultValueEditorVisibility);
                    this.setRowVisibility(this.defaultValueDate, defaultValueDateVisibility);
                    this.setRowVisibility(this.defaultValueYesno, defaultValueYesnoVisibility);
                    this.setRowVisibility(this.defaultValueFile,defaultValueFileVisibility);
                    this.setRowVisibility(this.defaultValueImage,defaultValueImageVisibility);
                    this.setRowVisibility(this.maxSize, maxSizeVisibility);
                    this.setRowVisibility(this.allowedExtensions, allowedExtensionsVisibility);
                    this.setRowVisibility(this.isGlobal, scopeVisibility);

                    /* swatch attributes */
                    this.setRowVisibility(this.useProductImageForSwatch, useProductImageForSwatch);
                    this.setRowVisibility(this.updateProductPreviewImage, defaultValueUpdateImage);

                    $('input[name=\'default[]\']').each(function () {
                        $(this).attr('type', optionDefaultInputType);
                    });
                },

                /**
                 * @this {checkoutorderAttributesFields}
                 */
                showDefaultRows: function () {
                    this.setRowVisibility(this.isRequired, true);
                    //this.setRowVisibility(this.isUnique, true);
                    this.setRowVisibility(this.frontendClass, true);
                },

                /**
                 * @param {Object} el
                 * @param {Boolean} isVisible
                 * @this {checkoutorderAttributesFields}
                 */
                setRowVisibility: function (el, isVisible) {
                    if (isVisible) {
                        el.show();
                        el.closest('.field').show();
                    } else {
                        el.hide();
                        el.closest('.field').hide();
                    }
                },

                /**
                 * @param {Object} el
                 * @this {checkoutorderAttributesFields}
                 */
                _disable: function (el) {
                    el.attr('disabled', 'disabled');
                },

                /**
                 * @param {Object} el
                 * @this {checkoutorderAttributesFields}
                 */
                _enable: function (el) {
                    if (!el.attr('readonly')) {
                        el.removeAttr('disabled');
                    }
                },

                /**
                 * @param {Object} el
                 * @this {checkoutorderAttributesFields}
                 */
                _showPanel: function (el) {
                    el.closest('.fieldset').show();
                    this._render(el.attr('id'));
                },

                /**
                 * @param {Object} el
                 * @this {checkoutorderAttributesFields}
                 */
                _hidePanel: function (el) {
                    el.closest('.fieldset').hide();
                },

                /**
                 * @param {String} id
                 * @this {checkoutorderAttributesFields}
                 */
                _render: function (id) {
                    rg.get(id, function () {
                        $('#' + id).trigger('render');
                    });
                },

                /**
                 * @param {String} promptMessage
                 * @this {checkoutorderAttributesFields}
                 */
                saveAttributeInNewSet: function (promptMessage) {

                    prompt({
                        content: promptMessage,
                        actions: {

                            /**
                             * @param {String} val
                             * @this {actions}
                             */
                            confirm: function (val) {
                                var rules = ['required-entry', 'validate-no-html-tags'],
                                    newAttributeSetNameInputId = $('#new_attribute_set_name'),
                                    editForm = $('#edit_form'),
                                    newAttributeSetName = val,
                                    i;

                                if (!newAttributeSetName) {
                                    return;
                                }

                                for (i = 0; i < rules.length; i++) {
                                    if (!$.validator.methods[rules[i]](newAttributeSetName)) {
                                        alert({
                                            content: $.validator.messages[rules[i]]
                                        });

                                        return;
                                    }
                                }

                                if (newAttributeSetNameInputId.length) {
                                    newAttributeSetNameInputId.val(newAttributeSetName);
                                } else {
                                    editForm.append(new Element('input', {
                                            type: 'hidden',
                                            id: newAttributeSetNameInputId,
                                            name: 'new_attribute_set_name',
                                            value: newAttributeSetName
                                        })
                                    );
                                }
                                // Temporary solution will replaced after refactoring of attributes functionality
                                editForm.triggerHandler('save');
                            }
                        }
                    });
                }
            };

        $(function () {
            $('#frontend_input').bind('change', function () {
                checkoutorderAttributesFields.bindAttributeInputType();
            });
            $('#is_global').bind('change', function () {
                checkoutorderAttributesFields.showCountryDependence();
            });
            $('#is_unique').bind('change', function () {
                checkoutorderAttributesFields.switchCountryField();
            });
            $('#is_filterable').bind('change', function () {
                checkoutorderAttributesFields.switchIsFilterable();
            });

            checkoutorderAttributesFields.bindAttributeInputType();

            // @todo: refactor collapsable component
            $('.attribute-popup .collapse, [data-role="advanced_fieldset-content"]')
                .collapsable()
                .collapse('hide');
        });

        window.saveAttributeInNewSet = checkoutorderAttributesFields.saveAttributeInNewSet;
        window.toggleApplyVisibility = checkoutorderAttributesFields.toggleApplyVisibility;
    };
});
