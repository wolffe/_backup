<?php


if ($ipaddress) $ip2 = "(".gethostbyaddr($ip).")";


if (!$ip) {
	##### START THIS STAT REPORT 
	echo "<font class=stats_header>Lookup IP Address</font><p><form method=post><input type=hidden name=stat value=$stat><input type=text name=ip class=textinput><br><input type=submit value=Lookup class=button></form>"; }



else {


##### START THIS STAT REPORT 
echo "<font class=stats_header>Activity Report For<br>$ip</font><br><font class=stats_subheader>$ip2</font><p>";




##### CREATE THE TABLE OF RESULTS  TO BE PRINTED LATER AND
##### THE ARRAYS OF GRAPH INFORMATION
$echolater = "<table class=showstats width=100%>";
$e = mysql_query("select * from $statstableprefix"."_".$id." where ipaddress='$ip' order by time asc");

while($f=mysql_fetch_object($e)) {

	if ($f->hit) {
		$ubrowser = $f->browser;
		$uoperatingsystem = $f->operatingsystem;
		$uscreenresolution = $f->screenresolution." pixel screen";
		$ucolordepth = $f->colordepth." bit color";
		$ucountrylanguage = format_country_language($f->countrylanguage); }
	

	$timespan = $f->time - $lasttime;

	if (!$lasttime) $newvisit = 1;
	elseif ($timespan > $newvisitduration) $newvisit = 1;
	if ($newvisit) $echolater .= "<tr><td colspan=8 class=statsheaderlarge valign=center><br><font class=stats_subheader>New Visit</font><br><br><hr></td></tr>\n";

	if (!$newvisit) $timespan = "(".secs_to_string($timespan)." later)";
	else $timespan = "";

	$echolater .= "<tr><td class=showstats width=5% align=left>".($number+1).".</td>";

	if(strlen($f->url) >= 40) $showurl = substr($f->url,0,40)."...";
	else $showurl = $f->url;
	if(strlen($f->referer) >= 40) $showreferer = substr($f->referer,0,40)."...";
	else $showreferer = $f->referer;
	if(strlen($f->href) >= 75) $showhref = substr($f->href,0,75)."...";
	else $showhref = $f->href;




	if ($f->hit) { 
		$echolater .= "

<td class=stats>".date("h:i:s a",$f->time)." ".date("m-d-y",$f->time)." <i>$timespan</i></td><td class=stats>Campaign '".$pages_array[$f->pageid]."'</td></tr>
<tr>
<td class=stats> </td><td class=stats>Hit: <a href=\"$f->url\" title=\"$f->url\">$showurl</a></td>
<td class=stats>";



if ($f->referer) $echolater .= "From: <a href=\"$f->referer\" title=\"$f->referer\">$showreferer</a>";


$echolater .= "</td>
</tr>";
if ($f->keywords) $echolater .= "<tr><td class=stats> </td><td class=stats colspan=4>Keywords: $f->keywords</td></tr>"; }

	if (!$f->hit) { 
		$echolater .= "

<td class=stats>".date("h:i:s a",$f->time)." ".date("m-d-y",$f->time)." <i>$timespan</i></td><td class=stats>Campaign '".$pages_array[$f->pageid]."'</td></tr>
<tr><td class=stats> </td><td class=stats colspan=2>Clicked: <a href=\"$f->href\" title=\"$f->href\">$showhref</a></td></tr>"; }

	$echolater .= "<tr><td colspan=5><hr></td></tr>";
	$lasttime = $f->time;
	$newvisit = 0;
	$number++; }


if ($ubrowser) {

##### PRINT EVERYTHING TO THE SCREEN
echo "$uoperatingsystem $ubrowser $ucountrylanguage<br>$uscreenresolution $ucolordepth
<br><p>$echolater </table>";
}

else {

echo "Nothing found in your records for IP address<br>$ipaddress"; }

}


?>


