<?

### THIS IS THE EMAIL SENT TO PEOPLE RESETTING THEIR PASSWORD. DO NOT HIT YOUR
### RETURN KEY ANYWHERE IN THIS MESSAGE, TYPE \n EVERYWHERE YOU WANT A RETURN CARRIAGE.
### YOU MUST USE $username AND $password HERE SOMEWHERE!!!!

$subject = "$site_name Lost Password";
$mail_msg="Hello $username,\n\nHere is a new password for you, don't lose it this time.\nYour username and password are:\n\nUsername: $username\nPassword: $password\n$siteurl/members.php\n\nAs always, we recommend that you change this randomly generated password as soon as possible.\n\nThanks,\nThe $site_name Team\n\nYou recieved this email because someone used your email address to sign up for a $freeitem at $siteurl. If this was not you, please log in at our site with the above usename and password and delete this account.";


?>