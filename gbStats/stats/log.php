<?php




echo "<font class=stats_header>Download Database Detailed Records</font><p>";



if ($sorder == "timeasc") $order = "order by time asc";
elseif ($sorder == "timedesc") $order = "order by time desc";
else $order = "order by time desc";





$string = "Content-Type:application/octet-stream 

Visitor IP Address\tTime and Date\nUnix Timestamp\nCampaign\tPage Hit\tReferring Page\tSearch Engine\tKeywords\Screen Resolution\tColor Depth\tCountry and Language\tBrowser Type\tOperating System Type\n";

$c = mysql_query("select * from $statstableprefix"."_".$id." where id>='1' and hit='1' $order");
while ($d = mysql_fetch_object($c)) {

	$dustin = $d->pageid;

	$string .= "$d->ipaddress\t";
	$string .= date("h:i:s a T D, M d, Y.",$d->time)."\t";
	$string .= "$d->time\t";
	$string .= "$pages_array[$dustin]\t";
	$string .= "$d->url\t";
	$string .= "$d->referer\t";
	$string .= "$d->engine\t";
	$string .= "$d->keywords\t";
	$string .= "$d->screenresolution\t";
	$string .= "$d->colordepth\t";
	$string .= "$d->countrylanguage\t";
	$string .= "$d->browser\t";
	$string .= "$d->operatingsystem\n"; }


$file = fopen("tmp/$now.xls", "w+");
fputs($file,"$string");
fclose($file);


echo "<a href=\"tmp/$now.xls\">Click Here</a><br>to download your detailed database records<br>as a .xls file.";

?>