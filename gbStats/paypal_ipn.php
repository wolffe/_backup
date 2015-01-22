<?php

require "config.php";

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Host: www.paypal.com:80\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

//set email variables
$From_email = "From: dd@dustafo.com";
$Subject_line = "test";

$email_msg = "Thanks for purchasing my item. Your order will be delivered in 3-4 days. We appreciate your business.";
$email_msg .= "\n\nThe details of your order are as follows:";
$email_msg .= "\n\n" . "Transaction ID: " .  $txn_id ;
$email_msg .= "\n" . "Payment Date: " . $payment_date;

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);






  ### Standard Instant Payment Notifiction Variables 
  $receiver_email = $_POST['receiver_email'];
  $item_name = $_POST['item_name'];
  $item_number = $_POST['item_number'];
  $quantity = $_POST['quantity'];
  $invoice = $_POST['invoice'];
  $custom = $_POST['custom'];
  $option_name1 = $_POST['option_name1'];
  $option_selection1 = $_POST['option_selection1'];
  $option_name2 = $_POST['option_name2'];
  $option_selection2 = $_POST['option_selection2'];
  $num_cart_items = $_POST['num_cart_items'];
  $payment_status = $_POST['payment_status'];
  $pending_reason = $_POST['pending_reason'];
  $payment_date = $_POST['payment_date'];
  $settle_amount = $_POST['settle_amount'];
  $settle_currency = $_POST['settle_currency'];
  $exchange_rate = $_POST['exchange_rate'];
  $payment_gross = $_POST['payment_gross'];
  $payment_fee = $_POST['payment_fee'];
  $mc_gross = $_POST['mc_gross'];
  $mc_fee = $_POST['mc_fee'];
  $mc_currency = $_POST['mc_currency'];
  $txn_id = $_POST['txn_id'];
  $txn_type = $_POST['txn_type'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $address_street = $_POST['address_street'];
  $address_city = $_POST['address_city'];
  $address_state = $_POST['address_state'];
  $address_zip = $_POST['address_zip'];
  $address_country = $_POST['address_country'];
  $address_status = $_POST['address_status'];
  $payer_email = $_POST['payer_email'];
  $payer_id = $_POST['payer_id'];
  $payer_status = $_POST['payer_status'];
  $payment_type = $_POST['payment_type'];
  $notify_version = $_POST['notify_version'];
  $verify_sign = $_POST['verify_sign'];


  ### Subscription Instant Payment Notifiction Variables 
  $subscr_date = $_POST['subscr_date'];
  $period1 = $_POST['period1'];
  $period2 = $_POST['period2'];
  $period3 = $_POST['period3'];
  $amount1 = $_POST['amount1'];
  $amount2 = $_POST['amount2'];
  $amount3 = $_POST['amount3'];
  $recurring = $_POST['recurring'];
  $reattempt = $_POST['reattempt'];
  $retry_at = $_POST['retry_at'];
  $recur_times = $_POST['recur_times'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $subscr_id = $_POST['subscr_id'];

 



if (strcmp ($res, "VERIFIED") == 0) {











    ### If this is a Subscription Signup for this service
    if ($txn_type == "subscr_signup") {
      include "templates/mail-paid.php";
      mail($payer_email,$subject,$message,"From: $paypal_email");
      $subject = "New Stats Subscription";
      $message = "The following member has signed up for $item_name. You grossed a total of $payment_gross on this transaction.\n\n$payer_email";
      mail($paypal_email,$subject,$message,"From: $paypal_email");
      mysql_query("update $userstable set lastpay='".time()."',paytype='option_selection2' where username='$option_selection1'");
      $w=mysql_query("select paid from $mainstatstable where id='1'");
      $u=mysql_fetch_object($w);
      mysql_query("update $mainstatstable set paid='".($u->paid+1)."' where id='1'"); }


    ### If this is a subscription cancel for this service
    if ($txn_type == "subscr_cancel") {
      include "templates/mail-cancelled.php";
      mail($payer_email,$subject,$message,"From: $paypal_email");
      $subject = "Cancelled Subscription Notice";
      $message = "$payer_email has just cancelled their subscription for $item_name";
      mail($paypal_email,$subject,$message,"From: $paypal_email");
      mysql_query("update $userstable set lastpay='0',paytype='0' where username='$option_selection1'");
      $w=mysql_query("select cancelled from $mainstatstable where id='1'");
      $u=mysql_fetch_object($w);
      mysql_query("update $mainstatstable set paid='".($u->paid+1)."' where id='1'"); }


    ### If this is a subscription payment for this service
    if ($txn_type == "subscr_payment") {
      include "templates/mail-renew.php";
      mail($payer_email,$subject,$message,"From: $paypal_email");
      $subject = "$item_name Payment";
      $message = "$payer_email has just made their subscription payment for $item_name";
      mail($paypal_email,$subject,$message,"From: $paypal_email");
      mysql_query("update $userstable set lastpay='0',paytype='0' where username='$option_selection1'"); }










}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation





    include "templates/mail-invalid.php";
    mail($payer_email,$subject,$message,"From: $paypal_email");









}
}
fclose ($fp);
}
?>

