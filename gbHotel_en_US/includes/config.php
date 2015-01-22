<?php
// set your default timezone (optional)
// see list here: http://www.php.net/manual/en/timezones.php
date_default_timezone_set('UTC');

// database variables
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'gbhotel';

// database connection
$database = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $database);

define('HP_VERSION', '1.2');
?>