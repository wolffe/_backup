<?php


### THIS PAGE ALLOWS MEMBERS TO EDIT THEIR ACCOUNT SETTINGS.
### IT ALSO ALLOWS THE ADMIN TO EDIT MEMBERS SETTINGS.
### THERE IS NO NEED TO EDIT THIS SCRIPT.


require("config.php");


$titlex = "$edittitle";
$returntostats = "<a href=members.php>Return to Your Stats</a>";


##### CHECK FOR A VALID LOGIN COOKIE OR SUBMITTED VARIABLES OR A LOGOUT
require "includes/checklogin.php";


$id = $d->id;
$dafuser = $d->username;
include "templates/layout_top.php"; 


 if ($username == "demo" && !$adminlogged) {
	echo "Sorry! Demo Account Editing Features are Disabled!<br>Only the site administrator has access to these features.<p>Please choose one of the links under 'Stat Reports' to see the stats!";
	include "templates/layout_bottom.php"; 
	exit; }



##### USER CHANGE PASSWORD
if($m=="cp") {
	echo "<font class=stats_header>Change Your Password</font><p>";
	$p1=$password1;
        $p2=$password2;
        $p3=$change;
        if(($p1==$p2) && $p3) {
          mysql_query("update $userstable set password='$p1' where id='$id'");
          echo "Your password has been changed. You will need to login again with your new password <a href=logout.php>here</a>."; }
        else {
          echo "
Enter in below what you wish to change your password to. Do it twice and then click 'Change'. If your passwords do not match, you will be brought back to this page.
<p>
<form method=post>
<table>
	<tr>
		<td>1: <input class=textinput type=password name=password1 maxlength=30><p>2: <input class=textinput type=password name=password2 maxlength=30><p>3: <input class=button type=submit name=change value=\"Change Pass\">".$admininput."</td>
	</tr>
</table>
<p>
$returntostats
\n\n"; } }





##### USER DELETE ACCOUNT
      elseif($m=="da") {
  echo "<font class=stats_header>Delete Your Account</font><p>";
        $p1=$delete_account;
        if($p1=="Yes") {
          mysql_query("delete from $userstable where id='$id'");
          mysql_query("delete from $pagestable where userid='$id'");
          mysql_query("drop table ".$statstableprefix."_$id");
          mysql_query("drop table ".$statstableprefix."_$id"."_old");
		$w=mysql_query("select * from $mainstatstable where id>='1' limit 1");
		$u=mysql_fetch_object($w);
		mysql_query("update $mainstatstable set members_deleted='".($u->members_deleted+1)."' where id='$u->id'");
          echo "Your account has been deleted at your request.<p><a href=index.php>Home</a>"; }
        elseif($p1=="No")  {
          echo "Good Choice. You didn't really want to delete your account. You want to stay here with us for a while.<p>$returntostats"; }
        else {
          echo "Are you really sure you want to delete your account?<p><form method=post><input class=button type=submit name=delete_account value=Yes> <input class=button type=submit name=delete_account value=No></form><p>$returntostats"; } }







##### USER ACCOUNT DETAILS / UPGRADE ACCOUNT
      elseif($m=="ad") {
  echo "<font class=stats_header>Account Details</font><p><table width=80%><tr><td>

You Signed Up On:
".date("m-d-Y",$d->signup)."<p>

Your Premium Membership Level:
$d->paytype<p>

Your Last Payment: ";

if ($d->lastpay && ($d->lastpay != "Free")) echo "".date("m-d-Y",$d->lastpay);
else echo "Free Account";

echo "</table>";



if ($d->paytype == "3") {
	echo "<p><hr><p><font class=stats_subheader>You are currently at the highest premium level.</font><p>";
	if ($d->lastpay != "Free") echo "To cancel your subscription, log into your PayPal account to do so.<p>If you would like to downgrade your premium membership level, you must cancel your subscription, then come back to this page and signup for the level you would like.<p>";
	else echo "You are a paid status for free member, enjoy.<p>"; }


if ($d->paytype != "3") {
	echo "<p><hr><p><font class=stats_subheader>Upgrade Your Account!</font><p>"; }


if ($d->paytype < "3") {
	$paypal_price = $paypal_price3;
	$paypal_itemx = $paypal_item." Level 3";
	$paypal_itemz = 3;
	include "includes/paypal_button.php";
	echo "<p>Premium Membership Level 3<br>$paid_record_limit3 Detailed Database Records<br>$paid_pageload_limit3 Monthly Pageloads<br>\$$paypal_price3 a Month!<p><hr><p>"; }


if ($d->paytype < "2") {
	$paypal_price = $paypal_price2;
	$paypal_itemx = $paypal_item." Level 2";
	$paypal_itemz = 2;
	include "includes/paypal_button.php";
	echo "<p>Premium Membership Level 2<br>$paid_record_limit2 Detailed Database Records<br>$paid_pageload_limit2 Monthly Pageloads<br>\$$paypal_price2 a Month!<p><hr><p>"; }



if ($d->paytype < "1") {
	$paypal_price = $paypal_price1;
	$paypal_itemx = $paypal_item." Level 1";
	$paypal_itemz = 1;
	include "includes/paypal_button.php";
	echo "<p>Premium Membership Level 1<br>$paid_record_limit1 Detailed Database Records<br>$paid_pageload_limit1 Monthly Pageloads<br>\$$paypal_price1 a Month!<p><hr><p>"; }



 }








##### EDIT A CAMPAIGN
elseif($m=="ec") {
	echo "<font class=stats_header>Edit a Campaign</font><p><hr><p>";
	if($save) { 
if (!$title) echo "No title submitted! Go back and try again.";
else {
    mysql_query("update $pagestable set title='$title',countdisplay='$countdisplay',block='$block',displaytype='$displaytype',countertype='$countertypeqqq' where id='$editid'");


		echo "Your campaign has been saved.<br>"; } }

	else {

	$m = mysql_query("select * from $pagestable where userid='$id' and id='$editid' limit 1");
	$n = mysql_fetch_object($m);

		$noshowsettings = 1;
		echo "Change the following and click 'Save' at the bottom.<p><form method=post name=ss><input type=hidden name=save value=yes><input type=hidden name=editid value=$n->id>";
		include "includes/settings2.php";
		echo "<p>"; } }




##### DELETE A CAMPAIGN
elseif($m=="dc") {
	echo "<font class=stats_header>Delete A Campaign</font><p><hr><p>";
	if($save) { 

    mysql_query("delete from $pagestable where id='$delid'");
    mysql_query("delete from ".$statstableprefix."_$id where pageid='$delid'");


		echo "Your campaign has been deleted.<br>"; }

	else {

echo "Are you sure you want to delete this campaign?<p><a href=?m=dc&save=1&delid=$delid>Yes<?a> <a href=members.php>No</a>";
		echo "<p>"; } }











##### CREATE A CAMPAIGN
elseif($m=="cc") {




##### CREATE A CAMPAIGN METHOD 1
if($mm=="1") {
	include "includes/sitecode1.php";
	echo "<font class=stats_header>Create a Campaign Method 1</font><p>Place the following code onto as many pages as you like, campaigns will automatically be created based on page URL.<p><textarea class=textarea rows=6 cols=50>$sitecode</textarea><p><br>"; }



##### CREATE A CAMPAIGN METHOD 2
if($mm=="2") {
	include "includes/sitecode2.php";
	echo "<font class=stats_header>Create a Campaign Method 2</font><p>Place the following code onto as many pages as you like, campaigns will automatically be created based on the text string 'My Home Page' you see in the code below. Change this string to whatever you like to create a new campaign, just make sure you only use A-Z, a-z, 0-9, underscores (_), and hyphens (-). Everything else will be stripped away automatically.<p><textarea class=textarea rows=6 cols=50>$sitecode</textarea><p><br>"; }





##### CREATE A CAMPAIGN METHOD 3
if($mm=="3") {
	echo "<font class=stats_header>Create a Campaign Method 3</font><p><hr><p>";
	if($save) { 
if (!$title) echo "No title submitted! Go back and try again.";
else {
	include "includes/sitecode3.php";

if ($countertype == "31") $countertype = "inv";
if ($countertype == "32") $countertype = "txt";
if ($countertype == "33") $countertype = "log";


	if ($displaytype == "v") { $visitordisplay = $countdisplay; $countdisplay = 0; }

    mysql_query("insert into $pagestable (userid,title,countdisplay,block,visitordisplay,displaytype,countertype) values ('$id','$title','$countdisplay','$block','$visitordisplay','$displaytype','$countertype')");


		echo "Your campaign has been created. Place the following code onto as many pages as you would like tracked through this campaign.<p><textarea class=textarea rows=6 cols=50>$sitecode</textarea><p><br>"; } }

	else {
		echo 'Fill out the following form to create a new campaign<br>and generate a webpage code specific to this campaign.<p><form method=post name=ss><input type=hidden name=save value=yes>';
		include "includes/settings2.php";
		echo "<p>"; } }





##### GET WEBPAGE CODE
if($camp) {
	$e = mysql_query("select id,title,url from $pagestable where id='$camp' and userid='$id'");
	$f = mysql_fetch_object($e);

	if (!$f->title) $f->title = "";
	if (!$f->url) $f->url = "";

	include "includes/sitecode4.php";

	if ($f->title) {
	echo "<font class=stats_header>Webpage Code for Campaign</font><br><font class=stats_subheader>$f->title"."$f->url</font><p>Place the following code onto the pages you would like tracked under this campaign.<p><textarea class=textarea rows=6 cols=50>$sitecode</textarea><p><br>"; }

	if ($f->url) {
	echo "<font class=stats_header>Webpage Code for Campaign</font><br><font class=stats_subheader>$f->title"."$f->url</font><p>This campaign is being tracked by page URL. The basic webpage javascript code is used to track pages by URL, shown below is this code. Placing this code onto this page will add stats to this campaign. <p>If you would like to track this page under a different campaign, such as a campaign with a text title rather than a URL for a title, <a href=edit.php?m=cc&mm=2>click here</a> to create a new campaign or find the existing campaign on <a href=members.php?stat=campaigns title=\"Existing Campaigns\">this page</a> and click the 'Javascript' link to get the webpage javascript code for that campaign.<p><textarea class=textarea rows=6 cols=50>$sitecode</textarea><p><br>"; }

 }









	if (!$camp && ($mm!="3")) echo "<font class=stats_header>Create a Campaign</font><p>There are 3 ways to create a campaign to track stats.<p><hr><p>
<a href=?m=cc&mm=1><font class=stats_subheader>Method 1</font></a><p>Produces a universal website javascript code that will automatically create a campaign based on the URL of the page you place the code on. The code can be inserted into as many pages as you like with no need to modify anything. Ideal for use with dynamic pages, where you can place the code into a template or footer type of file for inclusion into multiple pages at once.<p><a href=?m=cc&mm=1>Click here to try Method 1</a><p><hr><p>
<a href=?m=cc&mm=2><font class=stats_subheader>Method 2</font></a><p>Produces a website javascript code with a text string in it, representing the campaign title. Campaigns will be automatically created based on this title when you place the code onto a webpage. By tracking a campaign by a title rather than URL, you can track multiple pages and URLs under one campaign. Ideal for people who do not want to come back to this site to create a new campaign for every page they want to track and do not want to use method 1.<p><a href=?m=cc&mm=2>Click here to try Method 2</a><p><hr><p>
<a href=?m=cc&mm=3><font class=stats_subheader>Method 3</font></a><p>A step by step wizard to create a new campaign now and generate a webpage javascript code specific to that campaign. Recommended for beginners.<p><a href=?m=cc&mm=3>Click here to try Method 3</a><p><hr><p>"; 












}















##### OTHERWISE EDIT MAIN SETTINGS
      else {
  echo "<font class=stats_header>Change Your Settings</font><p>Change the following and then click the 'Save' button at the bottom of the page.<p><hr><p>";
        $p1=$modify;
        if($p1=="yes") { 
          if(eregi("^[https?://.+\..+]{1,255}",$url) && eregi("[.+\@.+\..+]{1,255}",$email) && ($country) && ($category) && ($title)) {
            mysql_query("update $userstable set countertype='$countertype',email='$email',url='$url',showsite='$showsite',country='$country',category='$category',title='$title',first_name='$first_name',last_name='$last_name',address1='$address1',address2='$address2',city='$city',state='$state',zip='$zip' where id='$id'");
            echo "Your changes have been saved.<p>$returntostats"; }
          else {
            echo "<font class=error_font>You have entered either an invalid email address, URL, or counter value, or you left title, country, and category empty. Use your browsers 'Back' button to go back and try again.</font><p>$returntostats"; } }


        else {
          $c=mysql_query("select * from $userstable where id='$id'");
          $d=mysql_fetch_object($c);
          if(is_object($d)) {

$email = $d->email;
$showsite = $d->showsite;
$hits = $d->hits;
$countertype = $d->countertype;
$country = $d->country;
$category = $d->category;
$url = $d->url;
$title = $d->title;
$first_name = $d->first_name;
$last_name = $d->last_name;
$address1 = $d->address1;
$address2 = $d->address2;
$city = $d->city;
$state = $d->state;
$zip = $d->zip;

  if($showsite != 0 && $showsite != "") $showsite_checked = " checked";
  if($d->countertype=="1") $p1=" selected";
  elseif($d->countertype=="2") $p2=" selected";
  elseif($d->countertype=="3") $p3=" selected";
  elseif($d->countertype=="4") $p4=" selected";
  elseif($d->countertype=="5") $p5=" selected";
  elseif($d->countertype=="6") $p6=" selected";
  elseif($d->countertype=="7") $p7=" selected";
  elseif($d->countertype=="8") $p8=" selected";
  elseif($d->countertype=="9") $p9=" selected";
  elseif($d->countertype=="10") $p10=" selected";
  elseif($d->countertype=="11") $p11=" selected";
  elseif($d->countertype=="12") $p12=" selected";
  elseif($d->countertype=="13") $p13=" selected";
  elseif($d->countertype=="14") $p14=" selected";
  elseif($d->countertype=="15") $p15=" selected";
  elseif($d->countertype=="16") $p16=" selected";
  elseif($d->countertype=="17") $p17=" selected";
  elseif($d->countertype=="18") $p18=" selected";
  elseif($d->countertype=="19") $p19=" selected";
  elseif($d->countertype=="20") $p20=" selected";
  elseif($d->countertype=="21") $p21=" selected";
  elseif($d->countertype=="22") $p22=" selected";
  elseif($d->countertype=="23") $p23=" selected";
  elseif($d->countertype=="24") $p24=" selected";
  elseif($d->countertype=="25") $p25=" selected";
  elseif($d->countertype=="26") $p26=" selected";
  elseif($d->countertype=="27") $p27=" selected";
  elseif($d->countertype=="28") $p28=" selected";
  elseif($d->countertype=="29") $p29=" selected";
  elseif($d->countertype=="30") $p30=" selected";
  elseif($d->countertype=="31") $p31=" selected";
  elseif($d->countertype=="32") $p32=" selected";
  elseif($d->countertype=="33") $p33=" selected";
  else $p1=" selected";

          echo '<form method=post name=ss><input type=hidden name=modify value=yes>'.$admininput.'';
          $noshowsettings = 1;
          include "includes/settings.php";
          echo "<p>$returntostats"; } } }









include("templates/layout_bottom.php");
@mysql_close();




?>