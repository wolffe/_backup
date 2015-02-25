<?php
define('IN_BLOG', true);
define('PATH', '');
include('includes/miniblog.php');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $config['site-title']; ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<link rel="stylesheet" href="themes/default/normalize.css">
<link rel="stylesheet" href="themes/default/style.css">
<script src="js/vendor/modernizr-2.6.2.min.js"></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="adm/js/jquery.timeago.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    $("time.timeago").timeago();
});
</script>
</head>


<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-25886711-5']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<body>

<div class="wrapper">
	<h1 id="site-title"><?php echo $config['site-title']; ?></h1>
	<h2 id="tagline"><?php echo $config['tagline']; ?></h2>
    <div class="separator"></div>

	<?php echo $miniblog_posts; ?>

	<div class="navigation">
		<?php if(!$single) { ?>
			<?php if($miniblog_previous) { ?><p class="previous-link"><?php echo $miniblog_previous; ?></p><?php } ?>
			<?php if($miniblog_next) { ?> <p class="next-link"><?php echo $miniblog_next; ?></p><?php } ?>
		<?php } ?>
		<?php if($single) { ?>
			<p class="previous-link"><a href="<?php echo $config['miniblog-filename']; ?>">&laquo; return to posts</a></p>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<div class="footer">
		<p>
            &copy; <b><?php echo $config['site-title']; ?></b><br>
            <small>Powered by <a href="http://roo.ie"><b>root</b></a> &middot; &copy;2013-<?php echo date('Y'); ?></small>
        </p>
	</div>
</body>
</html>
