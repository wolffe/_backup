<?php
$filename = 'report'.date('-Ymd-h-i-s').'.doc';
header("Content-type: application/msword; filename=$filename");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: ");
header("Cache-Control: ");
?>
<html>
<head></head>
<body>
<?php echo $_REQUEST['datatodisplaydoc'];?>
</body>
</html>