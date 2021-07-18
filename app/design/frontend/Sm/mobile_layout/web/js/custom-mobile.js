// require(
//     [
//         'jquery',
//         "jquery/ui"
//     ], function($){               
//     var width = $(window).width();
// 	if (width <= 480) {
// 	    //code for mobile devices
// 	    console.log("mobile");
// 	    $(window).load(function() {
//             var isAndroid = / Android/i.test(navigator.userAgent.toLowerCase());  
//             var isiPhone = / iphone/i.test(navigator.userAgent.toLowerCase()); 
// 			if (isAndroid)  
// 			{  
// 			   console.log("Android");
// 			   if (!!$.cookie('close-alert-android')) {
//  					// have cookie
//  					$(".app-alert").addClass("closed");
//  					console.log("cookie set");
// 				}
// 			   $(".app-alert").show();
// 			   $(".app-alert .android-app").show();
// 			   $(".app-alert").css("display", "flex");
// 			   $(".app-alert .android-app").css("display", "flex");
// 			   $('.app-alert .close-button').click(function() {
// 			    	//console.log("click");
//             		$.cookie('close-alert-android', '1', {expires: 1});
//             		$(".app-alert").addClass("closed");
//       			});
// 			}			 
//  			if (isiPhone)  
// 			{  
// 			    console.log("iphone");
// 			    if (!!$.cookie('close-alert-ios')) {
//  					// have cookie
//  					$(".app-alert").addClass("closed");
//  					console.log("cookie set");
// 				}
// 			    $(".app-alert").show();
// 			    $(".app-alert .ios-app").show();
// 			    $(".app-alert").css("display", "flex");
// 			    $(".app-alert .ios-app").css("display", "flex");
// 			    $('.app-alert .close-button').click(function() {
// 			    	//console.log("click");
//             		$.cookie('close-alert-ios', '1', {expires: 1});
//             		$(".app-alert").addClass("closed");
//       			});
// 			}  
//         }); 
// 	}  
// });