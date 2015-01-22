// jQuery
$(document).ready(function() {
	// open popup and send capture email
	$('.captureMe').click(function (e) {
		$('#subscribe-widget').modal(); // add this line to document.ready to load dialog on pageload
		return false;
	});

	$('#captureSend').click(function() {
		var data = $('#emailMe').val();
		if(data == '')
			alert('Nu ai introdus o adresa de email valida!');
		else
		$.ajax({
			type: 'POST',
			url: '_captureMe.php',
			data: 'data=' + $('#emailMe').val() + '&idnumber=' + $('#idnumber').val() + '&type=' + $('#idtype').val(),
			success: function(data) {
				// alert(data); // show response from the php script.
				alert('Imaginea bijuteriei alese a fost trimisa cu succes!');
				$('#sb-container').fadeOut('slow');
				$('#btnt-overlay').fadeOut('slow');
				$('#btnt-container').fadeOut('slow');
			}
		});
		return false;
	});
});
