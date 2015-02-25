<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>root install</title>
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700);
@import url(http://fonts.googleapis.com/css?family=Source+Code+Pro:300,400,700);

@import url(../css/font-awesome/css/font-awesome.min.css);

* {
	/**
	* Improve font rendering and readability/legibility on MacOS and Windows
	*/
	text-rendering: optimizeLegibility;
	-webkit-font-smoothing: antialiased;
 
	-moz-osx-font-smoothing: grayscale; 
 
	-moz-font-feature-settings: "liga=1, dlig=1";
	-ms-font-feature-settings: "liga", "dlig";
	-webkit-font-feature-settings: "liga", "dlig";
	-o-font-feature-settings: "liga", "dlig";
	font-feature-settings: "liga", "dlig";
	/* END */
 
	/**
	* Reset fix padding/margin/border sizing
	*/
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	/* END */
}

body {
	font-family: "Source Sans Pro", Helvetica, sans-serif;
    font-weight: 400;
	font-size: 14pt;
	margin: 0 auto;
	padding: 0;
}
b, strong { font-weight: 700; }

code {
    font-family: "Source Code Pro";
}
#wrapper {
	width: 100%;
	margin: 0 auto;
	padding: 16px;
}
span.success {
	font-weight:bold;
	color:#339900;
}
span.error {
	font-weight:bold;
	color:#ff0000;
}
span.sqlerror strong, span.tip strong {
	display:block;
	padding:5px;
	background-color:#ccc;
}
span.sqlerror, span.tip {
	border:1px solid #ccc;
	margin-top:10px;
	display:block;
	font-size:0.9em;
}
span.sqlerror span, span.tip span {	
	display:block;
	padding:5px;
}
span.sqlerror strong {
	background-color:#3399CC;
}
span.sqlerror {
	border:1px solid #3399CC;
}
h1 {
	border-bottom:1px solid #ddd;
	font-size:1.4em;
	color:#333;
}
a {
	font-size:0.9em;
	color:#ffffff;
	background-color:#333333;
	padding:3px;
	text-decoration:none;
}
</style>
</head>

<body>
<div id="wrapper">
    <h1><b>root</b> installer</h1>
    <?php
    define('IN_BLOG', true);
    define('PATH', '');

    include(PATH . 'includes/config.php');
    include(PATH . 'includes/functions.php');

    $link = mb_connect($sqlconfig);

    /* installer vars */
    $install_step = (int) $_GET['step'];

    $dbl = mysql_select_db($sqlconfig['dbname'], $link);

    $success = '<span class="success">success</span>';
    $fail    = '<span class="error">fail</span>';
    $exists    = '<span class="error">already exists</span>';

    $sql_error = '<br><span class="sqlerror"><strong>MySQL said:</strong><span>%s</span></span><br>';

    $tip  = '<span class="tip"><strong>Tip:</strong><span>%s</span></span>';
    $code = '<span class="tip"><strong>Code:</strong><span>%s</span></span>';

    $continue = '<p><a href="install.php?step=%d">Continue &raquo;</a></p>';

    if($install_step == 1 || $install_step == 0) {
        echo '<p>Testing connection...<br><small>If connection attempts ' . $fail . ', check your <code>includes/config.php</code> file for correct database details, then <a href="">refresh</a> this page.</small></p>';
        echo '<p>';
            echo 'Trying to connect to <b><code>' . $sqlconfig['host'] . '</code></b> using username <b><code>' . $sqlconfig['username'] . '</code></b> and password <b><code>' . $sqlconfig['password'] . '</code></b>... ';
            if(!$link) echo $fail;
            else echo $success;

            echo '<br>Trying to connect to <b><code>' . $sqlconfig['dbname'] . '</code></b>... ';
            if(!$dbl) echo $fail;
            else echo $success;
        echo '</p>';

        echo '<p>';
            echo 'Attempting to create database table <b><code>root</code></b>... ';

            $sql = "CREATE TABLE IF NOT EXISTS `root` (
				  `post_id` int(20) NOT NULL auto_increment,
				  `post_slug` varchar(255) NOT NULL default '',
				  `post_title` varchar(255) NOT NULL default '',
				  `post_content` longtext NOT NULL,
				  `date` int(20) NOT NULL default '0',
				  `published` int(1) NOT NULL default '0',
				  PRIMARY KEY  (`post_id`)
				)";

            $result = mysql_query($sql, $link);
            if(!$result) echo $fail . '<br>';
            else echo $success . '<br>';

            echo 'Attempting to create database table <b><code>root_config</code></b>... ';
            $sql = "CREATE TABLE IF NOT EXISTS `root_config` (
				  `config_name` varchar(255) NOT NULL default '',
				  `config_value` varchar(255) NOT NULL default '',
				  `config_explain` longtext NOT NULL,
  				  UNIQUE (`config_name`)
				)";

            $result2 = mysql_query($sql, $link);
            if(!$result2) echo $fail;
            else echo $success;
        echo '</p>';

        echo '<p>';
            echo 'Populating tables... ';

            $sql = "INSERT IGNORE INTO `root_config` (`config_name`, `config_value`, `config_explain`) VALUES
					('site-title', 'headline', 'Your blog/site title.'),
					('tagline', 'boilerplate / description line / motto', 'In a few words, explain what your blog is about.'),
                    ('theme-slug',  'default',  'Name of your theme folder (URL friendly version, e.g. <b>my-theme</b>'),
                    ('google-analytics', 'UA-XXXXXXXX-X',  'Google Analytics property ID.'),
					('posts-per-page', '5', 'Posts displayed each page'),
					('date-format', 'F d, Y', 'Date format as per the PHP date function <a href=\"http://www.php.net/date\">here</a>.'),
					('password', '5f4dcc3b5aa765d61d8327deb882cf99', 'Admin password'),
					('miniblog-filename', 'index.php', 'Name of the file which miniblog.php is included into.'),
					('use-modrewrite', 1, 'Use modrewrite for post URLs - use 1 for yes, 0 for no.')";

            $result = mysql_query($sql, $link);	

            $sql = "INSERT IGNORE INTO `root` (`post_slug`, `post_title`, `post_content`, `date`, `published`) VALUES
('welcome-to-root', 'Welcome to root!', '<p>Welcome to your new installation of <b>root</b>. To remove or edit this post, add new posts and change options, login to your administration panel.</p>', " . time() . ", 1)";

            $result2 = mysql_query($sql, $link);

            if(!$result || !$result2) echo $fail;
            else echo $success;
        echo '</p>';
    }

    ?>
    <hr>
	<p>If <b>root</b> installation was successful, delete <code>install.php</code> from your server root.</p>
    <p><small>View your <b>root</b> blog <a href="index.php">here</a> or log in to your <a href="adm/admin.php">administration panel</a> with the default password: <b>password</b>.</p>
</div>

</body>
</html>
<?php ob_end_flush(); ?>
