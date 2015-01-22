<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>HTML5 Badge App</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/main.css">
</head>
<body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="jquery.btnt.popup.js"></script>
<script src="functions.js"></script>

<p>
	<a href="" class="captureMe" title="Save badge and send it via email.">Save your badge</a>
</p>
<div id="subscribe-widget">
	<p>Enter your email address and receive your badge now!</p>
	<form action="#" method="post" id="captureForm">
		<p style="text-align: center;">
			<input id="emailMe" name="email" placeholder="Email address..." required type="email" style="font-family: inherit; font-size: 16px; padding: 6px; width: 75%;" />
			<input id="idnumber" name="idnumber" type="hidden" value="1">
			<input id="didnumber" name="didnumber" type="hidden" value="23">
			<input id="idtype" name="idtype" type="hidden" value="i">
			<br>
			<input id="captureSend" type="submit" value="Send">
		</p>
	</form>
</div>


<img src="generateMe.php?idnumber=1&amp;idtype=i" alt="" style="display: none;">

</body>
</html>
