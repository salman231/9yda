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
define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/action/select-shipping-address',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-address/form-popup-state',
    'Magento_Checkout/js/checkout-data',
    'Magento_Customer/js/customer-data'
], function ($, ko, Component, selectShippingAddressAction, quote, formPopUpState, checkoutData, customerData) {
    'use strict';
   var countryData = customerData.get('directory-data');
   
    var mixin = {
        defaults: {
            template: 'FME_CheckoutOrderAttributesFields/shipping-address/address-renderer/default'
        },

        /**
         * @param {String} countryId
         * @return {String}
         */
        getCountryName: function (countryId) {
        	var shippingAddress = quote.shippingAddress();
        	setTimeout(function(){
		        $("[name^='custom_attributes[coaf]']:not([cl=''])[cl*='"+shippingAddress.countryId+"']").prop( "disabled", false ).attr("dc", "0");
				$("[name^='custom_attributes[coaf]']:not([cl=''])[cl*='"+shippingAddress.countryId+"']").each(function(e) {
					if($(this).attr("depdis")==0){
						$(this).removeClass('dependent');
						$(".field-"+$(this).attr("acode")).show();
					} else if($(this).attr("depdis")==1) {
                        $(this).prop( "disabled", true );
                    }
				});
				$("[name^='custom_attributes[coaf]']:not([cl='']):not([cl*='"+shippingAddress.countryId+"'])").each(function(e) {
					$(this).attr("dc","1").prop( "disabled", true ).addClass('dependent');
					$(".field-"+$(this).attr("acode")).hide();
				});
				$("[name^='custom_attributes[coaf]'][cl='']").attr("dc", "0");
				////
				$("[cl]:not([cl=''])[cl*='"+shippingAddress.countryId+"']").attr("dc", "0").prop( "disabled", false );
				$("[cl]:not([cl=''])[cl*='"+shippingAddress.countryId+"']").each(function(e) {
					if($(this).attr("depdis")==0){
						$(this).removeClass('dependent');
						$(".field-"+$(this).attr("acode")).show();
					} else if($(this).attr("depdis")==1) {
                        $(this).prop( "disabled", true );
                    }
				});
				$("[cl]:not([cl='']):not([cl*='"+shippingAddress.countryId+"'])").each(function(e) {
					$(this).attr("dc","1").prop( "disabled", true ).addClass('dependent');
					$(".field-"+$(this).attr("acode")).hide();
				});
				$("[cl][cl='']").attr("dc", "0");
			}, 50);
            return countryData()[countryId] != undefined ? countryData()[countryId].name : ''; //eslint-disable-line
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
