<?php 
error_reporting(E_ALL);

// database variables
$dbhost = "localhost";
$dbuser = "rooie_crmroot";
$dbpass = "ciprian";
$dbname = "rooie_crm";

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