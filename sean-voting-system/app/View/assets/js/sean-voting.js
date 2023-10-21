(function( $ ) {
	'use strict';
	$(document).ready(function(){
		// Only if button is not active or disabled register click event
		$('.s-vote-btn:not(.disabled):not(.active)').on('click', function(){
			// Open XMLHttpRequest to add vote and retreive updated vote data
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if( xhr.readyState === 4 && xhr.status === 200 ) {
					let responseData = $.parseJSON(xhr.response)

					// Update HTML with latest vote data
					let happy_image = $('.s-vote-btn[aria-label="Yes"] img').clone();
					let sad_image = $('.s-vote-btn[aria-label="No"] img').clone();
					$('.s-vote-btn[aria-label="Yes"]').text(responseData.yes + '%').prepend(happy_image);
					$('.s-vote-btn[aria-label="No"]').text(responseData.no + '%').prepend(sad_image);

					$('.s-vote-container p').text('THANK YOU FOR YOUR FEEDBACK!');

					// Once HTML is set the click event is unbinded
					responseData.value == 'Yes' ? $('.s-vote-btn[aria-label="Yes"]').addClass('active').unbind() : $('.s-vote-btn[aria-label="Yes"]').addClass('disabled').unbind();
					responseData.value == 'No' ? $('.s-vote-btn[aria-label="No"]').addClass('active').unbind() : $('.s-vote-btn[aria-label="No"]').addClass('disabled').unbind();
				}
			}
			var ajax_url = script_object.ajax_url;
			xhr.open( 'POST', ajax_url, true );
			xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
			var params = 'action=vote_callback&vote=' + $(this).attr('aria-label') + '&page=' + $(this).data('id');
			xhr.send( params );
		});
	});
})( jQuery );
