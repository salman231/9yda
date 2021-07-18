/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
define([
    'ko'
], function (ko) {
    'use strict';

    var mixin = {
       defaults: {
           template: 'FME_CheckoutOrderAttributesFields/payment'
       }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
