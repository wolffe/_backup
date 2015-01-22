<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>gbStats</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/m-styles.min.css" rel="stylesheet">

<link href="templates/styles.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/m-radio.min.js"></script>
</head>
<body>

<h1>gbStats</h1>

<?php if(isset($adminlogged)) { ?>
	<?php include "includes/adminlinks.php"; ?>
<?php } elseif(!isset($id)) {?>
	<?php include "includes/loginform.php"; ?>
<?php } if(isset($id)) {?>
	<?php include "includes/memberlinks.php"; ?>
<?php }?>
