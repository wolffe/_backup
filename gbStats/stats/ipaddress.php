<?php

$stat = "ipaddress";

##### PAGE NUMBER VARIABLES
if (!$p) $p = 1;
$np = $p + 1;
$pp = $p - 1;
$start = $limitresults * $p - $limitresults;
$end = $start + $limitresults;


##### START THIS STAT REPORT AND PRINT OUT THE
##### CAMPAIGN/DATE FILTER FORM

echo "<font class=stats_header>Visitor Activity & Paths</font><br><font class=stats_subheader>$filtershow<br>$filtershow2</font><p><hr><br>";


$c = mysql_query("select $stat as h from $statstableprefix"."_".$id." where $stat!='0' and $stat!='' $filter $filter2 limit 1");
$d = mysql_fetch_object($c);


#########################################
if ($d->h) {
		$visittime1 = "0";
		$visittime5 = "0";
		$visittime10 = "0";
		$visittime20 = "0";
		$visittimemax = "0";
		$visittimes1 = "0";
		$visittimes5 = "0";
		$visittimes10 = "0";
		$visittimes20 = "0";
		$visittimesmax = "0";

include "includes/filterform.php";


if ($sorder == "timeasc") $order = "order by time asc";
elseif ($sorder == "timedesc") $order = "order by time desc";
else $order = "order by g desc";


##### CREATE THE TABLE OF RESULTS  TO BE PRINTED LATER AND
##### THE ARRAYS OF GRAPH INFORMATION

$echolater = "<table class=showstats width=100%>";

$c = mysql_query("select $stat as h,countrylanguage as j,count(*) as g from $statstableprefix"."_"."$id where id>='1' $filter $filter2 group by $stat $order");
while ($d = mysql_fetch_object($c)) {
	if ($d->h) {
		$number++;
		if ($sofarcount >= $start && $sofarcount <= $end) {
			$extra2 = "</td><td class=showstats align=left>".format_country_language($d->j)."";
			$extra2 .= "</td><td class=showstats width=10% align=right><a href=\"?stat=ip&ip=$d->h\" title=\"View Visitor Details & Path Through Site!\"><img src=images/summary.png border=0 alt=\"Details & Path\"></a>";
			$echolater .= "<tr><td class=showstats width=5% align=left>$number.</td><td class=showstats>$d->h&nbsp;$extra2</td><td class=showstats width=5% align=right>$d->g&nbsp;Pageloads</td></tr>"; } }


	if ($sofarcount < 20 && ($d->h)) {
		$graph_data_array[] = $d->g; }


		$now2 = $now;
		$numbvisits = 0;
		$visittime = 0;
		$u = mysql_query("select time from $statstableprefix"."_"."$id where hit='1' and ipaddress='$d->h' $filter order by time desc");
		while ($v = mysql_fetch_object($u)) {
			if (($now2 - $v->time) >= $newvisitduration) $numbvisits++;
			elseif (($now2 - $v->time) < $newvisitduration && ($now2 - $v->time) > 0) $visittime += ($now2 - $v->time);
			$now2 = $v->time; }


		if ($numbvisits <= 1) $visittimes1++;
		elseif ($numbvisits <= 5) $visittimes5++;
		elseif ($numbvisits <= 10) $visittimes10++;
		elseif ($numbvisits <= 20) $visittimes20++;
		elseif ($numbvisits > 20) $visittimesmax++;

		if ($visittime <= 60) $visittime1++;
		elseif ($visittime <= 300) $visittime5++;
		elseif ($visittime <= 600) $visittime10++;
		elseif ($visittime <= 1200) $visittime20++;
		elseif ($visittime > 1200) $visittimemax++;


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
if (!$nograph) {
	$sofarcount = 0;
	foreach ($graph_data_array as $i) {
		$graph_data1 .= "$i,";
		$sofarcount++;
		$graph_legends .= $sofarcount.","; }

	$graph_data1 = trim($graph_data1, "\,");
	$graph_legends = trim($graph_legends, "\,"); }

##### PRINT EVERYTHING TO THE SCREEN

echo "<br><img src=\"graph2.php?jptitle=Returning Visitors&filter=$filtershow&jplegends2= 1. One Visit, 2. Up to 5 Visits, 3. Up to 10 Visits, 4. Up to 20 Visits, 5. 20 or More Visits&jpdatav2=$visittimes1,$visittimes5,$visittimes10,$visittimes20,$visittimesmax\"><p><img src=\"graph2.php?jptitle=Visitor Time Spent&filter=$filtershow&jplegends2= 1. Up to a Minute, 2. Up to 5 Minutes, 3. Up to 10 Minutes, 4. Up to 20 Minutes, 5. 20 or More Minutes&jpdatav2=$visittime1,$visittime5,$visittime10,$visittime20,$visittimemax\"><p>";

echo "<img src=\"graph1.php?jptitle=Visitor Pageloads (First 20)&jplegends=$graph_legends&jpdata1=$graph_data1\"><p>";echo "<hr>$pagelinks<hr><br>$echolater </table><br><hr>$pagelinks<hr>"; }

else {	
echo "No Records Found!"; }


?>