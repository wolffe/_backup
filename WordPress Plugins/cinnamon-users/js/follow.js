jQuery(document).ready(function($) {
	/*******************************
	follow / unfollow a user
	*******************************/
	$( '.follow-links a' ).on('click', function(e) {
		e.preventDefault();

		var $this = $(this);

		if( pwuf_vars.logged_in != 'undefined' && pwuf_vars.logged_in != 'true' ) {
			alert( pwuf_vars.login_required );
			return;
		}

		var data      = {
			action:    $this.hasClass('follow') ? 'follow' : 'unfollow',
			user_id:   $this.data('user-id'),
			follow_id: $this.data('follow-id'),
			nonce:     pwuf_vars.nonce
		};

		$('img.pwuf-ajax').show();

		$.post( pwuf_vars.ajaxurl, data, function(response) {
			if( response == 'success' ) {
				$('.follow-links a').toggle();
			} else {
				alert( pwuf_vars.processing_error );
			}
			$('img.pwuf-ajax').hide();
		} );
	});
});