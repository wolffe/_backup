<?php


##### PAGE NUMBER VARIABLES
if (!$p) $p = 1;
$np = $p + 1;
$pp = $p - 1;
$start = $limitresults * $p - $limitresults;
$end = $start + $limitresults;


##### START THIS STAT REPORT AND PRINT OUT THE
##### CAMPAIGN/DATE FILTER FORM
echo "<font class=stats_header>Popular Domains</font><br><font class=stats_subheader>$filtershow<br>$filtershow2</font><p>";



if ($sorder == "timeasc") $order = "order by time asc";
elseif ($sorder == "timedesc") $order = "order by time desc";
else $order = "order by g desc";



##### CREATE THE TABLE OF RESULTS  TO BE PRINTED LATER AND
##### THE ARRAYS OF GRAPH INFORMATION
$echolater = "<table class=showstats width=100%>";
$c = mysql_query("select url,count(*) as g from $statstableprefix"."_".$id." where id>='1' $filter $filter2 group by url $order");
while ($d = mysql_fetch_object($c)) {
	if ($d->url) {
		$domainz = split("/",$d->url);
		$domain = $domainz[2];
		$domains[$domain] += $d->g; } }






#########################################
if ($domains) {



echo "<hr><br>";
include "includes/filterform.php";


arsort($domains);

$sofarcount = 0;
foreach ($domains as $key=>$value) {
	if ($sofarcount >= $start && $sofarcount <= $end) {
		$echolater .= "<tr><td class=showstats width=10% align=left>".($sofarcount+1).".</td><td class=showstats width=80%><a href=\"$key\" title=\"$key\" target=_blank>$key</a></td><td class=showstats width=10% align=right>$value&nbsp;Pageloads</td></tr>"; }
	if ($sofarcount < 20 && ($key)) {
		$graph_data_array[] = $value; }
	$sofarcount++; }







##### MORE PAGE NUMBER STUFF, CREATING THE LINKS NOW
$all = floor(($sofarcount/$limitresults)+1);
$previous = "<a href=?p=$pp&camp=$camp&stat=$stat&sorder=$sorder&datestring=$datestring&domain=$domain&page=$page>PREV</a>";
$next = "<a href=?p=$np&camp=$camp&stat=$stat&sorder=$sorder&datestring=$datestring&domain=$domain&page=$page>NEXT</a>";
$so1 = "<a href=?camp=$camp&stat=$stat&sorder=timeasc&datestring=$datestring&domain=$domain&page=$page>Oldest</a>";
$so2 = "<a href=?camp=$camp&stat=$stat&sorder=timedesc&datestring=$datestring&domain=$domain&page=$page>Newest</a>";
$so3 = "<a href=?camp=$camp&stat=$stat&datestring=$datestring&domain=$domain&page=$page>Most Results</a>";
$current = " Showing Page $p of $all ";
if ($all == 1) $pagelinks = "$current";
elseif ($p == 1 && $all > 1) $pagelinks = "$current $next";
elseif ($p > 1 && $all > $p) $pagelinks = "$previous $current $next";
else $pagelinks = "$previous $current";
$pagelinks = "<table cellpadding=0 border=0 cellspacing=0 class=pagelinks><tr><td align=center class=pagelinks>$pagelinks | Order By: $so1 - $so2 - $so3</table>";





##### FINISH CREATING THE GRAPH INFO
$sofarcount = 0;
foreach ($graph_data_array as $i) {
	$graph_data1 .= "$i,";
	$sofarcount++;
	$graph_legends .= $sofarcount.","; }
$graph_data1 = trim($graph_data1, "\,");
$graph_legends = trim($graph_legends, "\,");



##### PRINT EVERYTHING TO THE SCREEN
echo "<br><img src=\"graph1.php?jptitle=$statshow (First 20)&jplegends=$graph_legends&jpdata1=$graph_data1\"><br><br>";
echo "<hr>$pagelinks<hr><br>$echolater </table><br><hr>$pagelinks<hr>";


}

else {
	echo "No Records Found!"; }



?>