<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>root admin</title>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<script type="text/javascript" src="images/dialog.js"></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!-- Redactor is here -->
<link rel="stylesheet" href="js/redactor/redactor/redactor.css" />
<script src="js/redactor/redactor/redactor.min.js"></script>

<script>
//http://imperavi.com/redactor/docs/settings/
$(function(){
    $('#content').redactor({
        imageUpload: 'js/redactor/demo/scripts/image_upload.php',
//        fileUpload: 'js/redactor/demo/scripts/file_upload.php',
//        imageGetJson: 'js/redactor/demo/json/data.json'
    });
});
</script>

</head>
<body>
<div class="navigation">
	<ul>
		<li><a href="admin.php?mode=list">Posts</a></li>
		<li><a href="admin.php?mode=add">New post</a></li>
		<li><a href="admin.php?mode=options"><b>root</b> settings</a></li>
		<li><a href="admin.php?mode=password"><b>root</b> account</a></li>
		<li><a href="admin.php?mode=logout" onclick="return confirm_dialog('admin.php?mode=logout', 'Are you sure you want to logout?');">Logout</a></li>
	</ul>
	<br class="clear" />
</div>
