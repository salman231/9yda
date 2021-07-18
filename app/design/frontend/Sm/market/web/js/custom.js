// require(
//     [
//         'jquery',
//         'Magento_Ui/js/modal/modal',
//         'Magento_Ui/js/modal/confirm',
//         'mage/storage',
//         "jquery/ui",
//         "jquery/validate",
//         "mage/translate",
//         "mage/mage"
//     ], function($, confirm, storage,modal){               
//     var width = $(window).width();
// 	if (width <= 480) {
// 	    //code for mobile devices
// 	    console.log("mobile");
// 	    $(window).load(function() {
//             var options1 = {
//                 type: 'popup',
//                 responsive: true,
//                 clickableOverlay: false,
//                 modalClass: 'download-app',
//                 buttons: [
// 	            	{
// 		                id: "googlestore",
// 		                text: "Google Play Store",
// 		                click: function () {
// 		                    window.open(
// 							  'https://play.google.com/store/apps/details?id=com.yda&hl=en',
// 							  '_blank' // <- This is what makes it open in a new window.
// 							);
// 	                	}
//             		},
//             		{
// 		                id: "applestore",
// 		                text: "Apple App Store",
// 		                click: function () {
// 		                    window.open(
// 							  'https://apps.apple.com/kw/app/9yda/id1546904950',
// 							  '_blank' // <- This is what makes it open in a new window.
// 							);
// 		                }
//             		},
//             		{
// 		                id: "huaweiapp",
// 		                text: "Huawei AppGallery",
// 		                click: function () {
// 		                    window.open(
// 							  'https://appgallery.huawei.com/#/app/C103949395',
// 							  '_blank' // <- This is what makes it open in a new window.
// 							);
// 		                }
//             		},
//             		{
// 		                id: "Cancel",
// 		                text: "Cancel",
// 		                click: function () {
// 		                    this.closeModal();
// 		                }
//             		}
//             	]
//             };
//             $("#custom-popup-modal").show();
//             $("#custom-popup-modal").modal(options1).modal('openModal');
//         }); 
// 	}  
// });