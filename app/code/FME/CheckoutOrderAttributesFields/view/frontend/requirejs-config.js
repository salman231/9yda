/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
var config = {
  map: {
    '*': {
      'Magento_Checkout/template/billing-address.html':
        'FME_CheckoutOrderAttributesFields/template/billing-address.html',
      'Magento_Checkout/template/billing-address/details.html':
        'FME_CheckoutOrderAttributesFields/template/billing-address/details.html',
      'Magento_Checkout/template/shipping-information/address-renderer/default.html':
        'FME_CheckoutOrderAttributesFields/template/shipping-information/address-renderer/default.html'
    }
  },
  config: {
    mixins: {
      'Magento_Checkout/js/action/set-shipping-information': {
        'FME_CheckoutOrderAttributesFields/js/action/set-shipping-information-mixin': true
      },
      'Magento_Checkout/js/action/create-shipping-address': {
        'FME_CheckoutOrderAttributesFields/js/action/create-shipping-address-mixin': true
      },
      'Magento_Checkout/js/action/create-billing-address': {
        'FME_CheckoutOrderAttributesFields/js/action/create-billing-address-mixin': true
      },
      'Magento_Checkout/js/action/place-order': {
        'FME_CheckoutOrderAttributesFields/js/action/place-order-mixin': true
      },
      'Magento_Customer/js/model/customer/address': {
        'FME_CheckoutOrderAttributesFields/js/model/customer/address-mixin': true
      },
      'Magento_Checkout/js/view/billing-address': {
        'FME_CheckoutOrderAttributesFields/js/view/billing-address-mixin': true
      },
      'Magento_Checkout/js/view/shipping-information/address-renderer/default': {
        'FME_CheckoutOrderAttributesFields/js/view/shipping-information/address-renderer/default-mixin': true
      },
      'Magento_Checkout/js/view/shipping-address/address-renderer/default': {
        'FME_CheckoutOrderAttributesFields/js/view/shipping-address/address-renderer/default-mixin': true
      },
      'Magento_Checkout/js/view/shipping': {
        'FME_CheckoutOrderAttributesFields/js/view/shipping-mixin': true
      },
      'Magento_Checkout/js/view/payment': {
        'FME_CheckoutOrderAttributesFields/js/view/payment-mixin': true
      }
    }
  }
};
