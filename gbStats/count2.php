<?php


include("config.php");
$now = time();


$md = mktime(0,0,1,date("m"),date("d"),date("y"));


#######################################



### IF NO USER ID SUBMITTED WITH CODE PRINT INVALID AND EXIT
if(!is_numeric($u)) { echo "document.write('Invalid');"; exit; }

### CHECK SUBMITTED USER ID IN DATABASE
$c=mysql_query("select * from $userstable where id='$u' limit 1");
$d=mysql_fetch_object($c);

### IF USER DOES NOT EXIST PRINT INVALID AND EXIT
if(!$d->id) { echo "document.write('Invalid');"; exit; }

$pageloads = $d->pageloads;
$pmonth = $d->pageloads_month;

$frog = date("m",$now);
if ($frog != $pmonth) {
	mysql_query("update $userstable set pageloads_month='$frog',pageloads='0' where id='$u'"); }




### STRIP OUT INDEX PAGES AND WWW AND TRAILING SLASH FROM URL
$url1 = $url;
$url1 = str_replace("http://www.","",$url1);
$url1 = str_replace("http://","",$url1);
$striparray = array('/index.shtml','/index.html','/index.htm','/index.php3','/index.php');
foreach ($striparray as $i) $url1 = str_replace("$i","",$url1);
$url = "http://".$url1;
if ($url == "http://") $url = "Unknown URL";
$url = trim($url, "/");


### STRIP OUT INDEX PAGES AND WWW AND TRAILING SLASH FROM CLICKED LINK
$href1 = $href;
$href1 = str_replace("http://www.","",$href1);
$href1 = str_replace("http://","",$href1);
$striparray = array('/index.shtml','/index.html','/index.htm','/index.php3','/index.php');
foreach ($striparray as $i) $href1 = str_replace("$i","",$href1);
$href = "http://".$href1;
if ($href == "http://" && (!$hit)) $href = "Unknown URL";
if ($hit) $href = 0;
$href = trim($href, "/");



### STRIP OUT INDEX PAGES AND WWW AND TRAILING SLASH FROM REFERRING PAGE
### ALSO FIGURE OUT SEARCH ENGINE AND KEYWORDS IF THEY EXIST
$referer1 = $referer;
$referer1 = str_replace("http://www.","",$referer1);
$referer1 = str_replace("http://","",$referer1);
$striparray = array('/index.shtml','/index.html','/index.htm','/index.php3','/index.php');
foreach ($striparray as $i) $referer1 = str_replace("$i","",$referer1);
$referer = "http://".$referer1;
if ($referer == "http://") $referer = 0;
if ($referer) $keyeng = stripkeywords($referer);
if ($keyeng) {
	$temparray = split("\|",$keyeng);
	$engine = $temparray[0];
	$keywords = urldecode($temparray[1]); }
$referer = trim($referer, "/");






### DETERMINE IF THIS HIT IS AN ENTRANCE OR EXIT
if ($hit) {
	$tmpa1 = split("/",$url);
	$udomain = $tmpa1[2];
	$tmpa2 = split("/",$referer);
	$rdomain = $tmpa2[2];
	if ((!$referer) || ($rdomain != $udomain)) $ee = 1; }
if (!$hit) {
	$tmpa3 = split("/",$url);
	$udomain = $tmpa3[2];
	$tmpa4 = split("/",$href);
	$hdomain = $tmpa4[2];
	if (($hdomain && $udomain) && ($hdomain != $udomain)) $ee = 1; }





##### FIGURE OUT IF WE ARE TRACKING THIS CAMPAIGN BY TITLE OR URL,
##### AND FIGURE OUT IF CAMPAIGN ALREADY EXISTS OR NOT.
if ($title) {
	$c=mysql_query("select id,title,countdisplay from $pagestable where title='$title' and userid='$u' limit 1");
	$d=mysql_fetch_object($c);
	if ($d->title) {
		$camptitle = 1;
		$countdisplay = $d->countdisplay; 
		$campid = $d->id; } }
elseif ($url) {
	$c=mysql_query("select id,url,countdisplay from $pagestable where url='$url' and userid='$u' limit 1");
	$d=mysql_fetch_object($c);
	if ($d->url) {
		$campurl = 1;
		$countdisplay = $d->countdisplay; 
		$campid = $d->id; } }
if (!$campurl && !$camptitle) $campnew = 1;






##### IF THIS IS A NEW CAMPAIGN, INSERT IT INTO THE DATABASE
if ($campnew && $title) {
	mysql_query("insert into $pagestable (userid,title) values ('$u','$title')") or die(mysql_error());
	$c=mysql_query("select id,countdisplay,block from $pagestable where title='$title' and userid='$u' limit 1"); 
	$d=mysql_fetch_object($c);
	$block = $d->block;
	$campid = $d->id;
	$countdisplay = $d->countdisplay; }
elseif ($campnew && $url) {
	mysql_query("insert into $pagestable (userid,url) values ('$u','$url')");
	$c=mysql_query("select id,countdisplay,block from $pagestable where url='$url' and userid='$u' limit 1") or die(mysql_error()); 
	$d=mysql_fetch_object($c);
	$block = $d->block;
	$campid = $d->id;
	$countdisplay = $d->countdisplay; }














$m = mysql_query("select * from $statstableprefix"."_"."$u"."_old where time='$md' and pageid='$campid' limit 1");
$n = mysql_fetch_object($m);
if (!$n->id) $notfound = 1;

$old_clicks = $n->clicks;
$old_hits = $n->hits;
$old_visitors = $n->visitors;
$old_visits = $n->visits;
$old_rv = $n->rv;

if ($hit) {
	$old_hits++;
	$m = mysql_query("select ipaddress,time from $statstableprefix"."_"."$u where ipaddress='$ipaddress' order by time desc limit 1");
	$n = mysql_fetch_object($m);
	if (!$n->ipaddress) $old_visitors++;
	if (($n->ipaddress) && (($now - $n->time) >= $newvisitduration)) $old_rv++; }

if (!$hit) {
	$old_clicks++; }









##### CHECK TO MAKE SURE WE ARE SUPPOSED TO COUNT THIS IP ADDRESS
$blockarray = explode(",",$block);
foreach ($blockarray as $i) {
	trim($i);
	if ($ipaddress == $i) $blocked = 1; }
if ($blocked) exit;







##### IF THIS WAS A PAGELOAD, INSERT IT ALL INTO THE DATABASE
if ($hit) {
	mysql_query("insert into $statstableprefix"."_"."$u (hit,pageid,ipaddress,browser,operatingsystem,screenresolution,colordepth,countrylanguage,url,time,referer,keywords,engine,ee) values ('$hit','$campid','$ipaddress','$browser','$operatingsystem','$screenresolution','$colordepth','$countrylanguage','$url','".time()."','$referer','$keywords','$engine','$ee')") or die(mysql_error());

	##### UPDATE THE MONTHLY PAGELOADS AND COUNTER DISPLAY
	mysql_query("update $pagestable set countdisplay='".($countdisplay + 1)."',lastaccess='".time()."' where id='$campid'");
	mysql_query("update $userstable set pageloads='".($pageloads + 1)."' where id='$u'");

	##### UPDATE THE OVERALL TOTALS AND COUNTS
	if (!$notfound) mysql_query("update $statstableprefix"."_"."$u"."_old set visitors='$old_visitors',visits='$old_visits',clicks='$old_clicks',hits='$old_hits',rv='$old_rv' where time='$md' and pageid='$campid'");
	if ($notfound) mysql_query("insert into $statstableprefix"."_"."$u"."_old (time,pageid,visitors,visits,clicks,hits,rv) values ('$md','$campid','$old_visitors','$old_visits','$old_clicks','$old_hits','$old_rv')");

 }
echo '<script>alert("aaa");</script>';






##### IF THIS WAS A CLICK, INSERT IT ALL IN DATABASE
if (!$hit) {
	mysql_query("insert into $statstableprefix"."_"."$u (pageid,url,time,referer,href,ipaddress,ee) values ('$campid','$url','".time()."','$referer','$href','$ipaddress','$ee')") or die(mysql_error());

	##### UPDATE THE OVERALL COUNTS AND TOTALS
	if (!$notfound) mysql_query("update $statstableprefix"."_"."$u"."_old set clicks='$old_clicks' where time='$md' and pageid='$campid'");
	if ($notfound) mysql_query("insert into $statstableprefix"."_"."$u"."_old (time,pageid,visitors,visits,clicks,hits) values ('$md','$campid','0','0','$old_clicks','0')");

 }





##### UPDATE THE MAINSTATS TABLE FOR THE ADMINISTRATOR
$g = mysql_query("select * from $mainstatstable where id>='1' limit 1");
$h = mysql_fetch_object($g);
mysql_query("update $mainstatstable set actual_counts='".($h->actual_counts + 1)."' where id='$h->id'");
$k = mysql_query("select * from $statstableprefix"."_"."$u where ipaddress='$ipaddress' limit 1");
$j = mysql_fetch_object($k);
if (!$j->id) mysql_query("update $mainstatstable set actual_viewers='".($h->actual_viewers + 1)."' where id='$h->id'");







@mysql_close();

?>