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
  'mage/utils/wrapper'
], function ($, wrapper) {
  'use strict';

  return function (createShippingAddressAction) {
    return wrapper.wrap(createShippingAddressAction, function (originalAction, addressData) {
      if (addressData.customAttributes === undefined || addressData.customAttributes.length == 0) {
        return originalAction();
      }
      // init extension attributes
      if (addressData.extensionAttributes === undefined) {
        addressData.extensionAttributes = {};
      }
      if (addressData.customAttributes.coaf === undefined || !addressData.customAttributes.coaf) {
        if (addressData.customAttributes.coaf === undefined && addressData.customAttributes.length > 0) {
          addressData.customAttributes.coaf = {};
        } 
        if (addressData.extensionAttributes.coaf === undefined) {
          addressData.extensionAttributes.coaf = {};
        }
        try {
          _.each(addressData.customAttributes, function (value, outerIndex) {
            if (value.attribute_code == 'coaf') {
              _.each(addressData.customAttributes[outerIndex]['value'], function (value, index) {
                if(!$('.field-'+index+' [acode="'+index+'"').prop('disabled')){
                  if($.type(value) == 'array' && $.type(value[0]) == 'object') {
                    addressData.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value[0].name
                    };
                    addressData.customAttributes.coaf[index] = value[0].name;
                  } else {
                    addressData.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value
                    };
                  }
                } else {
                  delete addressData.customAttributes[outerIndex]['value'][index];
                }
              });
              return true;
            }
          });
        } catch (e) {
          return originalAction();
        }
      } else {
        if (addressData.extensionAttributes.coaf === undefined) {
          addressData.extensionAttributes.coaf = {};
        }

        try {
          _.each(addressData.customAttributes['coaf'], function (value, index) {
            if(!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')){
              if($.type(value) == 'array' && $.type(value[0]) == 'object') {
                addressData.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value[0].name
                };
                addressData.customAttributes.coaf[index] = value[0].name;
              } else {
                addressData.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value
                };
              }
            } else {
              delete addressData.customAttributes['coaf'][index];
            }
          });
        } catch (e) {
          return originalAction();
        }
      }
      return originalAction();
    });
  };
});
