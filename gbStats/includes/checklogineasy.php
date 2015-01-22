<?php
if($HTTP_COOKIE_VARS['adminp'] == $adminpass && $HTTP_COOKIE_VARS['adminu'] == $adminuser) $adminlogged = 1;

if($adminlogged && $demo) $uname = 'demo';

if($password && $username) $logging = 1;
elseif($HTTP_COOKIE_VARS['twuser'] && $HTTP_COOKIE_VARS['twpass']) {
	$logging = 1;
	$username = $HTTP_COOKIE_VARS['twuser'];
	$password = $HTTP_COOKIE_VARS['twpass'];
}

if(!$demo) $c = mysql_query("SELECT * FROM $userstable WHERE username='$username' AND password='$password' LIMIT 1");
if($demo) $c = mysql_query("SELECT * FROM $userstable WHERE username='demo' LIMIT 1");

if($adminlogged && $uname) $username = $uname;
if($adminlogged) $c = mysql_query("SELECT * FROM $userstable WHERE username='$username' LIMIT 1");

$d = mysql_fetch_object($c);
if(is_object($d)) {
	if($demo || $adminlogged) {
		$username = $d->username;
		$password = $d->password;
	}
	$logged = 1;
	if($remember) {
		setcookie('twuser', $username, strtotime("+1 week"));
		setcookie('twpass', $password, strtotime("+1 week"));
	}
	if(!$remember) {
		setcookie('twuser', $username);
		setcookie('twpass', $password);
	}
}

$id = $d->id;
$dafuser = $d->username;
?>
