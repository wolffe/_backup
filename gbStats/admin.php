<?php


include("config.php");



##### CHECK FOR A VALID ADMIN LOGIN COOKIE OR SUBMITTED VARIABLES OR A LOGOUT
if ($p == "logout") {
  $logged = 0;
  setcookie("adminp",0);
  setcookie("adminu",0); }
elseif ($password == $adminpass && $username == $adminuser) {
  $logged = 1;
  $adminlogged = 1;
  setcookie("adminp",$adminpass);
  setcookie("adminu",$adminuser); }
elseif ($HTTP_COOKIE_VARS['adminp'] == "$adminpass" && $HTTP_COOKIE_VARS['adminu'] == "$adminuser") {
  $logged = 1;
  $adminlogged = 1;
  setcookie("adminp",$adminpass);
  setcookie("adminu",$adminuser); }
else {
  $logged = 0;
  setcookie("adminp",0);
  setcookie("adminu",0); }




$noshowtable = 1;
include "templates/layout_top.php";




if($logged) {






######################################################################################

if ($t=="") {
	echo "<font class=stats_header>Counter Administration</font><p>";
	echo "Please select an admin function from the links on the left.";

}

######################################################################################

elseif($t=="set") {

	if (!$save) {
		echo "<font class=stats_header>Administration Site Settings</font><p>Change anything below you would like to change, and then click the 'Save' button at the bottom of the page.<p>Even more advanced settings can be changed by editing the variables in the config.php file, or any of the templates in the /templates directory (including emails sent by the script and html and more). There is no way to edit config.php or the templates from this admin control panel.<p><br><form method=post>
<input type=hidden name=t value=$t><table class=admin cellpadding=0 cellspacing=0 border=0>";
	include "includes/sets.php";
	echo "</table><input type=submit name=save value=\"Save This!\" class=button></form>"; }


elseif ($save) {
	echo "<font class=stats_header>Administration Site Settings</font><p>Your changes have been saved.<p><br>";

	$final = "<?php\n\n";
	$final .= "
### THIS FILE IS EASIEST EDITED THROUGH THE ADMIN CONTROL PANEL,
### JUST CLICK THE LINK 'SITE SETTINGS' FROM THE SIDEBAR ON THE LEFT.\n\n";


	foreach ($HTTP_POST_VARS as $key=>$value) {
		$value = str_replace("\"","",$value);
		if (($key != "save") && ($key != "t")) $final .= "\$$key = \"$value\";\n"; }

	$final .= "?>";

	$file = fopen("config2.php", "w+");
	fputs($file,"$final");
	fclose($file); }





}

################################################################################

elseif($t=="e") {


	echo "<font class=stats_header>Email Your Members</font><p>Here you can email all of the members at once in mass.<p><br>";


	if($from&&$subject&&$body) {
	$c=mysql_query("select email from $userstable $userstable");
	while($d=mysql_fetch_object($c)) {
	mail("$d->email",stripslashes($subject),stripslashes($body),"From: <$from>");
	print "\n$d->email sent<br>";
	sleep($sleep); } }
    else {
      echo "
		<form method=post><input type=hidden name=p value='$p'>
		<table class=email_table>
			<tr>
				<td class=email_table_td>From:</td>
				<td class=email_table_td><input type=text name=from class=textinput></td>
			</tr>
			<tr>
				<td class=email_table_td>Subject:</td>
				<td class=email_table_td><input type=text name=subject class=textinput></td>
			</tr>
			<tr>
				<td class=email_table_td valign=top>Message</td>
				<td class=email_table_td><textarea name=body cols=30 rows=8 class=textarea></textarea></td>
			</tr>
			<tr>
				<td class=email_table_td> </td><td class=email_table_td><input type=submit value=Send class=button><p>(NOTE: on large databases this may take a few minutes, please give ALL the results time to load. If you close your browser window before the results ALL load, the process will still run on the server until it completes, however you will not see the results. The system is set to send 1 email every <b>$sleep</b> seconds, edit this through the config.php file.)<br></td>
			</tr>
		</table>
		</form>
\n\n"; }



}

################################################################################

elseif ($t=="stats") {

	echo "<font class=stats_header>Site Stats</font><p>Here are some facts about your site.<p><br>";


	$rows = mysql_query("SHOW table STATUS"); 
	$dbsize = 0; 
	while ($row = mysql_fetch_array($rows)) { 
		$dbsize += $row['Data_length'] + $row['Index_length']; $tabs++; } 

	$e=mysql_query("select * from $mainstatstable where id>='1' limit 1");
	$f = mysql_fetch_object($e);

	$g=mysql_query("select * from $userstable where id>='1'");
	while($h=mysql_fetch_object($g)) {
		if (($h->lastpay != "Free") && ($h->lastpay)) $tpaid++;
		elseif ($h->lastpay == "Free") $tboth++;
		elseif (!$h->paytype) $tfree++; }

if (!$tpaid) $tpaid = "0";
if (!$tfree) $tfree = "0";
if (!$tboth) $tboth = "0";

	echo "<table width=80%>
<tr><td>Database Size:</td><td>".round(($dbsize/1000000),2)."Mb ($dbsize bytes)</td></tr>
<tr><td>Database Tables:</td><td>$tabs Tables</td></tr>

<tr><td>Total Counter Loads:</td><td>$f->actual_counts</td></tr>
<tr><td>Total Visitors to a Counter:</td><td>$f->actual_viewers</td></tr>
<tr><td>Current Members:</td><td>".($tpaid+$tfree+$tboth)." ($tfree Free, $tpaid Paid, $tboth Paid Status for Free)</td></tr>
<tr><td>Total Accounts Created:</td><td>$f->actual_members</td></tr>
<tr><td>Total Accounts Deleted:</td><td>$f->members_deleted</td></tr>
<tr><td>Total Members to have Ever Paid:</td><td>$f->paid</td></tr>
<tr><td>Paid Members Whose Subscription Expired:</td><td>$f->cancelled</td></tr>
<tr><td>Paid Members Who Cancelled Subscription:</td><td>$f->members_expired</td></tr>

</table>";

}

################################################################################

elseif ($t=="purge") {

	echo "<font class=stats_header>Purge Inactive and Expired Accounts</font><p>Here you can remove accounts and info clogging your system unused.<p><br>";

	echo "
Show me accounts that have not been logged into for<br><input type=text class=textinputsmall name=numdays> Days <input type=submit value=Go class=button><p>
Show me accounts that have not recorded any stat or count information for<br><input type=text class=textinputsmall name=numdays> Days <input type=submit value=Go class=button><br>
\n\n";



	$c=mysql_query("select * from $userstable");
}

################################################################################

elseif ($t=="info") {

	echo "<font class=stats_header>More Site Information</font><p>Here is some important information about this script.<p><br><table width=100%><tr><td>";

	echo "

<li><font class=stats_subheader>config.php</font><p>The config.php file holds much useful information which can be edited, including the following...
<ul>
<li>Database Settings<p>
<li>Site URL Settings<p>
<li>Administrator Username and Password<p>
<li>Random generated Password Settings<p>
<li>A few more PayPal variables<p>
<li>Assorted HTML and Messages shown throughout the site<p>
</ul><p>







<li><font class=stats_subheader>Templates Subfolder</font><p>The /templates folder contains many useful templates you can edit. Here is the complete list.
<ul>
<li>/templates/styles.css<br>This file holds all of the css styling for you to edit, well commented so you can find your way around.<p>
<li>/templates/recommended.php<br>This file holds all of the links in the 'Recommended' section of the left sidebar for you to edit as you see fit.<p>
<li>/templates/ads.php<br>This file holds whatever text or HTML you want to show up in the left sidebar, in the table under the 'Recommended' links.<p>
<li>/templates/terms.php<br>This file holds the 'Terms of Agreement' users will have to agree to in order to create an account.<p>
<li>/templates/navlinks.php<br>This file holds all of the links in the navbar below the logo at the top of the page, minus the first link, which is controlled by the script.<p>
<li>/templates/layout_top.php<br>This file holds the top of page layouts for the respective visitor to the site (everything on the page up until the script output, which is the content of the main window on every page). This file generally does not need editing unless you want to make changes to the layout. If you do edit this file, be careful, there is php code within it that must be preserved or you will lose script functionality.<p>
<li>/templates/layout_bottom.php<br>This file holds the bottom of page layout, placed underneath the script output to complete the page. Careful! The same rules for the top layout file mentioned above apply here.<p>
<li>/templates/mail-signup.php<br>This file holds the signup email subject and message sent out to new members.<p>
<li>/templates/mail-lost.php<br>This file holds the subject and message sent to members who lose their password and request a new one.<p>
<li>/templates/mail-paid.php<br>This file holds the subject and message of the email sent to members who upgrade their account.<p>
<li>/templates/mail-invalid.php<br>This file holds the emails sent out to members who try to upgrade but submit an invalid payment.<p>
<li>/templates/mail-cancelled.php<br>This file holds the email sent to paid members who cancel their paid subscription.<p>
<li>/templates/mail-renew.php<br>This file holds the email sent to paid members who renew their paid subscription every term.<p>
</ul><p>




<li><font class=stats_subheader>Includes Subfolder</font><p>The /includes folder has many files in it, but there are a few here you can edit as well.
<ul>
<li>includes/categories.txt<br>This file holds a list of every website category members can choose from, 1 per line.<p>
<li>includes/countries.txt<br>This file holds a list of every country the member can choose from for his country.<p>
</ul><p>



<li><font class=stats_subheader>Images Subfolder</font><p>The /images folder has all of the image files the site uses.
<ul>
<li>images/digits/<br>This folder has 31 subfolders. Folder /digits1 through /digits30 hold the 30 gif counter styles. Each of these folders have 10 .gif images in them representing 0-9. The subfolder digits0 holds only blank digit images and should be left alone.<p>
<li>images/layout/<br>This folder holds all the layout images for the site.<p>
<li>images/layout/tinylogo.gif<br>This is the small icon used when a member chooses the 'icon' style counter for their site.<p>
</ul><p>




<li><font class=stats_subheader>More Editable Files</font><p>All of the following files has content in it which you may or may not want to edit.
<ul>
<li>privacy.php
<li>help.php
<li>features.php
<li>services.php

</ul><p>

</table>
";



	$c=mysql_query("select * from $userstable");
}

################################################################################

elseif ($t=="a") {


	if (!is_numeric($start)) $start=0;

	echo "<font class=stats_header>View All Members</font><p>Here you can view all of your members and edit, delete, upgrade, downgrade, and more.<p><br>";


######


	if($todo=="delete") {
		mysql_query("delete from $userstable where id=$id");
		mysql_query("delete from $pagestable where userid=$id");
		mysql_query("drop table ".$statstableprefix."_".$id."");
		mysql_query("drop table ".$statstableprefix."_".$id."_old");
		$w=mysql_query("select * from $mainstatstable where id>='1' limit 1");
		$u=mysql_fetch_object($w);
		mysql_query("update $mainstatstable set members_deleted='".($u->members_deleted+1)."' where id='$u->id'");
		echo "<font class=confirm_font>User ID $id has been permenately removed from the system.</font><p>\n\n"; }

	if($todo=="upgrade") {
		mysql_query("update $userstable set lastpay='Free',paytype='3' where id=$id");
		echo "<font class=confirm_font>User ID $id has been upgraded to a paid user level 3 at no charge.</font><p>\n\n"; }

	if($todo=="downgrade") {
		mysql_query("update $userstable set lastpay='0',paytype='0' where id=$id");
		echo "<font class=confirm_font>User ID $id has had their free paid status revoked.</font><p>\n\n"; }

	if($todo=="reset") {
		mysql_query("update $userstable set pageloads='0' where id=$id");
		echo "<font class=confirm_font>User ID $id has had their pageloads reset to zero.</font><p>\n\n"; }



######



	if((!$sort) && (!$user)) {
		$sd = "Showing all users, newest first.";
		$c=mysql_query("select * from $userstable order by id desc limit $start,50"); }
	elseif($sort == "Paid") {
		$sd = "Showing paid users first.";
		$c=mysql_query("select * from $userstable order by lastpay desc limit $start,50"); }
	elseif($sort == "Free") {
		$sd = "Showing free members first.";
		$c=mysql_query("select * from $userstable order by lastpay asc limit $start,50"); }
	elseif($sort == "fn") {
		$sd = "Sorted by first name ascending.";
		$c=mysql_query("select * from $userstable order by first_name asc limit $start,50"); }
	elseif($sort == "ln") {
		$sd = "Sorted by last name ascending.";
		$c=mysql_query("select * from $userstable order by last_name asc limit $start,50"); }
	elseif($sort == "un") {
		$sd = "Sorted by username ascending.";
		$c=mysql_query("select * from $userstable order by username asc limit $start,50"); }
	elseif($sort == "fn2") {
		$sd = "Sorted by first name descending.";
		$c=mysql_query("select * from $userstable order by first_name desc limit $start,50"); }
	elseif($sort == "ln2") {
		$sd = "Sorted by last name descending.";
		$c=mysql_query("select * from $userstable order by last_name desc limit $start,50"); }
	elseif($sort == "un2") {
		$sd = "Sorted by username descending.";
		$c=mysql_query("select * from $userstable order by username desc limit $start,50"); }

	elseif($user) {
		$sd = "Showing anything with <u>$user</u> in the username, first or last name, email, or anywhere in the address.";
		$c=mysql_query("select * from $userstable where username like '%$user%' or first_name like '%$user%' or last_name like '%$user%' or email like '%$user%' or address1 like '%$user%' or address2 like '%$user%' or city like '%$user%' or state like '%$user%' or country like '%$user%'"); }
	elseif($findid) {
		$sd = "Showing user ID $findid.";
		$c=mysql_query("select * from $userstable where id='$findid'"); }




######




	echo "
<table class=show_users_table>
	<tr>
		<td colspan=10 class=show_users_table_td align=center>

		<table width=100%><tr><td>
		<form method=post><select name=sort class=selectsmall>
		<option class=option value=\"\">Recent Signups</option>
		<option class=option value=\"Paid\">Paid First</option>
		<option class=option value=\"Free\">Free First</option>
		<option class=option value=\"fn\">First Name Asc</option>
		<option class=option value=\"fn2\">First Name Desc</option>
		<option class=option value=\"ln\">Last Name Asc</option>
		<option class=option value=\"ln2\">Last Name Desc</option>
		<option class=option value=\"un\">Username Asc</option>
		<option class=option value=\"un2\">Username Desc</option>
		</select>&nbsp;<input type=submit class=button value='Sort Members'></form>
		</td><td align=center>
		<form method=post><input type=text class=textinputsmall name=findid value='123'>&nbsp;<input type=submit class=button value='Find User ID'></form>
		</td><td align=right>
		<form method=post><input type=text class=textinput name=user>&nbsp;<input type=submit class=button value='Search All'></form>
		</table>
\n\n";

	if ($sd) echo "<p><br><font class=admin_search_font>$sd</font><br>";

	echo "
		</td>
	</tr>
	<tr>
		<td class=show_users_table_header>ID:</td>
		<td class=show_users_table_header>Username & Date:</td>
		<td class=show_users_table_header>Name & Email:</td>
		<td class=show_users_table_header>Address:</td>
		<td class=show_users_table_header>Website:</td>
		<td class=show_users_table_header>Payments:</td>
		<td class=show_users_table_header>Actions:</td>
	</tr>
\n\n";

	while($d=mysql_fetch_object($c)) {
		if (is_numeric($d->lastpay) && ($d->lastpay)) $showpay = "Last&nbsp;Paid: ".date("m-d-Y",$d->lastpay);
		elseif ($d->lastpay) $showpay = $d->lastpay;

		echo "
	<tr>
		<td class=show_users_table_td valign=top>".$d->id."</td>
		<td class=show_users_table_td valign=top>".$d->username."<br>".date("m-d-Y",$d->signup)."</td>
		<td class=show_users_table_td valign=top><a href=mailto:".$d->email." title=\"$d->email\">".$d->first_name." ".$d->last_name."</a></td>
		<td class=show_users_table_td valign=top><a href=\"javascript:alert('".addslashes($d->address1)." ".addslashes($d->address2)."')\" title=\"".$d->address1." ".$d->address2."\">".$d->city.", ".$d->state."<br>".$d->zip." ".$d->country."</a></td>
		<td class=show_users_table_td valign=top><a href=".$d->url." target=_blank title=\"$d->url\">".$d->title."</a></td>
		<td class=show_users_table_td valign=top>Level:&nbsp;".$d->paytype."<br>$showpay</td>
		<td class=show_users_table_td valign=top align=center>";


		echo "<a href=#delete title=\"Delete this member!\" onclick=\"conf('?t=a&todo=delete&id=$d->id&start=$start','Are you sure you want to Delete this member? This is quite permenant, all of this member\'s information and stats are about to be wiped out.')\"><img src=images/delete.gif border=0 height=16 width=16></a>";
		if (!$d->lastpay) echo "<a href=#upgrade title=\"Upgrade member for free!\" onclick=\"conf('?t=a&todo=upgrade&id=$d->id&start=$start','Are you sure you want to upgrade this member to a free paid status?')\"><img src=images/upgrade.gif border=0 height=16 width=16></a>";
		if ($d->lastpay == "Free") echo "<a href=#downgrade title=\"Downgrade this member's free upgraded status!\" onclick=\"conf('?t=a&todo=downgrade&id=$d->id&start=$start','Are you sure you want to downgrade this member\'s free paid status?')\"><img src=images/downgrade.gif border=0 height=16 width=16></a>";
		echo "<br>";
		echo "<a href=#reset title=\"Reset this member's monthly pageloads to zero!\" onclick=\"conf('?t=a&todo=reset&id=$d->id&start=$start','Are you sure you want to reset this member\'s monthly pageloads for this month to zero?')\"><img src=images/reset.gif border=0 height=16 width=16></a>";
		echo "<a href=members.php?uname=$d->username title=\"Login to this member's account!\"><img src=images/login.gif border=0 height=16 width=16></a></td>
	</tr>
\n\n"; }

	echo "</table>

<script language=javascript>
function conf(url,message) {
	var con = confirm(message);
	if (con) document.location = url; }
</script>
\n\n";



######



	if((!$sort) && (!$user)) {
		$c=mysql_query("select count(*) from $userstable order by id desc"); }
	elseif($sort == "Paid") {
		$c=mysql_query("select count(*) from $userstable order by lastpay desc"); }
	elseif($sort == "Free") {
		$c=mysql_query("select count(*) from $userstable order by lastpay asc"); }
	elseif($sort == "fn") {
		$c=mysql_query("select count(*) from $userstable order by first_name asc"); }
	elseif($sort == "ln") {
		$c=mysql_query("select count(*) from $userstable order by last_name asc"); }
	elseif($sort == "un") {
		$c=mysql_query("select count(*) from $userstable order by username asc"); }

	elseif($sort == "fn2") {
		$c=mysql_query("select count(*) from $userstable order by first_name desc"); }
	elseif($sort == "ln2") {
		$c=mysql_query("select count(*) from $userstable order by last_name desc"); }
	elseif($sort == "un2") {
		$c=mysql_query("select count(*) from $userstable order by username desc"); }

	elseif($user) {
		$c=mysql_query("select count(*) from $userstable where username like '%$user%' or first_name like '%$user%' or last_name like '%$user%' or email like '%$user%' or address1 like '%$user%' or address2 like '%$user%' or city like '%$user%' or state like '%$user%' or country like '%$user%'"); }
	elseif($findid) {
		$c=mysql_query("select count(*) from $userstable where id='$findid'"); }

	echo "<p>Page: &#187; ";
	$d=mysql_result($c,0);
	if($start) echo "<a href=?t=a&user=$user&start=",$start-50,">(prev)</a> ";
	if($start<$d-30) echo "<a href=?t=a&user=$user&start=",$start+50,"&sort=$sort>(next)</a> ";
	$start=0;
	$d/=50;
	$d++;
	echo "&#187; ";
	for($i=1;$i<=$d;$i++) {
		echo " <a href=?t=a&user=$user&start=$start&sort=$sort>$i</a> ";
		$start+=50; }



} 

#########################################################################################


}



else {

echo "
<form method=post action=admin.php>
<table class=login_table>
	<tr>
		<td class=login_table_td colspan=2 align=center>Please Enter Your Admin Username and Password<p>
		You <i>need cookies enabled</i> to continue!<br><br></td>
	</tr>
	<tr>
		<td class=login_table_td width=20% align=right>User:</td>
		<td class=login_table_td width=80% align=left><input type=text name=username class=textinput></td>
	</tr>
	<tr>
		<td class=login_table_td width=20% align=right>Pass:</td>
		<td class=login_table_td width=80% align=left><input type=password name=password class=textinput></td>
	</tr>
	<tr>
		<td class=login_table_td width=20% align=right> </td>
		<td class=login_table_td width=80% align=left><input type=submit value=Proceed class=button></td>
	</tr>
</table>
</form>

";
}






include "templates/layout_bottom.php";
?>


