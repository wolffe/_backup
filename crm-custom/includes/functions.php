<?php
$crm_version = '1.5.0';
$crm_codename = 'Tycoon CRM';

function showresults($query, $rank) {
	include('includes/config.php');
	include('languages/'.$lng.'.php');
	?>
	<div id="overlay"><?php echo $lang['PLEASE_WAIT'];?></div>
	<table id="items" class="tablesorter">
		<thead>
		<tr>
			<th></th>
			<th></th>
			<th><?php echo $lang['NAME'];?></th>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['ADDRESS_1'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th>Current Role Type</th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['QUALIFICATION'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['LAST_WORKPLACE'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['CURRENT_ROLE'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th></th><?php }?>
		</tr>
		</thead>
		<tbody>
		<?php
		$sql = $query;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			?>
			<tr>
				<td>
					<?php if($row['photo'] != '') {?>
						<a href="includes/timthumb.php?src=uploads/photos/<?php echo $row['photo'];?>&amp;w=600&amp;zc=1&amp;q=100" class="photo"><img src="includes/timthumb.php?src=uploads/photos/<?php echo $row['photo'];?>&amp;h=30&amp;w=30&amp;zc=1&amp;q=100" alt="" class="avatar" /></a>
					<?php } else {?>
						<img src="images/avatar.png" alt="" class="avatar" width="30" height="30" />
					<?php }?>
				</td>
				<td>
					<?php if(is_authed() && ($rank == '0')) {?>
						<a href="edit.php?id=<?php echo $row['id'];?>"><img src="images/icon-edit.png" alt="<?php echo $lang['EDIT'];?>" title="<?php echo $lang['EDIT'];?>" /></a><br />
						<?php if($row['linkedin'] != '') echo '<a href="'.$row['linkedin'].'" title="'.$row['linkedin'].'" rel="external" target="_blank"><img src="images/social/linkedIn.png" alt="" /></a>';?>
					<?php }?>
				</td>
				<td>
					<strong><a href="edit.php?id=<?php echo $row['id'];?>"><?php echo $row['name'].' '.$row['lastname'];?></a></strong><br />
					<?php if(is_authed() && ($rank == '0') && ($row['email'] != '')) {?><small>(<?php echo $row['email'];?>)</small><br /><?php }?>
					<?php
					$csql = "SELECT * FROM categories WHERE cid = '".$row['category']."'";
					$cresult = mysql_query($csql);
					while($crow = mysql_fetch_array($cresult)) {
						echo '<small>'.$crow['categoryname'].'</small><br />';
					}
					?>
				</td>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['address'];?>, <?php echo $row['location'];?>, <?php echo $row['county'];?>, <?php echo $row['country'];?><br /><?php echo $row['phone'];?>, <?php echo $row['mobile'];?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo strtoupper($row['currentRoleType']);?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['diplomas1'].', '.$row['diplomas2'].', '.$row['diplomas3'];?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['lastworkplace'];?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['currentworkplace'];?></td><?php }?>

				<?php if(is_authed() && ($rank == '0')) {?>
					<td><a href="delete.php?id=<?php echo $row['id'];?>"><img src="images/icon-delete.png" alt="<?php echo $lang['DELETE'];?>" title="<?php echo $lang['DELETE'];?>" /></a></td>
				<?php }?>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>

	<div class="clear"></div>
	<br clear="all" />
	<div id="pager" class="pager">
		<form action="">
			<div>
				<img src="images/first.png" class="first" alt="" />
				<img src="images/prev.png" class="prev" alt="" />
				<input type="text" class="pagedisplay" />
				<img src="images/next.png" class="next" alt="" />
				<img src="images/last.png" class="last" alt="" />
				<select class="pagesize">
					<option value="5">5</option>
					<option selected="selected" value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="75">75</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500">500</option>
				</select>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
}

function showresults_slim($query, $rank) {
	include('includes/config.php');
	include('languages/'.$lng.'.php');
	?>
	<div id="overlay"><?php echo $lang['PLEASE_WAIT'];?></div>
	<table id="items" class="tablesorter">
		<thead>
		<tr>
			<th><?php echo $lang['NAME'];?></th>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['QUALIFICATION'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['CURRENT_ROLE'];?></th><?php }?>
			<th>CV</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$sql = $query;
		$result = mysql_query($sql);
		$numrows = mysql_num_rows($result);
		while($row = mysql_fetch_array($result)) {
			?>
			<tr>
				<td>
					<strong><a href="edit.php?id=<?php echo $row['id'];?>"><?php echo $row['name'].' '.$row['lastname'];?></a></strong><br />
					<?php
					$csql = "SELECT * FROM categories WHERE cid = '".$row['category']."'";
					$cresult = mysql_query($csql);
					while($crow = mysql_fetch_array($cresult)) {
						echo '<small>'.$crow['categoryname'].'</small><br />';
					}
					?>
					<?php if(is_authed() && ($rank == '0') && ($row['email'] != '')) {?><small>(<?php echo $row['email'];?>)</small><br /><?php }?>
				</td>
				<?php if(is_authed() && ($rank == '0')) {?>
					<td>
						<?php
						$csql = "SELECT * FROM qualification ORDER BY qualificationName ASC";
						$cresult = mysql_query($csql);
						while($crow = mysql_fetch_array($cresult)) {
							if($crow['qID'] == $row['diplomas']) echo $crow['qualificationName'];
						}
						?>
					</td>
				<?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['currentworkplace'];?></td><?php }?>
				<td>
					<?php
					$aquery = "SELECT * FROM attachments WHERE itemid='".$row['id']."'";
					$aresult = mysql_query($aquery);
					while($arow = mysql_fetch_array($aresult)) {
						echo '<a href="uploads/resumes/'.$arow['attachment'].'" target="_blank"><img src="images/icon-cv.png" alt="" /></a><br />';
					}
					?>
				</td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php if($numrows == 0) echo '<p>No results found!</p>';?>
	<div class="clear"></div>
	<br clear="all" />
	<div id="pager" class="pager">
		<form action="">
			<div>
				<img src="images/first.png" class="first" alt="" />
				<img src="images/prev.png" class="prev" alt="" />
				<input type="text" class="pagedisplay" />
				<img src="images/next.png" class="next" alt="" />
				<img src="images/last.png" class="last" alt="" />
				<select class="pagesize">
					<option value="5">5</option>
					<option selected="selected" value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="75">75</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500">500</option>
				</select>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
}

function showresults_report($query, $rank, $showemail, $showphone, $showmobile) {
	include('includes/config.php');
	include('languages/'.$lng.'.php');
	?>
	<div id="overlay"><?php echo $lang['PLEASE_WAIT'];?></div>
	<table id="items" class="tablesorter">
		<thead>
		<tr>
			<th><?php echo $lang['NAME'];?></th>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['ADDRESS_1'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['QUALIFICATION'];?></th><?php }?>
			<?php if(is_authed() && ($rank == '0')) {?><th><?php echo $lang['CURRENT_ROLE'];?></th><?php }?>
		</tr>
		</thead>
		<tbody>
		<?php
		$sql = $query;
		$result = mysql_query($sql);
		$num_results = mysql_num_rows($result);
		echo '<tr><td colspan="4"><strong>'.$num_results.'</strong> result(s) found!<br /><small>Click on each result to view/edit.</small></td></tr>';
		while($row = mysql_fetch_array($result)) {
			?>
			<tr>
				<td>
					<strong><a href="edit.php?id=<?php echo $row['id'];?>"><?php echo $row['name'].' '.$row['lastname'];?></a></strong><br />
					<?php if(is_authed() && ($rank == '0') && ($row['email'] != '') && ($showemail == 1)) {?><small>(<?php echo $row['email'];?>)</small><br /><?php }?>
					<?php
					$csql = "SELECT * FROM categories WHERE cid = '".$row['category']."'";
					$cresult = mysql_query($csql);
					while($crow = mysql_fetch_array($cresult)) {
						echo '<small>'.$crow['categoryname'].'</small><br />';
					}
					?>
					<?php if(is_authed() && ($rank == '0')) {?>
						<?php if($row['linkedin'] != '') echo '<a href="'.$row['linkedin'].'" title="'.$row['linkedin'].'" rel="external" target="_blank"><img src="images/social/linkedIn.png" alt="" /></a>';?>
					<?php }?>
				</td>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['location'];?>, <?php echo $row['county'];?>, <?php echo $row['country'];?><br /><?php if($showphone == 1) echo $row['phone'];?>, <?php if($showmobile == 1) echo $row['mobile'];?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['diplomas1'].', '.$row['diplomas2'].', '.$row['diplomas3'];?></td><?php }?>
				<?php if(is_authed() && ($rank == '0')) {?><td><?php echo $row['currentworkplace'];?></td><?php }?>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>

	<div class="clear"></div>
	<br clear="all" />
	<div id="pager" class="pager">
		<form action="">
			<div>
				<img src="images/first.png" class="first" alt="" />
				<img src="images/prev.png" class="prev" alt="" />
				<input type="text" class="pagedisplay" />
				<img src="images/next.png" class="next" alt="" />
				<img src="images/last.png" class="last" alt="" />
				<select class="pagesize">
					<option value="5">5</option>
					<option selected="selected" value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="75">75</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500">500</option>
				</select>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
}

// Multiuser routines
function user_login($username, $password) {
	// Try and get the user using the username and encrypted pass
	$query = "SELECT uid, username FROM users WHERE username='$username' AND password='$password'";
	$result = mysql_query($query);
	$user = mysql_fetch_array($result);
	$numrows = mysql_num_rows($result);
	// Now encrypt the data to be stored in the session
	$encrypted_id = md5($user['uid']);
	$encrypted_name = md5($user['username']);
	// Store the data in the session
	//$_SESSION['uid'] = $userid;
	$_SESSION['username'] = $username;
	$_SESSION['encrypted_id'] = $encrypted_id;
	$_SESSION['encrypted_name'] = $encrypted_name;
	if ($numrows == 1) {
		return 'Correct';
	}
	else {
		return false;
	}
}

function user_logout() {
	// End the session and unset all vars
	session_unset();
	session_destroy();
}

function is_authed() {
	// Check if the encrypted username is the same as the unencrypted one, if it is, it hasn't been changed
	if (isset($_SESSION['username'])) {
		return true;
	}
	else {
		return false;
	}
}
		function daysDifference($endDate, $beginDate) {
			$beginDate = strtotime($beginDate);
			$endDate = strtotime($endDate);
			$diff = $endDate - $beginDate;
			$diff = ceil($diff / (60*60*24)) ;
			return $diff;
		}

?>
