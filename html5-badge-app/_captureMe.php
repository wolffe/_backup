<?php
$data = $_POST['data'];
$idnumber = $_POST['idnumber'];
$type = $_POST['type'];

$captureItem = $type.$idnumber;

/*
$sql = "INSERT INTO `dp_capture` (`captureID`, `captureItem`) VALUES (NULL, '$captureItem');";
mysql_query($sql);
*/

$message = '';
$message .= '<p style="font-size: 150%;">&raquo; <a href="http://getbutterfly.com/html5-badge-app/show.php?idnumber='.$idnumber.'&amp;type='.$type.'">Click here!</a> &laquo; to view your badge.</p>';

// HEADERS
$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";

// Additional headers
$headers .= 'To: Ciprian Popescu <getbutterfly@gmail.com>' . "\r\n";
$headers .= 'From: Ciprian Popescu <getbutterfly@gmail.com>' . "\r\n";

$headers .= 'Reply-To: getbutterfly@gmail.com'."\r\n";
$headers .='X-Mailer: PHP/'.phpversion();

mail('getbutterfly@gmail.com' , 'Badge App', $message, $headers);
?>
