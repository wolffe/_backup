<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Cinnamon Boards</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<?php
$start_time = microtime(true);
include('includes/forum.variables.php');
include('includes/forum.functions.php');
?>

<!--[if lte IE 9]>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/functions.js"></script>
<![endif]-->

<link rel="stylesheet" type="text/css" media="all" href="css/<?php echo CB_SKIN; ?>.css">
</head>
<body>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<div class="gb-forum">
	<h2 class="gb-main-title">Cinnamon Boards</h2>

	<form name="form2" method="post" action="">
		<p class="gb-main-menu">
			<a href="index.php">forum home</a><span class="middot"> &middot; </span>
			<a href="index.php?action=add_thread">start a new thread</a>

			<input type="hidden" name="action" value="show_search">
			<input required type="text" name="gb_search" class="gb-search" size="24" placeholder="Search threads and replies"> <input type="submit" name="Submit3" value="Search" class="gb-button gb-hidden">
		</p>
	</form>

	<?php
	if(isset($_POST['action'])) {
		if($_POST['action'] == 'post_reply')
			gb_reply();
		if($_POST['action'] == 'post_thread')
			gb_post();
		if($_POST['action'] == 'show_search') {
			echo '<p class="gb-mini-title">Search results</p>';
			ShowSearch();
		}
	}
	?>

	<?php
	if(!isset($_GET['action'])) {
		?>
		<p class="gb-mini-title">Threads</p>
		<div class="gb-bubble">
			<div class="gb-half"><b>Title</b></div>
			<div class="gb-quarter"><b>Time</b></div>
			<div class="gb-quarter"><b>Author</b></div>
			<div class="clearfix"></div>
		</div>
		<?php gb_threads();
	}
	if(isset($_GET['action'])) {
		if($_GET['action'] == 'remove_thread')
			thread_remove();
		if($_GET['action'] == 'show_thread')
			thread_display();
		if($_GET['action'] == 'add_thread') {
			?>
			<div class="gb-reply">
				<form name="form2" method="post" action="">
					<?php if(CB_REQUEST_USERNAME == false) { ?>
						<p><label> Start a new thread as </label><input required readonly type="text" name="gb_username" size="40" placeholder="Author" value="<?php echo CB_USERNAME_PREFIX . uniqid(); ?>"></p>
						<input type="hidden" name="gb_email" size="80" value="">
					<?php } else { ?>
						<p><div class="gb-alignleft gb-avatar" style="padding: 4px 0 0 0;"><img src="<?php get_gravatar('', 20); ?>" alt=""></div><label> Start a new thread as </label><input required type="text" name="gb_username" size="40" placeholder="Author"></p>
						<p><input required type="email" name="gb_email" size="80" placeholder="Email"></p>
					<?php } ?>
					<p><input required type="text" name="gb_thread_title" size="80" placeholder="Title"></p>
					<p><textarea name="gb_message" cols="80" rows="8"></textarea></p>
					<input type="hidden" name="action" value="post_thread">
					<?php
					if(defined('CB_RC_PUBLIC') && defined('CB_RC_PRIVATE')) {
						if(!function_exists('_recaptcha_qsencode'))
							require_once('includes/recaptchalib.php');
						echo recaptcha_get_html(CB_RC_PUBLIC);
					}
					?>
					<p><input type="submit" class="gb-button" name="Submit2" value="Post thread"></p>
				</form>
			</div>
			<?php }
		}
	?>

	<p class="gb-main-menu">Quick navigation: <?php gb_pages(); ?></p>

	<div class="gb-footer">
		<p>
			<?php
			$res = mysql_query("SHOW SESSION STATUS LIKE 'Questions'"); // 'Queries' shows total
			$row = mysql_fetch_array($res, MYSQL_ASSOC);
			?>
			&copy; 2011, <?php echo date('Y'); ?>. Powered by <a href="http://getbutterfly.com/products/cinnamon-boards-standalone-php-message-board/" rel="external">Cinnamon Boards</a> <?php echo CB_VERSION; ?><br>
			This page was generated in <?php echo(number_format(microtime(true) - $start_time, 2)); ?> seconds using <?php echo $row['Value']; ?> queries.
		</p>
	</div>
</div>

<!-- Google Analytics -->
<script>
var _gaq=[['_setAccount','<?php echo CB_GA; ?>'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src='//www.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
</body>
</html>
