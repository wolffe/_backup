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

<style type="text/css">
body { margin: 0; padding: 0; background-color: #000000; }
p { margin: 0; padding: 0; }
.aligncenter { text-align: center; }
</style>
</head>
<body>

<?php
$idnumber = $_GET['idnumber'];
$type = $_GET['type'];
?>
<p class="aligncenter"><a href="<?php echo $type . $idnumber; ?>.png"><img src="<?php echo $type . $idnumber; ?>.png" alt=""></a></p>

</body>
</html>
