<?php



##### START THIS STAT REPORT
echo "<font class=stats_header>Campaigns</font><p>";


$thismonth = date("m");
$thisday = date("d");



$totalpl = "0";
$thismonthpl = "0";
$todaypl = "0";
$yesterdaypl = "0";

##### CREATE THE TABLE OF RESULTS  TO BE PRINTED LATER
$echolater = "<table class=showstats width=100%>
<tr>
	<td class=showstats align=left> </td>
	<td class=showstats> </td>
	<td class=showstats align=right> </td>

	<td class=showstats align=right>Today</td>
	<td class=showstats align=right>This&nbsp;Month</td>
	<td class=showstats align=right>Total</td></tr>";


$sofarcount = 0;
	
$c = mysql_query("select * from $pagestable where userid='$id' order by title,url desc");
while ($d = mysql_fetch_object($c)) {

	if ($d->url) $campaignname = $d->url; 
	if ($d->title) $campaignname = $d->title; 
	$campaignid = $d->id; 

	$m = mysql_query("select id from $statstableprefix"."_".$id." where pageid='$campaignid'");
	$campaign_records[$campaignid] = mysql_num_rows($m);
	$campaign_titles[$campaignid] = $campaignname;

	$m = mysql_query("select * from $statstableprefix"."_".$id."_old where pageid='$campaignid'");
	while ($n=mysql_fetch_object($m)) {
		if (date("d",$n->time) == $thisday) $todaypl = $n->hits;
		if (date("m",$n->time) == $thismonth) $thismonthpl += $n->hits;
		$totalpl += $n->hits; }

	if (strlen($campaignname) >= 40) $showthiscampaignname = substr($campaignname,0,40)."...";
	else $showthiscampaignname = $campaignname;

	if (!$campaign_records[$campaignid]) $campaign_records[$campaignid] = "0";

	$echolater .= "<tr>
	<td class=showstats align=left>".($sofarcount+1).".</td>
	<td class=showstats><b><a title=\"$campaignname\">$showthiscampaignname</a></b></td>
	<td class=showstats align=right><a href=?stat=all&campid=$campaignid title=\"Campaign Summary\"><img src=images/summary.gif alt=\"Summary\" border=0></a>
					<a href=edit.php?m=cc&camp=$campaignid title=\"Get Webpage Javascript Code\"><img src=images/code.gif alt=\"Javascript\" border=0></a>
					<a href=edit.php?m=ec&editid=$campaignid title=\"Edit This Campaign\"><img src=images/edit.gif alt=\"Edit\" border=0></a>
					<a href=edit.php?m=dc&delid=$campaignid title=\"Delete This Campaign\"><img src=images/delete.gif alt=\"Delete\" border=0></a></td>

	<td class=showstats align=right>$todaypl</td>
	<td class=showstats align=right>$thismonthpl</td>
	<td class=showstats align=right>$totalpl</td></tr>";

	$sofarcount++; }








#########################################
if ($campaign_records) {















##### PRINT EVERYTHING TO THE SCREEN
echo "<br><br>$echolater </table><br>";

}





else {
	echo "No Campaigns Found!<p>";
	if (!$sort && !$domain && !$page && !$camp) echo "$welcome_message"; }



?>








