<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<h2><?php echo $lang['WELCOME'];?> <em><?php echo $_SESSION['username'];?></em></h2>
	<?php echo $lang['FRONTPAGE_CONTENT'];?>

	<div class="table-wrap">
		<h2>User activity</h2>
		<?php
		$csql = "SELECT * FROM activity ORDER BY aID DESC LIMIT 50";
		$cresult = mysql_query($csql);
		while($crow = mysql_fetch_array($cresult)) {
			echo ''.$crow['aAction'].'<small> on '.$crow['aDate'].'</small>';
			echo '<hr />';
		}
		?>
	</div>

	<div class="table-wrap">
		<h2>Candidate activity <sup><small>BETA</small></sup></h2>
		<?php
		$csql = "SELECT * FROM items ORDER BY dateOfPlacement DESC";
		$cresult = mysql_query($csql);
		while($crow = mysql_fetch_array($cresult)) {
			echo '<img src="images/avatar.png" alt="" class="avatar-feed" />';
			echo '<strong><a href="edit.php?id='.$crow['id'].'">'.$crow['lastname'].', '.$crow['name'].'</a></strong> was placed on <strong>'.$crow['dateOfPlacement'].'</strong><br />';
			echo '<small>Placed by <strong>'.$crow['placed'].'</strong> on '.$crow['dateOfPlacement'].'</small>';
			echo '<br /><strong>Interview:</strong> '.$crow['interviews'].'';
			echo '<br /><strong>Comments:</strong> '.$crow['comments'].'<br />';
			echo '<hr />';
		}
		?>
	</div>
	<div class="clear"></div>

	<p><img src="images/logo.png" title="Tycoon CRM" alt="Tycoon CRM" /></p>
	<p><small>&copy;2010-<?php echo date('Y');?> <a href="http://getbutterfly.com/">getButterfly</a>.<br /><?php echo $lang['COPYRIGHT'];?></small></p>
<?php }?>

<?php include('includes/footer.php');?>
