<?php
// Cinnamon Boards
// Version: 2.0.4
// Type: configuration file

// set your default timezone (optional)
// see list here: http://www.php.net/manual/en/timezones.php
date_default_timezone_set('UTC');

// set your database details (required)
$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'gbforum';

// set your results/page (optional)
$per_page = 10;

define('CB_VERSION', '2.0.4');

// set your reCAPTCHA details (recommended)
define('CB_RC_PUBLIC', '');
define('CB_RC_PRIVATE', '');
// get a key from https://www.google.com/recaptcha/admin/create

// set your Google Analytics tracking code (recommended)
define('CB_GA', 'UA-XXXXX-X');

// set skin mode (choose from 'default', 'xbox')
define('CB_SKIN', 'xbox');

// set maintenance mode // display thread removal links
define('CB_MAINTENANCE', true);

// set username requirements (4chan style)
define('CB_REQUEST_USERNAME', true);
define('CB_USERNAME_PREFIX', 'anonymous-');

//
mysql_connect($host, $user, $pass);
mysql_select_db($database);
?>
