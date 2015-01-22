/* Confirm function for category/account deletion	*/
/* Function taken from phpMyAdmin 				*/

/**
 * Displays an confirmation box before to submit a "DROP DATABASE" query.
 * This function is called while clicking links
 *
 * @param   object   the link
 * @param   object   the sql query to submit
 *
 * @return  boolean  whether to run the query or not
 */
function confirmLinkDropDB(theLink, theSqlQuery) {
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

	var is_confirmed = confirm(confirmMsgDropDB + '\n\n' + confirmMsg + ' ' + theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLinkDropDB()' function

function confirmLinkDropACC(theLink, theSqlQuery) {
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

	var is_confirmed = confirm(confirmMsg + ' ' + theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

	return is_confirmed;
} // end of the 'confirmLinkDropACC()' function

// js form validation stuff
var errorMsg0   = '';
var errorMsg1   = '';
var noDropDbMsg = '';
var confirmMsg  = 'Are you sure you want to';
var confirmMsgDropDB  = 'Warning! This operation will delete all accounts in the current category!';

jQuery(document).ready(function($){
	$("a[rel='colorbox']").colorbox({
		maxWidth: 900,
		scrolling: false
	});

	$('#mortgageCalc').click(function(){
		var L,P,n,c,dp;
		L = parseInt($('#mcPrice').val());
		n = parseInt($('#mcTerm').val()) * 12;
		c = parseFloat($('#mcRate').val())/1200;
		dp = 1 - parseFloat($('#mcDown').val())/100;
		L = L * dp;
		P = (L*(c*Math.pow(1+c,n)))/(Math.pow(1+c,n)-1);
		if(!isNaN(P)) {
			$('#mcPayment').val(P.toFixed(2));
		}
		else {
			$('#mcPayment').val('There was an error');
		}
		return false;
	});
});

function image_delete(id) {
	$.ajax({
		type: 'POST',
		url: 'image-delete.php',
		data: { 'uid': id },
		success: function(data){ 
			$('.u' + id).fadeOut('slow');
		},
	});
}

