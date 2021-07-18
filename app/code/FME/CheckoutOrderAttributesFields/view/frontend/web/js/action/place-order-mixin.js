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
  'Magento_Checkout/js/model/quote',
  'mage/validation'
], function ($, wrapper, quote) {
  'use strict';

  return function (placeOrderAction) {
    return wrapper.wrap(placeOrderAction, function (originalAction) {
      
      
      var billingAddress = quote.billingAddress();
      var paymentMethod = quote.paymentMethod();

      try {
        if (billingAddress.customAttributes === undefined || billingAddress.customAttributes.length == 0) {
          return originalAction();
        }
        // init extension attributes
        if (billingAddress.extensionAttributes === undefined) {
          billingAddress.extensionAttributes = {};
        }
        if (billingAddress.customAttributes.coaf === undefined || !billingAddress.customAttributes.coaf) {
          if (billingAddress.customAttributes.coaf === undefined && billingAddress.customAttributes.length > 0) {
            billingAddress.customAttributes.coaf = {};
          } 
          if (billingAddress.extensionAttributes.coaf === undefined) {
            billingAddress.extensionAttributes.coaf = {};
          }
          
          _.each(billingAddress.customAttributes, function (value, outerIndex) {
            if (value.attribute_code == 'coaf') {
              _.each(billingAddress.customAttributes[outerIndex]['value'], function (value, index) {
                if(!$('.field-'+index+' [acode="'+index+'"').prop('disabled')){
                  if($.type(value) == 'array' && $.type(value[0]) == 'object') {
                    billingAddress.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value[0].name
                    };
                    billingAddress.customAttributes.coaf[index] = value[0].name;
                  } else {
                    billingAddress.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value
                    };
                  }
                } else {
                  delete billingAddress.customAttributes[outerIndex]['value'][index];
                }
              });
              return true;
            }
          });
          
        } else {
          if (billingAddress.extensionAttributes.coaf === undefined) {
            billingAddress.extensionAttributes.coaf = {};
          }
          _.each(billingAddress.customAttributes['coaf'], function (value, index) {
            if(!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')){
              if($.type(value) == 'array' && $.type(value[0]) == 'object') {
                billingAddress.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value[0].name
                };
                billingAddress.customAttributes.coaf[index] = value[0].name;
              } else {
                billingAddress.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value
                };
              }
            } else {
              delete billingAddress.customAttributes['coaf'][index];
            }
          });
        }
      } catch (e) {
        return originalAction();
      }
      return originalAction();
    });
  };
});