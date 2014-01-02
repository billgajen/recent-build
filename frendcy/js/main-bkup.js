$(function() {
	var selected_friends = new Array();

	//Toggle button - Magic Button
	$('.fb-friends-list li a').toggle(function () {
		selected_friends.push($(this).attr("title"));
		$(this).addClass('selected');
	}, function () {
		selected_friends.splice(selected_friends.indexOf($(this).attr("title")),1);
		$(this).removeClass('selected');
	});

	//Hide the address bar on mobile
	window.addEventListener('load',function() {
		// Set a timeout...
		setTimeout(function(){
			// Hide the address bar!
			window.scrollTo(0, 1);
		}, 0);
	});

	//Hide address bar alternate - buggy
	// (function( win ){
	// 	var doc = win.document;
	   	
	// 	// If there's a hash, or addEventListener is undefined, stop here
	// 	if( !location.hash && win.addEventListener ){
	// 		//scroll to 1
	// 		window.scrollTo( 0, 1 );
	// 		var scrollTop = 1,
	// 			getScrollTop = function(){
	// 				return win.pageYOffset || doc.compatMode === "CSS1Compat" && doc.documentElement.scrollTop || doc.body.scrollTop || 0;
	// 			},
	// 			//reset to 0 on bodyready, if needed
	// 			bodycheck = setInterval(function(){
	// 				if( doc.body ){
	// 					clearInterval( bodycheck );
	// 					scrollTop = getScrollTop();
	// 					win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
	// 				}	
	// 			}, 15 );
	// 		win.addEventListener( "load", function(){
	// 			setTimeout(function(){
	// 					//reset to hide addr bar at onload
	// 					win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
	// 			}, 0);
	// 		} );
	// 	}
	// })( this );


	//Tiny  Scrollbar
	var oScrollbar = $('.fb-friends-list');
	
	oScrollbar.tinyscrollbar();
	oScrollbar.tinyscrollbar_update();
});			
