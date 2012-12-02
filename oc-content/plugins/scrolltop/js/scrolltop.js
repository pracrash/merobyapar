$(document).ready(function(){
	$("#back-top-left").hide();
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top-left').fadeIn();
			} else {
				$('#back-top-left').fadeOut();
			}
		});
		$('#back-top-left a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});
$(document).ready(function(){
	$("#back-top-right").hide();
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top-right').fadeIn();
			} else {
				$('#back-top-right').fadeOut();
			}
		});
		$('#back-top-right a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});