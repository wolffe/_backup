jQuery(document).ready(function($){
    $('#form').on('submit', function(e){
        e.preventDefault();

		$('#form p.message').remove();
		$('#form h2').after('<p class="message notice">' + fum_script.loadingmessage + '</p>');

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: fum_script.ajax,
            data: {
                'action'     : 'cinnamon_ajax_login', // Calls our wp_ajax_nopriv_ajaxlogin
                'username'   : $('#form #login_user').val(),
                'password'   : $('#form #login_pass').val(),
                'rememberme' : $('#form #rememberme').val(),
                'login'      : $('#form input[name="login"]').val(),
                'security'   : $('#form #security').val()
            },
            success: function(results) {
                if(results.loggedin === true) {
                    $('#form p.message').removeClass('notice').addClass('success').text(results.message).show();
                    $('#overlay, .login-popup').delay(5000).fadeOut('300m', function() {
                        $('#overlay').remove();
                    });
                    window.location.href = fum_script.redirecturl;
                } else {
                    $('#form p.message').removeClass('notice').addClass('error').text(results.message).show();
                }
            }
        });
    });

    $('#regform').on('submit', function(e){
        e.preventDefault();

		$('#regform p.message').remove();
        $('#regform h2').after('<p class="message notice">' + fum_script.registrationloadingmessage + '</p>');

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: fum_script.ajax,
            data: $("#regform").serialize() + '&action=cinnamon_process_registration',
            success: function(results) {
                if(results.registered === true) {
                    $('#regform p.message').removeClass('notice').addClass('success').text(results.message).show();
                } else {
                    $('#regform p.message').removeClass('notice').addClass('error').html(results.message).show();
                }
            }
        });
    });

	$('#pswform').on('submit', function(e){
        e.preventDefault();

        $('#pswform p.message').remove();
        $('#pswform h2').after('<p class="message notice">' + fum_script.loadingmessage + '</p>');

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: fum_script.ajax,
            data: {
                'action'     : 	'cinnamon_process_psw_recovery', // Calls our wp_ajax_nopriv_ajaxlogin
                'username'   : 	$('#pswform #forgot_login').val(),
                'forgotten'  :  $('#pswform input[name="forgotten"]').val(),
                'security'   : 	$('#pswform #security').val()
            },
            success: function(results) {
                if(results.reset === true) {
                    $('#pswform p.message').removeClass('notice').addClass('success').text(results.message).show();
                } else {
                    $('#pswform p.message').removeClass('notice').addClass('error').html(results.message).show();
                }
            }
        });
    });
});
