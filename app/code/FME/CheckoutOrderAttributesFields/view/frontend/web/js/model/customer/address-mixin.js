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
  'mage/utils/wrapper',
  'mage/translate'
], function ($, wrapper) {
  'use strict';

  return function (addressModel) {
    return wrapper.wrap(addressModel, function (originalAction) {
      var address = originalAction();

      if (address.customAttributes !== undefined) {
        if (address.customAttributes.coaf === undefined || !address.customAttributes.coaf) {
          //shippingAddress.customAttributes.coaf = {};
          return originalAction();
        }
        if (address.extensionAttributes.coaf === undefined) {
          address.extensionAttributes.coaf = {};
        }

        _.each(address.customAttributes['coaf'], function (value, index) {
          if (!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')) {
            address.extensionAttributes.coaf[index] = {
              'attribute_code': index,
              'value': value
            };
          }
        });
      }

      return address;
    });
  };
});
