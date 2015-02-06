<?php
$filename = 'report'.date('-Ymd-h-i-s').'.xls';
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=$filename");
header("Pragma: ");
header("Cache-Control: ");
?>
<head></head>
<body>
<?php echo $_REQUEST['datatodisplayxls'];?>
</body>
</html>