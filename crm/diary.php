<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<h2>Tasks/Reminder Diary</h2>

	<?php
	if(isset($_POST['submit'])) {
		$taskTitle = $_POST['taskTitle'];
		$taskDate = $_POST['taskDate'];
		$taskContent = $_POST['taskContent'];
		$taskMeta = $_POST['taskMeta'];
		$taskAuthor = $username;
		$taskAdded = date('Y-m-d');

		$sql = "INSERT INTO tasks (taskTitle, taskDate, taskContent, taskMeta, taskAuthor, taskAdded) VALUES (
			'$taskTitle',
			'$taskDate',
			'$taskContent',
			'$taskMeta',
			'$taskAuthor',
			'$taskAdded'
		);";
		mysql_query($sql) or die();
		echo '<div class="table-wrap-wide">';
			echo '<div class="confirm">Task/reminder added successfully!</div>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}
	?>

	<div class="table-wrap-wide">
		<h2>Add New Task</h2>
		<p>Add a new task/reminder to database.</p>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<p><input type="text" name="taskTitle" /> Task/reminder title</p>
			<p><input type="text" name="taskDate" id="taskpicker" /> Task/reminder date</p>
			<p>Task<br /><textarea name="taskContent" rows="6" cols="80"></textarea></p>
			<p>Link this task/reminder to 
				<select name="taskMeta">
					<option value="">Select...</option>';
					<?php
					$csql = "SELECT * FROM items ORDER BY id ASC";
					$cresult = mysql_query($csql);
					while($crow = mysql_fetch_array($cresult)) {
						echo '<option value="'.$crow['id'].'">'.$crow['lastname'].', '.$crow['name'].'</option>';
					}
					?>
				</select> (optional)
			</p>
			<p><input type="submit" name="submit" class="button" value="Add task/reminder" /></p>
		</form>
	</div>
	<div class="clear"></div>

	<div class="table-wrap-wide">
		<h2>Tasks stream <sup><small>BETA</small></sup></h2>
		<p>Completed tasks are grayed out. Hover them with your mouse to make them visible.</p>
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
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 0 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 15) {
				echo '<div class="task task-15">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 15 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 30) {
				echo '<div class="task task-30">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 30 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 60) {
				echo '<div class="task task-60">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 60 && daysDifference($crow['taskDate'], date('Y-m-d')) <= 90) {
				echo '<div class="task task-90">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
			if(daysDifference($crow['taskDate'], date('Y-m-d')) > 90) {
				echo '<div class="task">';
					echo 'Task/reminder: <strong>'.$crow['taskTitle'].'</strong> | '.$crow['taskAuthor'].'<br />';
					echo 'Due date: <strong>'.$crow['taskDate'].'</strong><br />';
					echo '<small>'.$crow['taskContent'].'</small><br />';
					echo 'Days from now: '.daysDifference($crow['taskDate'], date('Y-m-d')).'<span style="float: right"><a href="?task='.$crow['taskID'].'"><img src="images/icon-tick.png" class="taskicon" alt="Mark as completed" title="Mark as completed" /></a></span>';
				echo '</div>';
			}
		}
		?>
	</div>

	<div class="clear"></div>
<?php }?>

<?php include('includes/footer.php');?>
