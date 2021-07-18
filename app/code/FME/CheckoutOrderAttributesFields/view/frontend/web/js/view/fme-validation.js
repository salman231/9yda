/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'FME_CheckoutOrderAttributesFields/js/model/fme-validator'
    ],
    function (Component, additionalValidators, fmeValidator) {
        'use strict';
        additionalValidators.registerValidator(fmeValidator);
        return Component.extend({});
    }
);
