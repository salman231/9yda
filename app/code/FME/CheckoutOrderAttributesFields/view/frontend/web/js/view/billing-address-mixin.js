/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
/*jshint browser:true*/
/*global define*/
define(function () {
    'use strict';
   
    var mixin = {
        defaults: {
            template: 'FME_CheckoutOrderAttributesFields/billing-address'
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
