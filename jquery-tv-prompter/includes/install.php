<?php include('config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>XHTML TV Prompter v0.3</title>
<link type="text/css" rel="stylesheet" media="all" href="../css/style.black.css" />
</head>
<body>
<?php
$isql = "CREATE TABLE IF NOT EXISTS `options` (
	`id` 				int(11) NOT NULL AUTO_INCREMENT,
	`text_size` 		int(11) NOT NULL DEFAULT '72',
	`text_colour` 		varchar(7) COLLATE latin1_general_ci NOT NULL DEFAULT '#FFFFFF',
	`text_speed` 		int(11) NOT NULL DEFAULT '4',
	`container_height` 	int(11) NOT NULL DEFAULT '450',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;";
if(mysql_query($isql))
	echo '<p class="center">Database table(s) successfuly created or checked!</p>';
else
	die('<p class="center">Unable to create database table(s)!</p>');

$isql = "INSERT INTO `options` (`id`, `text_size`, `text_colour`, `text_speed`, `container_height`) VALUES (1, 52, '#FFFFFF', 40, 450);";
if(mysql_query($isql))
	echo '<p class="center">Database table(s) successfuly populated!</p>';
else
	die('<p class="center">Unable to populate database table(s)! Prompter is already installed!</p><p class="center"><small><a href="../index.php">Click here to start using the prompter!</a></small></p>
');

echo '<p class="center">Installation was successful!</p>';
echo '<p class="center">If prompter was already installed, no tables were overwritten!</p>';
?>
<p class="center">
	<small><a href="../index.php">Click here to start using the prompter!</a></small>
</p>

</body>
</html>
