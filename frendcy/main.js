var modal = null;
$(function() {


	//Toggle button - Magic Button
	$('.fb-friends-list li a').click(function(){
		if($(this).hasClass("selected")){
			selected_friends.splice(selected_friends.indexOf($(this).attr("title")),1);	
			$(this).removeClass("selected");
			$(this).text("Show Interest");
			$(this).prev('.friend-details').removeClass('checked');
		}else{
			if(selected_friends.length>=parseInt($("#max_selection").val())){ 
				alert("Maximum of "+$("#max_selection").val()+" selections only allowed");
				return false;
			}
			selected_friends.push($(this).attr("title"));
			$(this).addClass("selected");
			$(this).text("Remove");
			$(this).prev('.friend-details').addClass('checked');
		}
	});

	//Hide the address bar on mobile
	window.addEventListener('load',function() {
		// Set a timeout...
		setTimeout(function(){
			// Hide the address bar!
			window.scrollTo(0, 1);
		}, 0);
	});

	// About and Contact click scroll to section
	$('.scroll-link a').click(function(e){
        $('html, body').animate({
            scrollTop: $('.site-info-contact').offset().top
        }, 1000);
        e.preventDefault();
    });

	//Animate the logged in page hero 
	$('.logged header').animate({
	    height: '75'
	    }, 2500);
	
	//Pop-up Modal
		modal = $('#modal'),
		popup = $('.popup-container'),
		messageShare = $('#message-share'),
		clear = $('#make-it-clear'),
		height = $(document).height();

	$('.worried').on('click', function(){
		showModal();
		showClear();
	});

	//Close overlay
	$('.close-btn').on('click', function() {
		closeOverlay();
	});

});			

function showModal() {
	modal.css('height', height)
	modal.fadeIn(300);
	$(window).scrollTop(0);
}

function closeOverlay() {
	modal.fadeOut(300);
	popup.fadeOut(300);
}

function showMsgShare() {
	messageShare.fadeIn(300);
}

function showClear() {
	clear.fadeIn(300);
}
