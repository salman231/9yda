/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
/*global define*/
define([
    'ko',
    'jquery',
    'Magento_Ui/js/form/form',
    'underscore',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer'
], function (
    ko,
    $,
    Component,
    _,
    quote,
    customer
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'FME_CheckoutOrderAttributesFields/coaf-checkout-shippingmethod-form'
        },
        isVisible: ko.observable(true),
        isCustomerLoggedIn: customer.isLoggedIn,
        initialize: function () {
            this._super();
            // component initialization logic
            return this;
        },
        /**
         * Form submit handler
         *
         * This method can have any name.
         */
        onSubmit: function () {
            // trigger form validation
            this.source.set('params.invalid', false);
            this.source.trigger('coaf.data.validate');
            
            var fields = {};
            fields.coaf = {};
            // verify that form data is valid
            this.source.get('params.invalid');

            // data is retrieved from data provider by value of the customScope property
            var formData = this.source.get('coaf');
            // do something with form data
            var shippingAddress = quote.shippingAddress();
            
            if (shippingAddress.customAttributes === undefined) {
                shippingAddress.customAttributes = {};
            }
            if (shippingAddress.extensionAttributes === undefined) {
                shippingAddress.extensionAttributes = {};
            }
            if (shippingAddress.extensionAttributes.coaf === undefined) {
                shippingAddress.extensionAttributes.coaf = {};
            }
            if (shippingAddress.customAttributes.coaf === undefined) {
                shippingAddress.customAttributes.coaf = {};
            }
            _.each(formData, function (value,index) {
                if (!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')) {
                    shippingAddress.customAttributes.coaf[index] = value;
                    if($.type(value) == 'array' && $.type(value[0]) == 'object') {
                        shippingAddress.extensionAttributes.coaf[index] = {
                            attributeCode: index,
                            value: value[0].name
                        };
                        shippingAddress.customAttributes.coaf[index] = value[0].name;
                    } else {
                        shippingAddress.extensionAttributes.coaf[index] = {
                            attributeCode: index,
                            value: value
                        };
                    }
                }
            });
        }
    });
});
