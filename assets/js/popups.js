$(function() {

	$(document).on('click', '[data-toggles]', function() {

		var toggle = $(this).data('toggles');

		$('[data-is="'+toggle+'"]').toggleClass('is--toggled');

		// $(this).parents('.popup').removeClass('popup-open');
		// $('body').removeClass('animation-pause');

	});

});