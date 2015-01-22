<?php
include('config.php');

### IF NO USER ID SUBMITTED WITH CODE PRINT INVALID AND EXIT
if(!is_numeric($u)) { echo "document.write('Invalid');"; exit; }

### CHECK SUBMITTED USER ID IN DATABASE
$c=mysql_query("select * from $userstable where id='$u' limit 1");
$d=mysql_fetch_object($c);

### IF USER DOES NOT EXIST PRINT INVALID AND EXIT
if(!$d->id) { echo "document.write('Invalid');"; exit; }


$default_countertype = $d->countertype;

#######################################




##### FIGURE OUT INFO ABOUT THIS HIT

include "includes/useragent.php";
$browser = browser_detection("browser");
$bnum = browser_detection("number");
$biever = browser_detection("ie_version");
$bmozver = browser_detection("moz_version");
$operatingsystem = browser_detection("os");
$onum = browser_detection("os_number");

if ($bmozver[0]) $browser = "$bmozver[0] $bmozver[1]";
else $browser .= " $bnum";
$operatingsystem .= " $onum";


$browser = trim($browser);
$operatingsystem = trim($operatingsystem);

$operatingsystem = str_replace("win","Windows",$operatingsystem);
$operatingsystem = str_replace("nt","Windows NT",$operatingsystem);
$operatingsystem = str_replace("me","ME",$operatingsystem);
$operatingsystem = str_replace("xp","Windows XP",$operatingsystem);
$operatingsystem = str_replace("vist","Windows Vista",$operatingsystem);
$operatingsystem = str_replace("mac","Mac",$operatingsystem);
$operatingsystem = str_replace("lin","Linux",$operatingsystem);
$operatingsystem = str_replace("linux","Linux",$operatingsystem);
$operatingsystem = str_replace("NT 5.1","XP SP2",$operatingsystem);
$operatingsystem = str_replace("NT 5","XP",$operatingsystem);


$browser = str_replace("saf","Safari",$browser);
$browser = str_replace("op","Opera",$browser);
$browser = str_replace("omni","OmniWeb",$browser);
$browser = str_replace("ie","MSIE",$browser);
$browser = str_replace("konq","Konqueror",$browser);
$browser = str_replace("moz","Gecko/Moz",$browser);
$browser = str_replace("netp","NetPositive",$browser);
$browser = str_replace("lynx","Lynx",$browser);
$browser = str_replace("webtv","WebTV",$browser);
$browser = str_replace("firefox","FireFox",$browser);
$browser = str_replace("netscape","Netscape",$browser);



$ipaddress = $_SERVER['REMOTE_ADDR'];
$countrylanguage = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
$temparray = explode(",",$countrylanguage);
$countrylanguage = $temparray[0];
unset($temparray);

if (!$t) $t = "0";
if (!isset($url)) $url = $_SERVER['HTTP_REFERER'];
$title = $t;


$javascript = '';
$javascript .= "
	var ipaddress = '$ipaddress';
	var browser = '$browser';
	var operatingsystem = '$operatingsystem';
	var countrylanguage = '$countrylanguage';
	var referer = escape(document.referrer);
	var screenresolution = screen.width+'x'+screen.height;
	var colordepth = screen.colorDepth;
	var url = location.href;

	init_counter();

	function init_counter() {
		var clickscript = new Image();
		clickscript.src = '$siteurl/count2.php?hit=1&u=$u&title=$t&ipaddress='+ ipaddress +'&browser='+ browser +'&operatingsystem='+ operatingsystem +'&countrylanguage='+ countrylanguage +'&screenresolution='+ screenresolution +'&colordepth='+ colordepth +'&referer='+ referer +'&url='+ url;
		startclicklog(); }


	function startclicklog() {
		if (typeof document.onmousedown == 'function') {
			currentFunc = document.onmousedown;
			document.onmousedown = function(e) { 
				catchactivity(e); return currentFunc(e); } }
		else { document.onmousedown = catchactivity; } }


	function findlink(el) {
		var tagName = 'A';
		var parent = el.parentNode;
		if (el.tagName != 'IMG') var df = el.href;
		if (!df&&parent) {
			if (parent.tagName==tagName) return parent.href;
			else return findlink(parent); }
		else return df; }


	function catchactivity(e) {
		try {
			if (e == undefined) e = window.event;
			if (e.srcElement) href = findlink(e.srcElement);
			else href = findlink(e.target);
			if (href)
				var clickscript = new Image();
				clickscript.src = '$siteurl/count2.php?hit=0&u=$u&title=$t&ipaddress='+ ipaddress +'&url='+ url +'&href='+ href;
				var href = ''; }
		catch(e) { }
		return true; }
\n";




echo "$javascript";

















### STRIP OUT INDEX PAGES AND WWW FROM URL
$url1 = $url;
$url1 = str_replace("http://www.","",$url1);
$url1 = str_replace("http://","",$url1);
$striparray = array('/index.shtml','/index.html','/index.htm','/index.php3','/index.php');
foreach ($striparray as $i) $url1 = str_replace("$i","",$url1);
$url = "http://".$url1;
if ($url == "http://" && $hit) $url = "Unknown URL";

#######################################

if ($title) {
	$c=mysql_query("select countdisplay,countertype from $pagestable where title='$title' and userid='$u' limit 1");
	$d=mysql_fetch_object($c);
	if ($d->countdisplay) {
		$countertype = $d->countertype; 
		$countdisplay = $d->countdisplay; } }

elseif ($url) {
	$c=mysql_query("select countdisplay,countertype from $pagestable where url='$url' and userid='$u' limit 1");
	$d=mysql_fetch_object($c);
	if ($d->countdisplay) {
		$countertype = $d->countertype; 
		if ($d->displaytype == "h") $countdisplay = $d->countdisplay;
		if ($d->displaytype != "h") $countdisplay = $d->visitordisplay; } }


//if (!$countertype) $countertype = "inv";
$countertype = "inv";

if ($countertype == "inv") { }











@mysql_close();

?>