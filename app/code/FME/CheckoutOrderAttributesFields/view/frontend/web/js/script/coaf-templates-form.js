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
    'Magento_Ui/js/form/form',
    'underscore',
    'Magento_Checkout/js/model/quote',
    'jquery/validate'
], function (
    $,
    ko,
    Component,
    _,
    quote,
    customer
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'FME_CheckoutOrderAttributesFields/script/coaftemplates'
        },
        isVisible: ko.observable(true),
        initialize: function () {
            this._super();
            
            // component initialization logic
            return this;
        },
    });
});
