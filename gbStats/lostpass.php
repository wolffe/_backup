<?php


### THIS FILE RESETS AND RESENDS LOST PASSWORDS.

require("config.php");
$titlex = "$lostpasstitle";

include("templates/layout_top.php");

echo "<font class=stats_header>Lost Password</font><p>";


if ($username && $email) {
  $c=@mysql_query("select id,username,email from $userstable where username='$username' and email='$email'");
  $d=@mysql_fetch_object($c);
  if(is_object($d)) {
    $email=$d->email;
    $username=$d->username;
    $uid=$d->id;

    mt_srand((double)microtime()*1000000^getmypid());
    $pass_length = mt_rand($min_pass_length,$max_pass_length);
    while(strlen($password)<$pass_length) $password.=substr($chars,(mt_rand()%strlen($chars)),1);

    include "templates/mail-lost.php";
    mail($email,"$subject",$mail_msg,"From: $your_email");

    mysql_query("update $userstable set password='$password' where id='$uid'");
    echo 'Thank you, your password has been reset and an email has been sent to your email address.';
 }


  else {
    echo 'We are sorry, your details could not be found in our database.'; } }


else {
  echo 'If you have lost your password, enter your <b>username</b> and the <b>email address</b> you signed up with. We will then send you an email which will contain a new password.<p><form method=post><table><tr><td align=right>Username:</td><td><input type=text name=username maxlength=255 class=textinput></td></tr><tr><td align=right>Email:</td><td><input type=text name=email maxlength=255 class=textinput></td></tr><tr><td> </td><td><input type=submit value=Resend class=button></td></tr></table></form>'; } 



include("templates/layout_bottom.php");


?>