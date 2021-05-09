// back to top botton effect
$(document).ready(function(){

	// hide #back-top first
	$("#backtop").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#backtop').fadeIn();
			} else {
				$('#backtop').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#backtop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});


