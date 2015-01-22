<?

### THIS IS THE PAYPAL BUTTON USED BY THE SCRIPT.


    echo "<p><form action=https://www.paypal.com/cgi-bin/webscr method=post>
<input type=hidden name=cmd value='_xclick-subscriptions'>
<input type=hidden name=no_shipping value='1'>
<input type=hidden name=no_note value='1'>
<input type=hidden name=p3 value='$paypal_period'>
<input type=hidden name=t3 value='$paypal_term'>";

    echo "<input type=hidden name=src value='1'>
<input type=hidden name=sra value='1'>
<input type=hidden name=business value='$paypal_email'>
<input type=hidden name=item_name value='$paypal_itemx'>
<input type=hidden name=item_number value='$paypal_item_number'>
<input type=hidden name=a3 value='$paypal_price'>
<input type=hidden name=notify_url value='$paypal_ipn'>
<input type=hidden name=cancel_return value='$paypal_cancel_return'>
<input type=hidden name=return value='$paypal_return'>
<input type=hidden name=os0 value='$dafuser'>
<input type=hidden name=on0 value='Username'>
<input type=hidden name=os1 value='$paypal_itemz'>
<input type=hidden name=on1 value='Premium Level'>
<input type=image src=$paypalbuttonimage border=0 name=submit alt='Upgrade!'>
</form>";

?>