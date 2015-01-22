<?php
include('includes/config.php');

if(isset($_POST['submit'])) {
	$text_size 			= $_POST['text_size'];
	$text_colour 		= $_POST['text_colour'];
	$text_speed 		= $_POST['text_speed'];

	$container_height 	= $_POST['container_height'];

	$textfile 			= trim($_POST['textfile']);

	$query = "UPDATE options SET text_size='$text_size', text_colour='$text_colour', text_speed='$text_speed', container_height='$container_height' LIMIT 1";

	$myFile = 'textfile.txt';
	$fh = fopen($myFile, 'w') or die('Error opening file! Please check for read-only attributes!');
	fwrite($fh, $textfile."\n");
	fclose($fh);

	mysql_query($query);
}

$query = "SELECT * FROM options";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$text_size 			= $row['text_size'];
$text_colour 		= $row['text_colour'];
$text_speed 		= $row['text_speed'];

$container_height 	= $row['container_height'];

$myFile = 'textfile.txt';
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Virtual TV Prompter</title>
<link type="text/css" rel="stylesheet" media="all" href="css/style.black.css" />

<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="js/prompter-1.0.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
$(document).ready(function() {
	$rollprompter = $('div.wrapper div#prompter').prompter('pointer', <?php echo $text_speed; ?>);

//	Use start/stop controls on prompter mouseover
//	$rollprompter.mouseover(function() {
//		$($rollprompter).trigger('stop');
//	});
//	$rollprompter.mouseout(function() {
//		$($rollprompter).trigger('start');
//	});

	// begin paused
	$($rollprompter).trigger('stop');

	$('#play').click(function() {
		$($rollprompter).trigger('unpause');
	});
	$('#pause').click(function() {
		$($rollprompter).trigger('pause');
	});

	$('.trigger').click(function(){
		$('.panel').toggle('fast');
		return false;
	});

	$('#sizer a').click(function(){
		var ourText = $('.wrapper p');
		var currFontSize = ourText.css('fontSize');
		var finalNum = parseFloat(currFontSize, <?php echo $text_size;?>);
		var stringEnding = currFontSize.slice(-2);
		if(this.id == 'large') {
			finalNum *= 1.2;
		}
		else if(this.id == 'small'){
			finalNum /= 1.2;
		}
		ourText.css('fontSize', finalNum + stringEnding);
	});
});
//--><!]]>
</script>
</head>

<body>

<p class="safearea">
	<a href="#" id="play"><img src="images/button-play.png" alt="" title="Play" /></a> 
	<a href="#" id="pause"><img src="images/button-pause.png" alt="" title="Pause" /></a> 
	<img src="images/separator.png" class="separator" alt="" /> 
	
	<span id="sizer"><a href="#" id="large"><img src="images/font-large.png" alt="" title="Make the font larger" /></a> <a href="#" id="small"><img src="images/font-small.png" alt="" title="Make the font smaller" /></a></span> 
	<img src="images/separator.png" class="separator" alt="" /> 

	<a class="trigger" href="#"><img src="images/system-options.png" alt="" title="Toggle options panel" /></a> 
	<a href="index.php"><img src="images/system-restart.png" alt="" title="Restart prompter" /></a> 
</p>

<div class="wrapper">
	<div id="prompter" style="height: <?php echo $container_height;?>px">
		<p style="font-size: <?php echo $text_size;?>pt; white-space: normal; font-family: Arial; font-weight: bold; color: <?php echo $text_colour;?>; padding: 16px; padding-left: 52px;">
			<?php echo nl2br($theData);?>
			<br /><br />== END OF SCRIPT ==
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<!--This is the prompter text. It will flow at a constant speed and it can be paused by mousing over it. It was built as an alternative for executable TV teleprompter systems, and as a jQuery demonstration. More text here, and even more.<br /><br />[Commercial break]<br /><br />More text keeps flowing up.-->
		</p>
	</div>
</div>

<p class="center">
	<small>Use the toolbar at the top to control the prompter.</small>
</p>

<!-- // Begin Prompter Options //-->
<div class="panel">
	<h3>Prompter Options<a href="#" class="trigger"><img src="images/close.png" alt="" style="float: right" /></a></h3>
	<p>Here you can configure the prompter's options such as text size, speed, colour and overall height, depending on your monitor or TV size, and reading rhythm.</p>

	<form action="index.php" method="post">
		<div>
			<input type="text" name="text_size" id="text_size" value="<?php echo $text_size;?>" />
			<label for="text_size">Text size <span>default is 52</span></label>
		</div>
		<div>
			<input type="text" name="text_colour" id="text_colour" value="<?php echo $text_colour;?>" />
			<label for="text_colour">Text colour <span>default is #FFFFFF</span></label>
		</div>
		<div>
			<input type="text" name="text_speed" id="text_speed" value="<?php echo $text_speed;?>" />
			<label for="text_speed">Text speed <span>default is 40</span></label>
		</div>
		<div>
			<input type="text" name="container_height" id="container_height" value="<?php echo $container_height;?>" />
			<label for="container_height">Prompter height <span>default is 450</span></label>
		</div>
		<div>
			<textarea name="textfile" rows="6" cols="40"><?php echo $theData;?></textarea>
		</div>
		<div>
			<input type="submit" name="submit" value="Apply changes" />
		</div>
	</form>

	<div style="clear:both;"></div>
</div>
<!-- // End Prompter Options //-->

</body>
</html>
