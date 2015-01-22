<?php


##### PAGE NUMBER VARIABLES
if (!$p) $p = 1;
$np = $p + 1;
$pp = $p - 1;
$start = $limitresults * $p - $limitresults;
$end = $start + $limitresults;


##### START THIS STAT REPORT AND PRINT OUT THE
##### CAMPAIGN/DATE FILTER FORM
echo "<font class=stats_header>Pageload Activity</font><br><font class=stats_subheader>$filtershow<br>$filtershow2</font><p>";












$c = mysql_query("select id from $statstableprefix"."_".$id." where hit='1' limit 1");
$d = mysql_fetch_object($c);



#########################################
if ($d->id) {







echo "<hr><br>";
include "includes/filterform.php";
echo "<p>";





if ($sorder == "timeasc") $order = "order by time asc";
elseif ($sorder == "timedesc") $order = "order by time desc";
else $order = "order by time desc";




##### CREATE THE TABLE OF RESULTS  TO BE PRINTED LATER AND
##### THE ARRAYS OF GRAPH INFORMATION
$echolater = "<table class=showstats width=100%>";
$c = mysql_query("select * from $statstableprefix"."_".$id." where id>='1' and hit='1' $filter $filter2 $order");
while ($d = mysql_fetch_object($c)) {

	if (strlen($d->url) >= 75) $showurl = substr($d->url,0,75)."..."; else $showurl = $d->url;
	if (strlen($d->href) >= 40) $showhref = substr($d->href,0,40)."..."; else $showhref = $d->href;
	if (strlen($d->referer) >= 75) $showreferer = substr($d->referer,0,75)."..."; else $showreferer = $d->referer;
	if (strlen($pages_array[$d->pageid]) >= 40) $showcampa = substr($pages_array[$d->pageid],0,40)."..."; else $showcampa = $pages_array[$d->pageid];
	$number++;
	if ($sofarcount >= $start && $sofarcount < $end) {
		$echolater .= "


<tr>
	<td class=showrecords align=left>$number.</td>
	<td class=showrecords align=left>".date("h:m:s a T - D, M d, Y",$d->time)."</td>
	<td class=showrecords align=left>Campaign: <a href=?camp=$d->pageid title=\"View Campaign Detailed Record Summary\">$showcampa</a></td>
</tr>
<tr>
	<td class=showrecords align=left> </td>
	<td class=showrecords align=left>IP Address: <a href=?stat=ip&ip=$d->ipaddress title=\"View Detailed Visitor Report\">$d->ipaddress</a></td>";


if ($d->hit) $echolater .= "<td class=showrecords align=left>$d->screenresolution $d->colordepth"."bit ".format_country_language($d->countrylanguage)."</td>";
if (!$d->hit) $echolater .= "<td class=showrecords align=left>Link Clicked: <a href=\"$d->href\" title=\"$d->href\" target=_blank>$showhref</a></td>";

$echolater .= "</tr>";


if ($d->hit) {
	$echolater .= "<tr>
	<td class=showrecords align=left> </td>
	<td class=showrecords colspan=2>Page Hit: <a href=\"$d->url\" title=\"$d->url\" target=_blank>$showurl</a></td>
</tr>";
	if ($d->referer) {
		$echolater .= "<tr>
	<td class=showrecords align=left> </td>
	<td class=showrecords colspan=2>Came From: <a href=\"$d->referer\" title=\"$d->referer\" target=_blank>$showreferer</a></td>
</tr>"; }
	if ($d->keywords) {
		$echolater .= "<tr>
	<td class=showrecords align=left> </td>
	<td class=showrecords colspan=2>Keywords: $d->keywords</td>
</tr>"; } }


$echolater .= "<tr>
	<td colspan=3 class=showrecords><hr></td>
</tr>


"; }
	$sofarcount++; } 




##### MORE PAGE NUMBER STUFF, CREATING THE LINKS NOW
$all = floor(($sofarcount/$limitresults)+1);
$previous = "<a href=?p=$pp&camp=$camp&records=1&sorder=$sorder&datestring=$datestring&domain=$domain&page=$page>PREV</a>";
$next = "<a href=?p=$np&camp=$camp&records=1&sorder=$sorder&datestring=$datestring&domain=$domain&page=$page>NEXT</a>";
$so1 = "<a href=?camp=$camp&records=1&sorder=timeasc&datestring=$datestring&domain=$domain&page=$page>Oldest</a>";
$so2 = "<a href=?camp=$camp&records=1&sorder=timedesc&datestring=$datestring&domain=$domain&page=$page>Newest</a>";
$current = " Showing Page $p of $all ";
if ($all == 1) $pagelinks = "$current";
elseif ($p == 1 && $all > 1) $pagelinks = "$current $next";
elseif ($p > 1 && $all > $p) $pagelinks = "$previous $current $next";
else $pagelinks = "$previous $current";
$pagelinks = "<table cellpadding=0 border=0 cellspacing=0 class=pagelinks><tr><td align=center class=pagelinks>$pagelinks | Order By: $so1 - $so2</table>";






##### PRINT EVERYTHING TO THE SCREEN
echo "<hr>$pagelinks<hr><br>$echolater </table><br>$pagelinks<br>";












}


else {
	echo "No Records Found!"; }


?>