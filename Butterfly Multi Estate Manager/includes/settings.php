<?php
error_reporting(E_ALL); // was error_reporting(E_ALL);

// Start the session and seed the random number generator
if(!isset($_SESSION)) session_start();
srand();
if(isset($_SESSION['username'])) $user = $_SESSION['username'];

// settings file //
include_once('config.php');

$settings = mysql_query("SELECT * FROM settings");
$option = mysql_fetch_array($settings);

define('CURRENCY', $option['currency']);
define('SITETITLE', $option['sitetitle']);
define('VERSION', '1.3');

define('HEADER_DISPLAY', $option['header_display']);
define('HEADER_IMAGE', $option['header_image']);

//define('SITEURL', '../'.dirname(__DIR__));
// end of settings file
?>