<?php
include_once('includes/settings.php');
include('includes/functions.php');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<title><?php echo SITETITLE; ?></title>

<link rel="stylesheet" href="css/default.css" type="text/css" />

<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/functions.js"></script>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>

<body>
<?php
//if(!isset($hasdetail))
//	google_maps('0','0','map','3','100%','350','ROADMAP','','','yes','images/icon-marker.png','no','');
?>
<div id="wrapper">
	<div id="innerwrapper">
		<div id="header">
			<?php if(HEADER_DISPLAY == 1) { ?>
				<div class="image">
					<?php if(HEADER_IMAGE != '') { ?>
						<img src="includes/timthumb.php?src=<?php echo HEADER_IMAGE; ?>&amp;w=980&amp;h=266" alt="<?php echo SITETITLE; ?>" width="980" height="266" />
					<?php } else { ?>
						<img src="images/header-1.jpg" alt="<?php echo SITETITLE; ?>" width="100%" height="266" />
					<?php } ?>
					<h2><span><?php echo SITETITLE; ?></span></h2>
				</div>
			<?php } else if(HEADER_DISPLAY == 0) { ?>
				<h1><?php echo SITETITLE; ?></h1>
			<?php } else { ?>
				<?php
				$latest_result = mysql_query("SELECT address FROM data WHERE approved='1' AND address != '' ORDER BY date DESC LIMIT 1");
				$latest_row = mysql_fetch_array($latest_result);

				if(!isset($hasdetail))
					google_maps('0','0','map','3','100%','266','ROADMAP',$latest_row['address'],'','yes','images/icon-marker.png','no','');
				?>
			<?php } ?>
			<ul id="nav">
				<li><a href="index.php">Home</a></li>
				<?php if(is_authed()) {?>
					<li><a href="admin.php">My Properties</a></li>
					<li><a href="cpanel.php">My Profile</a></li>

					<?php
					if(is_admin()) echo '<li><a href="admin/index.php">Administration</a></li>';
					?>

					<li><a href="logout.php">Log out</a></li>
				<?php }?>
				<?php if(!is_authed()) {?>
					<li><a href="login.php">Log in</a></li>
					<li><a href="register.php">Register</a></li>
				<?php }?>
			</ul>
			<ul id="subnav">
				<?php
				$sql_0 = mysql_query("SELECT * FROM data WHERE approved=0");
				$sql_1 = mysql_query("SELECT * FROM data WHERE approved=1");
				$sql_u = mysql_query("SELECT * FROM user");
				$numresults_0 = mysql_num_rows($sql_0);
				$numresults_1 = mysql_num_rows($sql_1);
				$numresults_u = mysql_num_rows($sql_u);

				echo '<li>'.$numresults_0.' pending properties</li>';
				echo '<li>'.$numresults_1.' active properties</li>';
				echo '<li>'.$numresults_u.' members</li>';
				?>

			</ul>
		</div>
		<?php include('includes/sidebar.php');?>
