<?php
require('config.php');
include('includes/checklogineasy.php');

if($id && ($dafuser != 'demo')) echo '<script>document.location="members.php";</script>';
else $username = $HTTP_POST_VARS['username'];

$titlex = $signuptitle;
include('templates/layout_top.php');
$username = strtolower($username);

if(($agree) && ($signup)) {
  $i = 0;
  $messages = array();

	### CHECK USERNAME UNIQUENESS & SYNTAX
	if(ereg("^[A-Za-z0-9_]{1,15}$", $username)) {
		if($c = @mysql_query("SELECT username FROM $userstable WHERE username='$username'")) {
			$d = mysql_fetch_object($c);
			if(is_object($d)) {
				$messages[$i++] = "Username $username is in use.";
				unset($username);
			}
			else $z++;
		}
		else $messages[$i++] = mysql_error();
	}
	else {
		$messages[$i++]='Invalid username, use no more than 10 characters and only "a-z", "A-Z", and underscores "_".';
		unset($username);
	}

	### CHECK EMAIL SYNTAX AND UNIQUENESS
	if(!eregi("[.+\@.+\..+]{1,75}",$email)) {
		$messages[$i++] = 'Invalid email, use no more than 75 characters.';
		unset($email);
	}
	if($hhh = @mysql_query("select email from $userstable where email='$email'")) {
		$ooo = mysql_fetch_object($hhh);
		if(is_object($ooo)) { 
			$messages[$i++] = "There is already an account registered using the email address $email.<br>Only 1 account per email address. If you lost the password for your account, you can find it <a href=lostpass.php>here</a>.";
			unset($email);
		}
	}

	### CHECK FOR NAME
	if(!$first_name || !$last_name) {
		$messages[$i++] = 'You must enter your first and last name.';
		unset($category);
	}

	### CHECK FOR CORRECT URL SYNTAX AND VALIDITY
	if(!eregi("^[https?://.+\..+]{1,150}",$url)) {
		$messages[$i++] = 'Invalid URL, use no more than 150 characters and include http://.';
		unset($url);
	}

	### CHECK FOR CORRECT TITLE SYNTAX
	if(!$title) {
		$messages[$i++] = 'You must choose a title for your website.';
		unset($title);
	}

	### IF NO ERRORS, PROCESS THE SIGNUP
	if(!$messages[0]) {
		mt_srand((double)microtime()*1000000^getmypid());
		$pass_length = mt_rand($min_pass_length,$max_pass_length);
		while(strlen($password)<$pass_length) $password .= substr($chars,(mt_rand()%strlen($chars)),1);

		if($countertype == "31") $countertype = "inv";
		if($countertype == "32") $countertype = "txt";
		if($countertype == "33") $countertype = "log";

		if(@mysql_query("INSERT INTO $userstable (username, password, email, lastpay, lastaccess, signup, title, url, showsite, first_name, last_name, countertype) VALUES ('$username', '$password', '$email', '0', '".time()."', '".time()."', '$title', '$url', '$showsite', '$first_name', '$last_name', '$countertype')")) {
			$last_id = mysql_insert_id();
			$w = mysql_query("SELECT * FROM $mainstatstable WHERE id>='1' LIMIT 1");
			$u = mysql_fetch_object($w);
			mysql_query("UPDATE $mainstatstable SET actual_members='".($u->actual_members + 1)."' WHERE id='$u->id'");
			mysql_query("CREATE TABLE ".$statstableprefix."_".$last_id." (
	id int(9) unsigned not null auto_increment, 
	time int(13) not null default '0', 
	pageid int(9) default 0 not null default '0', 
	referer varchar(255) not null default '0', 
	ipaddress varchar(75) not null default '0', 
	browser varchar(35) not null default '0', 
	operatingsystem varchar(25) not null default '0', 
	screenresolution varchar(10) not null default '0', 
	colordepth int(8) unsigned not null default '0', 
	countrylanguage varchar(8) not null default '0', 
	url varchar(255) not null default '0', 
	href varchar(255) not null default '0', 
	hit int(1) not null default '0', 
	keywords varchar(75) not null default '0', 
	engine varchar(30) not null default '0', 
	ee int(1) not null, 
	primary key(id), 
	unique id(id))
      ") or die(mysql_error());

      mysql_query("create table ".$statstableprefix."_".$last_id."_old (
	id int(9) unsigned not null auto_increment, 
	pageid int(9) not null default '0',
	time int(13) not null default '0', 
	visitors int(13) not null default '0', 
	visits int(13) not null default '0', 
	hits int(13) not null default '0', 
	clicks int(13) not null default '0', 
	rv int(13) not null default '0', 
	primary key(id), 
	unique id(id))
      ") or die(mysql_error());



      echo "$thanks_for_signup";


      $uid = $last_id;
      include "includes/sitecode2.php";
      include "templates/mail-signup.php";
      mail($email,"$subject",$mail_msg,"From: $your_email");

      if($email_me_on_signup) {
        mail($your_email,"New $site_name Member","$username has signed up for a $freeitem at $site_name. Their URL is $url","From: $your_email"); } }

    else { die(mysql_error()); } }



  else {
    foreach($messages as $value) echo "<font class=error_font>$value</font><p>";

    if($showsite) $showsite_checked = " checked";
    echo "<p><form method=post name=ss><input type=hidden name=signup value=yes><input type=hidden value=yes name=agree>";
    include "includes/settings.php";
    echo "</form>"; } }
?>


<?php if(($agree) && (!$HTTP_POST_VARS['signup'])) {?>
	<h2>Signup!</h2>
	<p>After completing all fields click Submit. A password will be sent to your email address. **Be sure to check your Spam Folder if you don't see our email in your Inbox.</p>
	<?php if($showsite) $showsite_checked = " checked";?>
    <form method="post" name="ss">
		<input type="hidden" name="signup" value="yes">
		<input type="hidden" value="yes" name="agree">
		<?php include "includes/settings.php";?>
	</form>
<?php }?>

<?php if(!$agree) {?>
	<h2>Signup!</h2>
	<h3>Terms and Conditions</h3>
		<form>
			<textarea name="textfield" cols="60" rows="15" wrap="virtual"><?php include('templates/terms.php');?></textarea>
		</form>
		<p><a href="?agree=yes">I Agree</a> or <a href="index.php">I Disagree</a></p>
		<p>Read our <a href="<?php echo $siteurl;?>/privacy.php">Privacy Policy here</a>.</p>
<?php }?>

<?php include('templates/layout_bottom.php');?>
