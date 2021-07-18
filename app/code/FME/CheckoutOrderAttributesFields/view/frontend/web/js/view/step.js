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
	'jquery',
        'ko',
	'underscore',
        'uiComponent',
        'Magento_Checkout/js/model/step-navigator',
	'Magento_Customer/js/model/customer',
	'Magento_Checkout/js/model/quote',
	'Magento_Checkout/js/action/get-payment-information',
	'mage/translate',
        'Magento_Checkout/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/model/payment/method-converter',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/action/select-billing-address',
        'mage/url',
	'jquery/jquery.hashchange'
    ],
    function (
	$,
        ko,
        _,
        Component,
        stepNavigator,
	customer,
	quote,
	getPaymentInformation,
	$t,
	resourceUrlManager,
        storage,
        paymentService,
        methodConverter,
        errorProcessor,
        fullScreenLoader,
        selectBillingAddressAction,
        url
    ) {
        'use strict';
        /**
        *
        * mystep - is the name of the component's .html template, 
        * <Vendor>_<Module>  - is the name of the your module directory.
        * 
        */
        return Component.extend({
            defaults: {
                template: 'FME_CheckoutOrderAttributesFields/billing'
            },
            //add here your logic to display step,
	    //  isVisible: ko.observable(true),
	   isVisible: function() {
                return true;
            },
	   	// isVisible: ko.observable(customer.isLoggedIn), isVisible: ko.observable(customer.isLoggedIn),
 		//isVisible: ko.observable(false),
            /**
	     *
	     * @returns {*}
	     */
        initialize: function () {
		//self.isVisible(true);
            this._super();
			if($(window).hashchange(_.bind(stepNavigator.handleHash, stepNavigator))){
			    alert('clicked');
			}
			if(stepNavigator.isProcessed('opc-shipping_method')){
			   alert("submitted the");
            }; 
	                //if(customer.isLoggedIn()){
		    stepNavigator.registerStep(
				'checkoutorderattributesfields_billing',
				null,
				$t('Checkout Additional Fields'),
				this.isVisible,
				_.bind(this.navigate, this),
				21
		    );
		//}
            return this;
        },
 
            /**
	    * The navigate() method is responsible for navigation between checkout step
	    * during checkout. You can add custom logic, for example some conditions
	    * for switching to your custom step 
	    */
            navigate: function () {
               var self = this;
	       if($(window).hashchange(_.bind(stepNavigator.handleHash, stepNavigator))){
		    alert('clicked again');
		}
                if(stepNavigator.isProcessed('opc-shipping_method')){
		   alert("submitted t");
                }; 
            },

            getFormKey: function() {
                return window.checkoutConfig.formKey;
            },
	    back: function() {
             //   sidebarModel.hide();
               // stepNavigator.navigateTo('opc-shipping_method');
		//$('#billing').show();
		
            },
            /**
			* @returns void
			*/
            navigateToNextStep: function () {
		//window.location.replace(url.build('checkout#payment'));
               // stepNavigator.navigateTo('payment');
	//       var events;
	//       if(customer.isLoggedIn){
	//	    events = {
	//		data : $('#events-form').serialize()
	//	    }
	//	    storage.post(
	//		url.build('addevent/index/save'),
	//		JSON.stringify(events)
	//	    ).done(
	//		function (response) {
	//		    fullScreenLoader.stopLoader(true);
	//		}
	//	    ).fail(
	//		function (response) {
	//		    errorProcessor.process(response);
	//		    fullScreenLoader.stopLoader(true);
	//		}
	//	    );
	//       }
	       
            },
	    saveAndStay: function () {
	       var events;
	       if(customer.isLoggedIn){
		    
	       }
            },
	    /**
	    * Form submit handler
	    *
	    * This method can have any name.
	    */
	   onSubmit: function() {
	    alert("submitted");
	       // trigger form validation
	       this.source.set('params.invalid', false);
	       this.source.trigger('checkoutorderattributesfields-form.data.validate');
   
	       // verify that form data is valid
	       if (!this.source.get('params.invalid')) {
		   // data is retrieved from data provider by value of the customScope property
		   var formData = this.source.get('checkoutorderattributesfields-form');
		   // do something with form data
		   console.dir(formData);
	       }
	   }
        });
    }
);