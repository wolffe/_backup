<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		$csql = "SELECT * FROM settings";
		$result = mysql_query($csql);
		$row = mysql_fetch_array($result);

		/*  PHP Paypal IPN Integration Class File
		 *  This single file serves as 4 virtual pages depending on the "action" varialble passed in the URL.
		 *  It's the processing page which processes form data being submitted to PayPal, it is the page PayPal returns a user to upon success, 
		 *  it's the page PayPal returns a user to upon canceling an order, and finally, it's the page that handles the IPN request from PayPal.
		*/

		// Setup class
		require_once('modules/payment/paypal/paypal.class.php');
		$p = new paypal_class;
		//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // DEBUG
		$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
		// setup a variable for this script (ie: 'http://www.domain.com/pay.paypal.php')
		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	// if there is not action variable, set the default action of 'process'
	if(empty($_GET['action'])) $_GET['action'] = 'process';  

	switch($_GET['action']) {
		case 'process': // Process and order...

		// There should be no output at this point. To process the POST data,
		// the submit_paypal_post() function will output all the HTML tags which
		// contains a FORM which is submited instantaneously using the BODY onload
		// attribute. In other words, don't echo or printf anything when you're
		// going to be calling the submit_paypal_post() function.

		// This is where you would have your form validation and all that jazz.
		// You would take your POST vars and load them into the class like below,
		// only using the POST values instead of constant string expressions.

		// For example, after ensuring all the POST variables from your custom order form are valid, you might have:

		// $p->add_field('first_name', $_POST['first_name']);
		// $p->add_field('last_name', $_POST['last_name']);

		$p->add_field('business', $row['email_paypal']);
		$p->add_field('return', $this_script.'?action=success');
		$p->add_field('cancel_return', $this_script.'?action=cancel');
		$p->add_field('notify_url', $this_script.'?action=ipn');
		$p->add_field('item_name', 'Property Listing');
		$p->add_field('amount', $row['price']);
		$p->add_field('currency_code', $row['currency']);

		$p->submit_paypal_post(); // submit the fields to paypal
		//$p->dump_fields();      // for debugging, output a table of all the fields
		break;

		case 'success': // Order was successful...

		// This is where you thank the user for their order. The order information at this point is in POST variables.
		// However, you don't want to "process" the order until you get validation from the IPN.
		// That's where you email an administrator, update the database with payment status, activate a property, etc.

		echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
		foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
		echo "</body></html>";

		// You could also simply re-direct them to another page, or your own 
		// order status page which presents the user with the status of their
		// order based on a database (which can be modified with the IPN code below).
		break;

	case 'cancel': // Order was canceled...
		echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
		echo "</body></html>";
		break;

	case 'ipn': // Paypal is calling page for IPN validation...
		// It's important to remember that paypal calling this script. There
		// is no output here.  This is where you validate the IPN data and if it's
		// valid, update your database to signify that the user has payed.  If
		// you try and use an echo or printf function here it's not going to do you
		// a bit of good.  This is on the "backend".  That is why, by default, the
		// class logs all IPN data to a text file.

		if($p->validate_ipn()) {
			// Payment has been recieved and IPN is verified.  This is where you
			// update your database to activate or process the order, or setup
			// the database with the user's order details, email an administrator,
			// etc.  You can access a slew of information via the ipn_data() array.

			// Check the paypal documentation for specifics on what information
			// is available in the IPN POST variables.  Basically, all the POST vars
			// which paypal sends, which we send back for validation, are now stored
			// in the ipn_data() array.

			// For this example, we'll just email ourselves ALL the data.
			$subject = 'PayPal IPN Payment - Received payment for property listing';
			$to = $row['email_paypal']; // your email
			$body 	=  "An Instant Payment Notification was successfully received\n";
			$body 	.= "from ".$p->ipn_data['payer_email']." on ".date('d/m/Y');
			$body 	.= " at ".date('H:i')."\n\nDetails:\n";

			foreach($p->ipn_data as $key => $value) {
				$body .= "\n$key: $value"; 
			}
			mail($to, $subject, $body);
		}
		break;
	}     
}
else restrictedAccess();
?>
</div>
<?php include('includes/bottom.php');?>
