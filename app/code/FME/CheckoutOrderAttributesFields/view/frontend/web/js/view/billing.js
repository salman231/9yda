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
    'jquery',
    'ko',
    'underscore',
    'uiComponent'
], function (
    $,
    ko,
    _,
    Component
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'FME_CheckoutOrderAttributesFields/billing'
        },
        getTemplate: function () {
            return window.checkoutConfig.checkoutorderattributesfieldsBilling
        },
        isVisible: function () {
            return true;
        },
        initialize: function () {
            this._super();
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
            this.source.trigger('checkoutorderattributesfields-form.data.validate');
            
            // verify that form data is valid
            if (!this.source.get('params.invalid')) {
                // data is retrieved from data provider by value of the customScope property
                var formData = this.source.get('checkoutorderattributesfields-form');
            }
        }
    });
});
