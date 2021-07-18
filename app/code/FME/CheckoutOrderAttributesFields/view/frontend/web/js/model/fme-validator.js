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
    'Magento_Checkout/js/model/quote',
    'mage/validation'
], function ($,quote) {
    'use strict';
    return {
        /**
         * Validate something
         *
         * @returns {boolean}
         */
        validate: function () {
            var validfields = true;
            $('#coaf-checkout-form button.action').click();
            $('#coaf-checkout-form .dependent').removeClass('_error');
            $('#coaf-checkout-form .dependent').closest('._error').removeClass('_error');
            if ($('#coaf-checkout-form .validate-fme-fields') &&
                $('#coaf-checkout-form .validate-fme-fields').hasClass('_error')
            ) {
                validfields = false;
                $('html, body').animate({
                    scrollTop: $('#coaf-checkout-form .validate-fme-fields._error').offset().top + 'px'
                }, 'slow');
            }
            return validfields;
        }
    }
});
