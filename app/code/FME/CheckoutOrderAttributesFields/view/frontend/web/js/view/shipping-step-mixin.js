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
        initialize: function () {
            this.isVisible = ko.observable(false); // set visible to be initially false to have your step show first
            this._super();
            return this;
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
