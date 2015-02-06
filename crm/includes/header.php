<?php
include('includes/config.php');
include('languages/'.$lng.'.php');
include('includes/functions.php');

/* start the session */
session_start();

if(is_authed()) {
	$username = $_SESSION['username'];
	$query = "SELECT * FROM users WHERE username='$username'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$rank = $row['rank'];

	$iquery = "SELECT * FROM items";
	$iresult = mysql_query($iquery);
	$activeusers = mysql_num_rows($iresult);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=initial-scale=1">
<meta name="viewport" content="maximum-scale=1">
<meta name="viewport" content="user-scalable=yes">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<link rel="shortcut icon" type="image/png" href="favicon.png">
<link rel="apple-touch-icon-precomposed" href="images/logo.png">

<meta name="HandheldFriendly" content="true">
<meta name="viewport" content="target-densitydpi=device-dpi">

<title>Tycoon Customer Relationship Management (CRM)</title>
<script type="text/javascript" src="http://cdn.roo.ie/jquery/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script> 
<script type="text/javascript" src="js/jquery.metadata.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script> 
<script type="text/javascript" src="js/jquery.lightbox-0.5.pack.js"></script>
<script type="text/javascript" src="js/jquery.jqprint.0.3.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#items').tablesorter({
		cancelSelection: true,
		widgets: ['zebra'],
	});
	$('#items').tablesorterPager({container: $('#pager')});

	//assign the sortStart event
	$('#items').bind('sortStart',function() {
		$('#overlay').show();
	}).bind('sortEnd',function() {
		$('#overlay').hide();
	});

	$('.photo').lightBox();
	$('#datepicker').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '1950:2011'
	});
	$('#availablepicker').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:2020'
	});
	$('#placementpicker').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:2020'
	});
	$('#followuppicker').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:2020'
	});

	$('#taskpicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:2020'
	});
	$('#durationpicker').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '2011:2040'
	});

	$('a.printme').click(function(){
		event.preventDefault();
		$("#printable").jqprint();
		//$('#divOpera').jqprint({ operaSupport: true });
		//return false; // NON-JQUERY-ESQUE METHOD
	});
});

function add_file_field() {
	var container = document.getElementById('file_container');
	var file_field = document.createElement('input');
	file_field.name = 'images[]';
	file_field.type = 'file';
	container.appendChild(file_field);
	var br_field = document.createElement('br');
	container.appendChild(br_field);
}
</script>

<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.8.5.custom.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/light.css" media="all" />

<link href="http://cdn.roo.ie/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="header">
	<h1>roo!<small>ie</small></h1>
	<div id="roo-service">_Customer Relationship Management</div>
</div>

<div id="wrap">
<?php if(!is_authed()) {?>
<div class="block">
	<div class="content">
		<form method="post" action="login.php" class="loginform">
			<p>
				<label for="username"><?php echo $lang['USERNAME'];?></label> <input type="text" name="username" id="username" value="" /> 
				<label for="password"><?php echo $lang['PASSWORD'];?></label> <input type="password" name="password" id="password" value="" /> 
				<input type="submit" name="submit" value="<?php echo $lang['LOGIN'];?>" />
			</p>
		</form>
	</div>
</div>
<?php } else {?>

<!-- BEGIN TOP NOTIFICATION BAR -->
<div class="topbar">
	Welcome <em><?php echo $username;?></em> | 
	<?php
	$tempsql = "SELECT * FROM tasks WHERE taskStatus = 0";
	$tempresult = mysql_query($tempsql);
	$numActiveTasks = mysql_num_rows($tempresult);
	echo 'You have <strong>'.$numActiveTasks.'</strong> active tasks | ';

	$csql = "SELECT * FROM tasks WHERE taskStatus = 0 ORDER BY taskDate ASC";
	$cresult = mysql_query($csql);
	while($crow = mysql_fetch_array($cresult)) {
		if(daysDifference($crow['taskDate'], date('Y-m-d')) <= 0) {
			echo '<strong class="blue">Overdue</strong> <small>('.$crow['taskDate'].')</small> <a href="diary.php">'.$crow['taskTitle'].'</a> | ';
		}
	}
	echo '<span class="title">Upcoming reminders:</span> ';
	$csql = "SELECT * FROM tasks WHERE taskStatus = 0 ORDER BY taskDate ASC";
	$cresult = mysql_query($csql);
	while($crow = mysql_fetch_array($cresult)) {
		if(daysDifference($crow['taskDate'], date('Y-m-d')) > 0 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 15) {
			echo '<strong>'.$crow['taskTitle'].'</strong> <em>('.$crow['taskDate'].')</em>, ';
		}
	}
	?>
</div>
<!-- END TOP NOTIFICATION BAR -->

<ul class="navigation">
	<li><a href="index.php"><?php echo $lang['DASHBOARD'];?></a></li>
	<li><a href="diary.php">Diary</a></li>

	<?php if(is_authed() && ($rank == '0')) {?>
		<li><a href="add.php"><?php echo $lang['ADD_CV'];?></a></li>
	<?php }?>

	<li><a href="view.php">List of CVs <span class="bubble"><?php echo $activeusers;?></span></a></li>
	<li><a href="search.php">Search</a></li>
	<li><a href="report.create.php">Search and manage reports</a></li>

	<?php if(is_authed() && ($rank == '0')) {?>
		<li><a href="settings.php"><?php echo $lang['USERS'];?></a></li>
		<li><a href="options.php"><?php echo $lang['OPTIONS'];?></a></li>
	<?php }?>
	<li><a href="help.php"><?php echo $lang['HELP'];?></a></li>
	<?php if(is_authed()) {?>
		<li style="float: right;"><a href="logout.php" style="border-right: none;"><small><?php echo $lang['LOGOUT'];?></small></a></li>
	<?php }?>
</ul>

<div class="clear"></div>
<ul class="navigation-secondary">
	<li><a href="roles.php">Roles of interest</a></li>
	<li><a href="categories.php">Industries/Categories</a></li>
	<li><a href="statuses.php">Statuses</a></li>
	<!--<li><a href="qualification.php">Qualification</a></li>-->
</ul>

<div class="clear"></div>
<?php }?>
