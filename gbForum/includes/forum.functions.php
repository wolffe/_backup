<?php
// reply to a thread
function gb_reply() {
	$gb_username = $_POST['gb_username'];
	$gb_email = $_POST['gb_email'];
	$gb_message = addslashes($_POST['gb_message']);

	$gb_date = time();
	$gb_thread_id = $_POST['gb_thread_id'];

	//
	if(defined('CB_RC_PUBLIC') && defined('CB_RC_PRIVATE')) {
		$publickey = CB_RC_PUBLIC;
		$privatekey = CB_RC_PRIVATE;
		$resp = null;

		if($_POST['recaptcha_response_field']) {
			require_once('includes/recaptchalib.php');
			$resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
			if($resp->is_valid) {
				mysql_query("INSERT INTO forum (gb_thread_id, gb_username, gb_email, gb_message, gb_date, gb_date_added) VALUES ('$gb_thread_id', '$gb_username', '$gb_email', '$gb_message', '$gb_date', '$gb_date')");
				mysql_query("UPDATE forum SET gb_date_added = '$gb_date' WHERE id = '$gb_thread_id'");
				mysql_query("UPDATE forum SET gb_date_added = '$gb_date' WHERE gb_thread_id = '$gb_thread_id'");

				echo '<p class="gb-success">Reply added successfully!</p>';
			}
			else {
				echo '<p class="gb-success">Incorrect verification code!</p>';
			}
		}
	}
	else {
		mysql_query("INSERT INTO forum (gb_thread_id, gb_username, gb_email, gb_message, gb_date, gb_date_added) VALUES ('$gb_thread_id', '$gb_username', '$gb_email', '$gb_message', '$gb_date', '$gb_date')");
		mysql_query("UPDATE forum SET gb_date_added = '$gb_date' WHERE id = '$gb_thread_id'");
		mysql_query("UPDATE forum SET gb_date_added = '$gb_date' WHERE gb_thread_id = '$gb_thread_id'");

		echo '<p class="gb-success">Reply added successfully!</p>';
	}
	//
}

// post a thread
function gb_post() {
	$gb_thread_title = $_POST['gb_thread_title'];
	if(!isset($_POST['gb_thread_id']))
		$gb_thread_id = 0;
	else
		$gb_thread_id = $_POST['gb_thread_id'];
	$gb_username = $_POST['gb_username'];
	$gb_email = $_POST['gb_email'];
	$gb_message = $_POST['gb_message'];

	$gb_date = time();
	$gb_date_added = $gb_date;

	//
	if(defined('CB_RC_PUBLIC') && defined('CB_RC_PRIVATE')) {
		$publickey = CB_RC_PUBLIC;
		$privatekey = CB_RC_PRIVATE;
		$resp = null;

		if($_POST['recaptcha_response_field']) {
			require_once('includes/recaptchalib.php');
			$resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
			if($resp->is_valid) {
				mysql_query("INSERT INTO forum (gb_thread_title, gb_thread_id, gb_username, gb_email, gb_message, gb_date, gb_date_added) VALUES ('$gb_thread_title', '$gb_thread_id', '$gb_username', '$gb_email', '$gb_message', '$gb_date', '$gb_date_added')");
				echo '<p class="gb-success">Thread added successfully!</p>';
			}
			else {
				echo '<p class="gb-success">Incorrect verification code!</p>';
			}
		}
	}
	else {
		mysql_query("INSERT INTO forum (gb_thread_title, gb_thread_id, gb_username, gb_email, gb_message, gb_date, gb_date_added) VALUES ('$gb_thread_title', '$gb_thread_id', '$gb_username', '$gb_email', '$gb_message', '$gb_date', '$gb_date_added')");
		echo '<p class="gb-success">Thread added successfully!</p>';
	}
	//
}

// display all threads
function gb_threads() {
	global $num, $per_page;
	if(isset($_GET['start']))
		$start = mysql_real_escape_string($_GET['start']);
	else
		$start = 0;

	$result = mysql_query("SELECT * FROM forum WHERE gb_thread_id = '' ORDER BY gb_date_added DESC LIMIT $start, $per_page");

	while($row = mysql_fetch_object($result)) {
		$hm_replies = 0;
		$id = $row->id;
		$gb_thread_title = $row->gb_thread_title;
		$gb_date = $row->gb_date_added;
		$gb_username = $row->gb_username;
		$gb_date = date('d.m.Y H:i', $gb_date);
		$result1 = mysql_query("SELECT gb_thread_id, gb_date FROM forum WHERE gb_thread_id = '$id' ORDER BY gb_date");

		while($row1 = mysql_fetch_object($result1)) {
			$hm_replies++;
		}

		// show admin links
		if(CB_MAINTENANCE == true) {
			$cbm_admin_links = '<br><small><a href="index.php?action=remove_thread&amp;thread_id=' . $id . '" onclick="return confirm(\'Are you sure you want to delete this thread?\');">Remove</a></small>';
		} else {
			$cbm_admin_links = '';
		}
		//

		if(strlen($gb_thread_title) > 30)
			$gb_thread_title = substr($gb_thread_title, 0, 30) . ' [...]';
		if(strlen($gb_username) > 20)
			$gb_username = substr($gb_username, 0, 20) . ' [...]';

		echo '
		<div class="gb-bubble gb-margin-3">
			<div class="gb-half">
				<a href="index.php?action=show_thread&id=' . $id . '">' . $gb_thread_title . '</a> <em>(' . $hm_replies . ' replies)</em>
				' . $cbm_admin_links . '
			</div>
			<div class="gb-quarter">' . $gb_date . '</div>
			<div class="gb-quarter">' . $gb_username . '</div>
			<div class="clearfix"></div>
		</div>
		';
	}
}

// paginate threads
function gb_pages() {
	global $num, $forum, $per_page;

	$result = mysql_query("SELECT * FROM forum WHERE gb_thread_id = ''");
	$num = mysql_num_rows($result);

	if($num > $per_page) {
		$pages = $num / $per_page;
		$pages = ceil($pages);

		if(isset($_GET['start'])) {
			$start = mysql_real_escape_string($_GET['start']);
			$i = (mysql_real_escape_string($_GET['start']) / $per_page) - 1;
		}
		else {
			$start = 0;
			$i = 0;
		}

		if($i < 1) {
			$i = 1;
			$_GET['suite'] = 0;
		}
		else
			$_GET['suite'] = $start - (2 * $per_page);

		if (($pages - $i) >= 5)
			$pages1 = $i + 4 ;
		else
			$pages1 = $pages;

		if ($i >= 2)
			echo "<a href='index.php?start=0'>first</a> &nbsp;...&nbsp; ";
		for ($i; $i<= $pages1; $i++) {
			if ($_GET['suite'] == $start)
				echo "<a href='index.php?start={$_GET['suite']}'>[$i]</a> ";
			else
				echo "<a href='index.php?start={$_GET['suite']}'>$i</a> ";
			$_GET['suite'] = $_GET['suite'] + $per_page;
		}
		$fin = ($pages - 1) * $per_page;
		if (($i-1) < $pages)
			echo " &nbsp;...&nbsp; <a href='index.php?start=$fin'>last</a>";
	}
	else {
		if ($_GET['action'] == "afficher_le_forum" AND $forum) echo "<a href='index.php?action=afficher_le_forum&forum=$forum&start=0'>[1]</a>";
		else echo "<a href='index.php?start=0'>[1]</a>";
	}
}

function thread_remove() {
	$thread_id = mysql_real_escape_string($_GET['thread_id']);
	
	mysql_query("DELETE FROM forum WHERE id = '$thread_id' LIMIT 1");
	echo '<p class="gb-success">Thread removed successfully!</p>';
}

function thread_display() {
	global $forum;
	$id = mysql_real_escape_string($_GET['id']);
	$result = mysql_query("SELECT * FROM forum WHERE id = '$id' ORDER BY gb_date");
	while($row = mysql_fetch_object($result)) {
		$id = $row->id;
		$duplicate_id = $row->id;
		$gb_username = $row->gb_username;
		$gb_email = $row->gb_email;
		$gb_thread_title = $row->gb_thread_title;
		$gb_message = stripslashes(nl2br($row->gb_message));
		$gb_date = $row->gb_date;
		$gb_date = date("d.m.Y - H:i", $gb_date);
	}
	echo '<br><br><br>';

	if(strlen($gb_thread_title) > 30)
		$gb_thread_title = substr($gb_thread_title, 0, 30) . ' [...]';
	if(strlen($gb_username) > 20)
		$gb_username = substr($gb_username, 0, 20) . ' [...]';

	echo '<h2 class="gb-thread-title gb-alignright">' . $gb_thread_title . '</h2>';
	echo '<div class="gb-alignleft gb-avatar"><img src="' . get_gravatar($gb_email) . '" alt=""></div>';
	echo '<div class="gb-intro"><strong>' . $gb_username . '</strong> started a new thread: <b>' . $gb_thread_title . '</b></div><div class="gb-meta">' . $gb_date . '</div>';
	echo '<div class="gb-puddle">' . $gb_message . '</div>';

	$result = mysql_query("SELECT * FROM forum WHERE gb_thread_id = '$id' ORDER BY gb_date");
	if(mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_object($result)) {
			$id = $row->id;
			$gb_username = $row->gb_username;
			$gb_email = $row->gb_email;
			$gb_thread_title = $row->gb_thread_title;
			$gb_message = stripslashes(nl2br($row->gb_message));
			$gb_date = $row->gb_date;
			$gb_date = date('d.m.Y - H:i', $gb_date);

			// show admin links
			if(CB_MAINTENANCE == true) {
				$cbm_admin_links = '<br><small><a href="index.php?action=remove_thread&amp;thread_id=' . $id . '" onclick="return confirm(\'Are you sure you want to delete this reply?\');">Remove</a></small>';
			} else {
				$cbm_admin_links = '';
			}
			//

			echo '<div class="gb-reply">';
				echo '<div class="gb-alignleft gb-avatar"><img src="' . get_gravatar($gb_email) . '" alt=""></div>';
				echo '<div class="gb-intro"><strong>' . $gb_username . '</strong> replied:</div><div class="gb-meta">' . $gb_date . ' 
				' . $cbm_admin_links . '
				</div>';
				echo '<div class="clearfix"></div>';
				echo '<div class="gb-bubble">' . $gb_message . '</div>';
			echo '</div>';
		}
	}
	else {
		echo '<div class="gb-reply"><p><em>No replies.</em></p></div>';
	}

	echo '
	<div class="gb-reply">
		<form name="form2" method="post" action="">';
			if(CB_REQUEST_USERNAME == false) {
				echo '<p><div class="gb-alignleft gb-avatar" style="padding: 4px 0 0 0;"><img src="' . get_gravatar('', 20) . '" alt=""></div> Post a reply as <input required readonly type="text" name="gb_username" size="40" value="' . CB_USERNAME_PREFIX . uniqid() . '"></p>';
				echo '<input type="hidden" name="gb_email" size="80" value="">';
			} else {
				echo '<p><div class="gb-alignleft gb-avatar" style="padding: 4px 0 0 0;"><img src="' . get_gravatar('', 20) . '" alt=""></div> Post a reply as <input required type="text" name="gb_username" size="40"></p>';
				echo '<p><input required type="email" name="gb_email" size="57" placeholder="Email"></p>';
			}

			echo '<p><textarea name="gb_message" cols="80" rows="8"></textarea></p>
			<div>
				<input type="hidden" name="gb_thread_id" value="' . $duplicate_id . '">
			</div>
			<input type="hidden" name="action" value="post_reply">';

			if(defined('CB_RC_PUBLIC') && defined('CB_RC_PRIVATE')) {
				if(!function_exists('_recaptcha_qsencode'))
					require_once('includes/recaptchalib.php');
				echo recaptcha_get_html(CB_RC_PUBLIC);
			}

			echo '<p><input type="submit" class="gb-button" name="Submit1" value="Post reply"></p>
		</form>
	</div>
	';
}

function ShowSearch() {
	$gb_search = $_POST['gb_search'];

	echo '
	<div class="gb-bubble">
		<div class="gb-half"><b>Title</b></div>
		<div class="gb-quarter"><b>Time</b></div>
		<div class="gb-quarter"><b>Author</b></div>
		<div class="clearfix"></div>
	</div>
	';

	$search_result = 0;
	if($gb_search && strlen($gb_search) > 2) {
		$result = mysql_query("SELECT * FROM forum WHERE gb_thread_title LIKE '%" . strtolower($gb_search) . "%' OR gb_message LIKE '%" . strtolower($gb_search) . "%' ORDER BY gb_date_added DESC");
		while($row = mysql_fetch_object($result)) {
			$id = $row->id;
			$gb_thread_id = $row->gb_thread_id;
			$gb_thread_title = $row->gb_thread_title;
			$gb_message = $row->gb_message;
			$gb_username = $row->gb_username;
			$gb_date = $row->gb_date_added;
			if($gb_thread_id) {
				$result1 = mysql_query("SELECT * FROM forum WHERE id = '$gb_thread_id'");
				while($row1 = mysql_fetch_object($result1)) {
					$id = $row1->id;
					$gb_thread_title = $row1->gb_thread_title;
					$gb_message = $row1->gb_message;
					$gb_date = $row1->gb_date_added;
				}
			}
			$gb_date = date('d.m.Y H:i', $gb_date);
			if(!isset($id_a))
				$id_a = array($id);
			else
				array_push($id_a,$id);
			$id_anzahl1 = count($id_a);
			$id_a = array_unique($id_a);
			$id_anzahl2 = count($id_a);
			if($id_anzahl2 == $id_anzahl1) {
				$result2 = mysql_query("SELECT id FROM forum WHERE gb_thread_id = '$id'");
				$hm_replies = mysql_num_rows($result2);
				$search_result++;
				echo '
				<div class="gb-bubble gb-margin-3">
					<div class="gb-half"><a href="index.php?action=show_thread&id='.$id.'">'.$gb_thread_title.'</a> <em>(' . $hm_replies . ' replies)</em></div>
					<div class="gb-quarter">' . $gb_date . '</div>
					<div class="gb-quarter">' . $gb_username . '</div>
					<div class="clearfix"></div>
				</div>
				';
			}
		}
	}
	if($search_result == 0) {
		echo '<p class="gb-error">No results found!</p>';
	}
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}
?>
