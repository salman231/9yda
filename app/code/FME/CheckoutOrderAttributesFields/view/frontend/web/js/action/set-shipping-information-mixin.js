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
  'uiRegistry',
  'mage/url'
], function ($, wrapper, quote, registry, url) {
  'use strict';
  $(document).on('change',"#co-shipping-form select[name='country_id']",function(){
    setTimeout(function(){
      $("[name^='custom_attributes[coaf]']:not([cl=''])[cl*='"+$("#co-shipping-form select[name='country_id']").val()+"']").prop( "disabled", false ).attr("dc", "0");
      $("[name^='custom_attributes[coaf]']:not([cl=''])[cl*='"+$("#co-shipping-form select[name='country_id']").val()+"']").each(function(e) {
       if($(this).attr("depdis")==0){
          $(this).removeClass('dependent');
          $(".field-"+$(this).attr("acode")).show();
        } else if($(this).attr("depdis")==1) {
            $(this).prop( "disabled", true );
        }
      });
      $("[name^='custom_attributes[coaf]']:not([cl='']):not([cl*='"+$("#co-shipping-form select[name='country_id']").val()+"'])").each(function(e) {
        $(this).attr("dc","1").prop( "disabled", true ).addClass('dependent');
        $(".field-"+$(this).attr("acode")).hide();
      });
      $("[name^='custom_attributes[coaf]'][cl='']").attr("dc", "0");
      ////
      $("[cl]:not([cl=''])[cl*='"+$("#co-shipping-form select[name='country_id']").val()+"']").attr("dc", "0").prop( "disabled", false );
      $("[cl]:not([cl=''])[cl*='"+$("#co-shipping-form select[name='country_id']").val()+"']").each(function(e) {
        if($(this).attr("depdis")==0){
          $(this).removeClass('dependent');
          $(".field-"+$(this).attr("acode")).show();
        } else if($(this).attr("depdis")==1) {
            $(this).prop( "disabled", true );
        }
      });
      $("[cl]:not([cl='']):not([cl*='"+$("#co-shipping-form select[name='country_id']").val()+"'])").each(function(e) {
        $(this).attr("dc","1").prop( "disabled", true ).addClass('dependent');
        $(".field-"+$(this).attr("acode")).hide();
      });
      $("[cl][cl='']").attr("dc", "0");
    }, 30);
  });
  return function (setShippingInformationAction) {
    return wrapper.wrap(setShippingInformationAction, function (originalAction) {
      if ($('#coaf-checkout-shipping-form')) {
        $('#coaf-checkout-shipping-form button.action').click();
        if ($('#coaf-checkout-shipping-form .field') && $('#coaf-checkout-shipping-form .field').hasClass('_error')) {
          $('html, body').animate({
            scrollTop: $('#coaf-checkout-shipping-form .field._error').offset().top + 'px'
          }, 'slow');
          return false;
        }
      }
      if ($('#coaf-checkout-shippingmethod-form')) {
        $('#coaf-checkout-shippingmethod-form button.action').click();
        if ($('#coaf-checkout-shippingmethod-form .field') && $('#coaf-checkout-shippingmethod-form .field').hasClass('_error')) {
          $('html, body').animate({
              scrollTop: $('#coaf-checkout-shippingmethod-form .field._error').offset().top + 'px'
          }, 'slow');
          return false;
        }
      }
      var customFields = [];
      var shippingAddress = quote.shippingAddress();
      if (shippingAddress.customAttributes === undefined || shippingAddress.customAttributes.length == 0) {
        shippingAddress.customAttributes = {};
        return originalAction();
      }
      // init extension attributes
      if (shippingAddress.extensionAttributes === undefined) {
        shippingAddress.extensionAttributes = {};
      }
      if (shippingAddress.customAttributes.coaf === undefined || !shippingAddress.customAttributes.coaf) {
        if (shippingAddress.customAttributes.coaf === undefined && shippingAddress.customAttributes.length > 0) {
          shippingAddress.customAttributes.coaf = {};
        } 
        if (shippingAddress.extensionAttributes.coaf === undefined) {
          shippingAddress.extensionAttributes.coaf = {};
        }
        try {
          _.each(shippingAddress.customAttributes, function (value, outerIndex) {
            if (value.attribute_code == 'coaf') {
              _.each(shippingAddress.customAttributes[outerIndex]['value'], function (value, index) {
                if (!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')) {
                  if ($.type(value) == 'array' && $.type(value[0]) == 'object') {
                    shippingAddress.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value[0].name
                    };
                    shippingAddress.customAttributes.coaf[index] = value[0].name;
                  } else {
                    shippingAddress.extensionAttributes.coaf[index] = {
                      attributeCode: index,
                      value: value
                    };
                  }
                } else {
                  delete shippingAddress.customAttributes[outerIndex]['value'][index];
                }
              });
              return true;
            }
          });
        } catch (e) {
          return originalAction();
        }
      } else {
        if (shippingAddress.extensionAttributes.coaf === undefined) {
          shippingAddress.extensionAttributes.coaf = {};
        }

        try {
          _.each(shippingAddress.customAttributes['coaf'], function (value, index) {
            if (!$('.field-'+index+' [acode="'+index+'"]').prop('disabled')) {
              if ($.type(value) == 'array' && $.type(value[0]) == 'object') {
                shippingAddress.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value[0].name
                };
                shippingAddress.customAttributes.coaf[index] = value[0].name;
              } else {
                shippingAddress.extensionAttributes.coaf[index] = {
                  attributeCode: index,
                  value: value
                };
              }
            } else {
              delete shippingAddress.customAttributes['coaf'][index];
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
