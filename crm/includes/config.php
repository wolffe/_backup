<?php 
error_reporting(E_ALL);

// database variables
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crm";

// database connection
$database = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $database);

// language settings
$lng = 'en';

// backup settings
$from_emailaddress = '';
$report_emailaddress = '';
$to_emailaddress = '';
?>