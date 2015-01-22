<?php
// database variables
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bmem";

// database connection
$database = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $database);
?>