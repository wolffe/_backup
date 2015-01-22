<?php


require("config.php");
$titlex = "$logintitle";
$now = time();
$xyz = $now - $onlineduration;





##### CHECK FOR A VALID ADMIN LOGIN COOKIE TO SEE IF THIS
##### PERSON IS LOGGED IN AS ADMINISTRATOR
if ($HTTP_COOKIE_VARS['adminp'] == "$adminpass" && $HTTP_COOKIE_VARS['adminu'] == "$adminuser") $adminlogged = 1;



##### CHECK FOR A VALID LOGIN COOKIE OR SUBMITTED VARIABLES OR A LOGOUT
require "includes/checklogin.php";



##### IF PROPERLY LOGGED, WE CONTINUE ON...




##### SET SOME USER BASED VARIABLES FROM OUR MYSQL
##### QUERY IN checklogin.php
$id = $d->id;
$dafuser = $d->username;
$lastpay = $d->lastpay;
$paytype = $d->paytype;
$total_pageloads = $d->pageloads;









##### FIGURE OUT WHAT TYPE OF PAID OR FREE USER
##### WE ARE DEALING WITH HERE
if (!$lastpay) $freemember = 1;
else $paidmember = $paytype;

if ($paytype == "1") {
	$paid_pageload_limit = $paid_pageload_limit3;
	$paid_record_limit = $paid_record_limit1; }
elseif ($paytype == "2") {
	$paid_pageload_limit = $paid_pageload_limit3;
	$paid_record_limit = $paid_record_limit2; }
elseif ($paytype == "3") {
	$paid_pageload_limit = $paid_pageload_limit3;
	$paid_record_limit = $paid_record_limit3; }


if ($freemember) {
	$limitmessage = "$free_record_limit Detailed Records";
	$limitmessage2 = "$free_pageload_limit Pageloads per Month";
	$pageload_limit = $free_pageload_limit;
	$record_limit = $free_record_limit; }
elseif ($paidmember) {
	$limitmessage = "$paid_record_limit Detailed Records (Level $paytype)";
	$limitmessage2 = "$paid_pageload_limit Pageloads per Month (Level $paytype)"; 
	$pageload_limit = $paid_pageload_limit;
	$record_limit = $paid_record_limit; }





##### DELETE DATABASE RECORDS ABOVE AND BEYOND THIS USERS LIMIT
$r = mysql_query("select * from $statstableprefix"."_".$id." where id>='1' order by time desc");
while ($s = mysql_fetch_object($r)) {
	$countinglimit++;
	if ($countinglimit > $record_limit) {
		mysql_query("delete from $statstableprefix"."_".$id." where id='$s->id' limit 1"); } }



##### IF THERE IS A VALUE FOR $camp OR $page OR $domain, FIGURE OUT THE TOTAL
##### NUMBER OF RECORDS IN THE DATABASE
if ($camp || $page || $domain) {
	$m = mysql_query("select id from $statstableprefix"."_".$id." where id>='1'");
	$tot_recs = mysql_num_rows($m); }





##### GRAB ALL THE CAMPAIGNS THIS USER HAS
$e = mysql_query("select * from $pagestable where userid='$id'");
while ($f = mysql_fetch_object($e)) {
	if ($f->title) {
		$options .= "<option value=\"$f->id\""; 
		if ($camp == $f->id) $options .= " selected";
		$options .= ">$f->title</option>\n";
		$pages_array[$f->id] = $f->title; }
	elseif ($f->url) { 
		$options .= "<option value=\"$f->id\""; 
		if ($camp == $f->id) $options .= " selected"; 
		$options .= ">$f->url</option>\n";
		$pages_array[$f->id] = "$f->url"; } }




##### GRAB ALL THE PAGE URLs AND DOMAINS THIS USER HAS
$e = mysql_query("select pageid,url from $statstableprefix"."_".$id."");
while ($f = mysql_fetch_object($e)) {
	$split = split("/",$f->url);
	$tdomain = $split[2];
	$alldomains[$tdomain] = 1;
	$allpages[$f->url] = $f->pageid; }

if ($allpages) {
	foreach ($allpages as $key=>$value) {
		$options2 .= "<option value=\"$key\""; 
		if ($page == $key) $options2 .= " selected"; 
		$options2 .= ">$key</option>\n"; } }
if ($alldomains) {
	foreach ($alldomains as $key=>$value) {
		$options3 .= "<option value=\"$key\""; 
		if ($domain == $key) $options3 .= " selected"; 
		$options3 .= ">$key</option>\n"; } }




##### FIGURE OUT OUR CAMPAIGN AND TIME FILTERING OPTIONS

if ($datestring) {
	$parts = explode(",",$datestring);
	$fmonth = $parts[0];
	$fday = $parts[1];
	$fyear = $parts[2];
	$tmonth = $parts[3];
	$tday = $parts[4];
	$tyear = $parts[5]; }

if ($camp) {
	$filter = "and pageid='$camp'";
	$filtershow = "Campaign ".$pages_array[$camp].""; }
elseif ($domain) {
	$filter = "and url like '%$domain%'";
	$filtershow = "Domain $domain"; }
elseif ($page) {
	$filter = "and url='$page'";
	$filtershow = "Page $page"; }
else $filtershow = "All Campaigns, Domains, and Pages";

if ($fday&&$fmonth&&$fyear&&$tday&&$tmonth&&$tyear) {
	$filterdatetrue = 1;
	$from = mktime(0,0,1,$fmonth,$fday,$fyear);
	$to = mktime(23,59,59,$tmonth,$tday,$tyear);
	$filter2 = "and time>='$from' and time<='$to'";
	$filtershow2 = "$fmonth/$fday/$fyear - $tmonth/$tday/$tyear";
	$datestring = "$fmonth,$fday,$fyear,$tmonth,$tday,$tyear"; }
else $filtershow2 = "All Dates";

















##### START THE PAGE
include "templates/layout_top.php";






##### IF THERE IS A VALUE FOR $stat, THIS IS AN INDIVIDUAL STAT REPORT NOT THE. 
##### SET SOME VARS AND INCLUDE THE APPROPRIATE STATS FILE THAT
##### WILL PRINT THE REPORT, THEN WE EXIT.
if ($stat) {
	if ($stat == "ipaddress") { include "stats/ipaddress.php"; }
	if ($stat == "online") { include "stats/online.php"; }
	if ($stat == "keywords") { include "stats/keywords.php"; }
	if ($stat == "engine") { include "stats/engine.php"; }
	if ($stat == "colordepth") { include "stats/colordepth.php"; }
	if ($stat == "screenresolution") { include "stats/screenresolution.php"; }
	if ($stat == "operatingsystem") { include "stats/operatingsystem.php"; }
	if ($stat == "browser") { include "stats/browser.php"; }
	if ($stat == "countrylanguage") { include "stats/countrylanguage.php"; }

	if ($stat == "referer") { include "stats/referer.php"; }
	if ($stat == "href") { include "stats/href.php"; }
	if ($stat == "url") { include "stats/url.php"; }

	if ($stat == "entry") { include "stats/entry.php"; }
	if ($stat == "exit") { include "stats/exit.php"; }

	if ($stat == "campaigns") { include "stats/campaign.php"; }
	if ($stat == "domains") { include "stats/domains.php"; }
	if ($stat == "ip") { include "stats/ip.php"; }
	if ($stat == "all") { include "stats/all.php"; }
	if ($stat == "log") { include "stats/log.php"; }

	include "templates/layout_bottom.php";
	exit; }






##### IF THERE IS A VALUE FOR $records
##### THIS IS A CALL TO DISPLAY ALL DATABASE RECORDS,
##### INCLUDE THE APPROPRIATE STAT FILE AND THEN EXIT.
if ($records1) { 
	include "stats/records1.php";
	include "templates/layout_bottom.php";
	exit; }
if ($records2) { 
	include "stats/records2.php";
	include "templates/layout_bottom.php";
	exit; }










##### IF WE ARE STILL RUNNING THE SCRIPT AT THIS POINT AND HAVE NOT
##### EXITED, WE ARE PRINTING A DATABASE USAGE REPORT



##### GRAB ALL THE CLICKS AND HITS FROM THE DATABSE FOR THIS USER
##### AND ASSIGN THE INFORMATION TO AN ARRAY OF ARRAYS THAT WE WILL USE
##### TO DISPLAY THE DATABASE USAGE

$c = mysql_query("select * from $statstableprefix"."_".$d->id." where id>='1' $filter $filter2 order by time asc");
while ($d = mysql_fetch_object($c)) {
	$total_records++;
	if ($d->hit) $total_hits++;
	if (!$d->hit) $total_clicks++; }










##### IF THIS IS A DATABASE REPORT FOR AN INDIVIDUAL CAMPAIGN,
##### FIGURE OUT SOME PERCENTAGES OF DATABASE USED
if ($tot_recs && $filter) {
	$percent = round((($total_records / $tot_recs) * 100), 2);
	if ($freemember) $percent2 = round((($total_records / $free_record_limit) * 100), 2);
	if ($paidmember) $percent2 = round((($total_records / $paid_record_limit) * 100), 2);
	$limitmessage = "$percent% of used records - $percent2% of total records."; }




##### START THE SCRIPT OUTPUT WITH THE PAGE HEADER
echo "<font class=stats_header>Database Usage</font><br><font class=stats_subheader>$filtershow<br>$filtershow2</font><p>";




##### IF NO RECORDS WERE FOUND, PRINT WELCOME MESSAGE AND JUST EXIT HERE.
if (!$total_records) {
	echo "<p>No Records Found!<p>";
	include "templates/layout_bottom.php";
	exit; }





















##### LETS DISPLAY THE DATABASE USAGE, FILTER FORM FIRST

echo "<hr><p>";






##### DISPLAY THE DATABASE USAGE GRAPH IF WE ARE VIEWING THE
##### DATABASE USAGE FOR ALL OUR CAMPAIGNS
if (!$filter) {
	$graph_data1 = "$total_records,0,0,0,0,0";
	$graph_data2 = "0,$record_limit,0,0,0,0";
	$graph_data3 = "0,0,$free_record_limit,0,0,0";
	$graph_data4 = "0,0,0,$paid_record_limit1,0,0";
	$graph_data5 = "0,0,0,0,$paid_record_limit2,0";
	$graph_data6 = "0,0,0,0,0,$paid_record_limit3";
	$graph_label1 = " 1. Your Records";
	$graph_label2 = " 2. Your Limit";
	$graph_label3 = " 3. Free Limit";
	$graph_label4 = " 4. Paid Limit 1";
	$graph_label5 = " 5. Paid Limit 2";
	$graph_label6 = " 6. Paid Limit 3";
	$graph_legends = "1,2,3,4,5,6";
	$yaxis = "Detailed Records";
	if ($total_records > ($record_limit*.80)) { 
		$alert = 1; 
		$showalert1 .= "<br><font class=error_font>You are near or at your limit!<br><a href=edit.php?m=ad title=\"Upgrade Account!\">Click here to Upgrade!</a></font>"; }
	echo "<img src=\"graph1b.php?jptitle=Detailed Records Usage in Number of Records&jplegends=$graph_legends&jpdata1=$graph_data1&jpdata2=$graph_data2&jpdata3=$graph_data3&jpdata4=$graph_data4&jpdata5=$graph_data5&jpdata6=$graph_data6&jpl1=$graph_label1&jpl2=$graph_label2&jpl3=$graph_label3&jpl4=$graph_label4&jpl5=$graph_label5&jpl6=$graph_label6&yaxis=$yaxis&alert=$alert\"><p>";

	$alert = 0;
	$graph_data1 = "$total_pageloads,0,0,0,0,0";
	$graph_data2 = "0,$pageload_limit,0,0,0,0";
	$graph_data3 = "0,0,$free_pageload_limit,0,0,0";
	$graph_data4 = "0,0,0,$paid_pageload_limit1,0,0";
	$graph_data5 = "0,0,0,0,$paid_pageload_limit2,0";
	$graph_data6 = "0,0,0,0,0,$paid_pageload_limit3";
	$graph_label1 = " 1. Your Pageloads";
	$graph_label2 = " 2. Your Limit";
	$graph_label3 = " 3. Free Limit";
	$graph_label4 = " 4. Paid Limit 1";
	$graph_label5 = " 5. Paid Limit 2";
	$graph_label6 = " 6. Paid Limit 3";
	$graph_legends = "1,2,3,4,5,6";
	$yaxis = "Pageloads";
	if ($total_pageloads > ($pageload_limit*.80)) { 
		$alert = 1; 
		$showalert2 .= "<br><font class=error_font>You are near or at your limit!<br><a href=edit.php?m=ad title=\"Upgrade Account!\">Click here to Upgrade!</a></font>"; }
	echo "<img src=\"graph1b.php?jptitle=Pageloads This Month&jplegends=$graph_legends&jpdata1=$graph_data1&jpdata2=$graph_data2&jpdata3=$graph_data3&jpdata4=$graph_data4&jpdata5=$graph_data5&jpdata6=$graph_data6&jpl1=$graph_label1&jpl2=$graph_label2&jpl3=$graph_label3&jpl4=$graph_label4&jpl5=$graph_label5&jpl6=$graph_label6&yaxis=$yaxis&alert=$alert\"><br><br>"; }












echo "<hr>";

##### SET EMPTY VALUES TO '0' ZERO SO THAT IT SHOWS INSTEAD OF A BLANK SPACE
if (!$total_records) $total_records = "0";
if (!$total_hits) $total_hits = "0";
if (!$total_clicks) $total_clicks = "0";
if (!$total_pageloads) $total_pageloads = "0";



echo "<br>
<table cellpadding=0 cellspacing=0 border=0 class=showstats>
	<tr>
		<td class=showstats_header valign=top>Total Detailed Records:</td><td class=showstats>$total_records Detailed Records $showalert1</td>
	</tr>
	<tr>
		<td class=showstats_header>Detailed Record Limit:</td><td class=showstats>$limitmessage</td></tr>
\n\n";


if (!$filter) echo "<tr><td class=showstats_header valign=top>This Month's Pageloads:</td><td class=showstats>$total_pageloads Pageloads $showalert2</td></tr>";
if (!$filter) echo "<tr><td class=showstats_header>Monthly Pageload Limit:</td><td class=showstats>$limitmessage2</td></tr>";


echo "<tr>
	<td class=showstats_header>Total Pageload Records:</td><td class=showstats>$total_hits Records</td>
	</tr>
	<tr>
		<td class=showstats_header>Total Click Records:</td><td class=showstats>$total_clicks Records</td>
	</tr>
</table><p>
\n\n";







include("templates/layout_bottom.php");

?>