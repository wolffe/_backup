<?php include_once('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>HotelPress</title>

<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="style.css" type="text/css">

<script src="js/jquery-2.0.0.min.js"></script>
<script src="js/jquery.tablePagination.0.5.js"></script>
<script>
$(document).ready(function(){
	$('.hp-datatable').tablePagination({});

	$('.hp_unit_box').hover(function(){
		var title = $(this).attr('title');
		$(this).data('tipText', title).removeAttr('title');
		$('<p class="tooltip"></p>').text(title).appendTo('body').fadeIn('fast');
	}, function() {
		$(this).attr('title', $(this).data('tipText'));
		$('.tooltip').remove();
	}).mousemove(function(e) {
		var mousex = e.pageX + 20; //Get X coordinates
		var mousey = e.pageY + 10; //Get Y coordinates
		$('.tooltip').css({ top: mousey, left: mousex })
	});

	$('.hp_unit_box_link').hover(function(){
		var title = $(this).attr('title');
		$(this).data('tipText', title).removeAttr('title');
		$('<p class="tooltip"></p>').text(title).appendTo('body').fadeIn('fast');
	}, function() {
		$(this).attr('title', $(this).data('tipText'));
		$('.tooltip').remove();
	}).mousemove(function(e) {
		var mousex = e.pageX + 20; //Get X coordinates
		var mousey = e.pageY + 10; //Get Y coordinates
		$('.tooltip').css({ top: mousey, left: mousex })
	});
});
</script>
</head>
<body>

<div class="container">
	<header>
		<ul id="menu">
			<li class="hp-menu-head">HotelPress <small><?php echo HP_VERSION; ?></small></li>
			<li><a href="index.php">New Booking</a></li>
			<li><a href="unit-date-diagram.php">Manage Bookings</a></li>
			<li><a href="unit-admin.php">Manage Rooms</a></li>
			<li><a href="unit-view.php">Bookings/Room</a></li>
			<li><a href="unit-help.php">?</a></li>
		</ul>
	</header>
