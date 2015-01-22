<?php
$adminlogged = null;
if(isset($HTTP_COOKIE_VARS['adminp']) == "$adminpass" && $HTTP_COOKIE_VARS['adminu'] == "$adminuser")
	$adminlogged = 1;

if($password && $username) {
	$logging = 1;
}
elseif($HTTP_COOKIE_VARS['twuser'] && $HTTP_COOKIE_VARS['twpass']) {
	$logging = 1;

$username = $HTTP_COOKIE_VARS['twuser'];
$password = $HTTP_COOKIE_VARS['twpass']; }

$c=mysql_query("select * from $userstable where username='$username' and password='$password' limit 1");

if ($adminlogged && $uname) $username = $uname;
if ($adminlogged) $c=mysql_query("select * from $userstable where username='$username' limit 1");




$d=mysql_fetch_object($c);
if(is_object($d)) { 

	if ($adminlogged) {
		$username = $d->username;
		$password = $d->password; }

	$logged = 1;
	if (isset($remember)) {
		setcookie("twuser",$username,strtotime("+1 week"));
		setcookie("twpass",$password,strtotime("+1 week")); }
	if (!isset($remember)) {
		setcookie("twuser",$username);
		setcookie("twpass",$password); } }

if ($logging && !$logged) {
	include("templates/layout_top.php");
	echo "<font class=error_font>$invaliduser</font><p>$nologgedin<p>";
	include "templates/layout_bottom.php";
	exit; }
elseif (!$logging && !$logged) {
	include("templates/layout_top.php");
	echo "$nologgedin<p>";
	include "templates/layout_bottom.php";
	exit; }

?>
