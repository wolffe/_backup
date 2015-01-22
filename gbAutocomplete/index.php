<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>jQuery Autocomplete</title>
<meta name="viewport" content="width=device-width">

<style type="text/css">
* { font-family: Helvetica, sans-serif; }
body { font-size: 14px; }

.autosuggest { border: 1px solid #333333; background-color: #ffffff; }
.autosuggest a { display: block; padding: 3px; color: #333333; }
.autosuggest a:hover { background-color: #333333; color: #ffffff; }
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
<script src="autocomplete.js"></script>
</head>
<body>
	
<h2>Search Autocomplete</h2>
<p>
	<input type="search" size="48" name="example" id="color" rel="colors.php" placeholder="Type your search terms...">
	<label for="color">Search terms</label>
</p>

<script>$('#color').autosuggest();</script>
</body>
</html>
