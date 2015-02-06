<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap">
		<h2>Tasks stream <sup><small>BETA</small></sup></h2>
		<?php
		if(isset($_GET['task'])) {
			$endTask = mysql_real_escape_string($_GET['task']);
			$tsql = "UPDATE tasks SET taskStatus = 1 WHERE taskID = $endTask";
			$tresult = mysql_query($tsql);
			echo '
				<p class="task-confirm">
					<img src="images/icon-check.png" alt="" /> Task has been marked as done!<br />
					<small>Find all tasks (completed and upcoming) on the <a href="diary.php">diary page</a>.</small>
				</p>';
		}

		$csql = "SELECT * FROM tasks WHERE taskStatus = 0 ORDER BY taskDate ASC";
		$cresult = mysql_query($csql);
		while($crow = mysql_fetch_array($cresult)) {
			if(daysDifference($crow['taskDate'], date('Y-m-d')) <= 0) {
				echo '<div class="task task-0"><span>OVERDUE:</span> ';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					if($crow['taskMeta'] > 0) echo '<a href="edit.php?id='.$crow['taskMeta'].'">Candidate link</a> ';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 0 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 15) {
				echo '<div class="task task-15">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					if($crow['taskMeta'] > 0) echo '<a href="edit.php?id='.$crow['taskMeta'].'">Candidate link</a> ';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 15 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 30) {
				echo '<div class="task task-30">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					if($crow['taskMeta'] > 0) echo '<a href="edit.php?id='.$crow['taskMeta'].'">Candidate link</a> ';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 30 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 60) {
				echo '<div class="task task-60">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					if($crow['taskMeta'] > 0) echo '<a href="edit.php?id='.$crow['taskMeta'].'">Candidate link</a> ';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 60 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 90) {
				echo '<div class="task task-90">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					if($crow['taskMeta'] > 0) echo '<a href="edit.php?id='.$crow['taskMeta'].'">Candidate link</a> ';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 90) {
				// hidden
			}
		}
		?>
	</div>
	<div class="table-wrap">
		<h2>Contracts stream <sup><small>BETA</small></sup></h2>
		<?php
		$csql = "SELECT * FROM items ORDER BY duration ASC";
		$cresult = mysql_query($csql);
		while($crow = mysql_fetch_array($cresult)) {
			if(daysDifference($crow['duration'], date('Y-m-d')) == 0) {
				echo '<div class="task task-0"><span>CONTRACT ENDED:</span> ';
					echo '<strong><a href="edit.php?id='.$crow['id'].'">'.$crow['lastname'].', '.$crow['name'].'</a></strong> contract ends soon!<br />';
					echo 'Contract end date: <strong>'.$crow['duration'].'</strong><br />';
					echo 'Days from now: '.daysDifference($crow['duration'], date('Y-m-d'));
				echo '</div>';
			}
			if(daysDifference($crow['duration'], date('Y-m-d')) > 0 && daysDifference($crow['duration'], date('Y-m-d')) <= 30 && $crow['duration'] != '0000-00-00') {
				echo '<div class="task task-30">';
					echo '<strong><a href="edit.php?id='.$crow['id'].'">'.$crow['lastname'].', '.$crow['name'].'</a></strong> contract ends soon!<br />';
					echo 'Contract end date: <strong>'.$crow['duration'].'</strong><br />';
					echo 'Days from now: '.daysDifference($crow['duration'], date('Y-m-d'));
				echo '</div>';
			}
			if(daysDifference($crow['duration'], date('Y-m-d')) > 30 && daysDifference($crow['duration'], date('Y-m-d')) < 60 && $crow['duration'] != '0000-00-00') {
				echo '<div class="task task-60">';
					echo '<strong><a href="edit.php?id='.$crow['id'].'">'.$crow['lastname'].', '.$crow['name'].'</a></strong> contract notification!<br />';
					echo 'Contract end date: <strong>'.$crow['duration'].'</strong><br />';
					echo 'Days from now: '.daysDifference($crow['duration'], date('Y-m-d'));
				echo '</div>';
			}
		}
		?>
	</div>
	<div class="clear"></div>
	<hr />

	<div class="table-wrap">
		<h2>User activity</h2>
		<?php
		$csql = "SELECT * FROM activity ORDER BY aID DESC LIMIT 12";
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
		$csql = "SELECT * FROM items ORDER BY dateOfPlacement DESC LIMIT 5";
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
