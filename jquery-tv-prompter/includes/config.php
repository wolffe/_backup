<?php 
error_reporting(0);
$version = '0.3';

// database variables
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'prompter';

// database connection
$database = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $database);
?>
