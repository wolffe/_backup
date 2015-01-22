<?php
$now2 = date('m,d,Y', $now);
$flast24 = date('m,d,Y', ($now-(60*60*24)));
$flastweek = date('m,d,Y', ($now-(60*60*24*7)));
$flastmonth = date('m,d,Y', ($now-(60*60*24*31)));
$flastyear = date('m,d,Y', ($now-(60*60*24*365)));

$last24 = $flast24 . ',' . $now2;
$lastweek = $flastweek . ',' . $now2;
$lastmonth = $flastmonth . ',' . $now2;
$lastyear = $flastyear . ',' . $now2;

$yesterday = strtotime('-1 days');
$yesterday = date('m,d,Y', $yesterday) . ',' . $now2;
$today = strtotime('-0 days');
$today = date('m,d,Y', $today) . ',' . $now2;
?>

<form method="post" action="members.php" name="filterform">
	<input type="hidden" name="stat" value="<?php echo $stat; ?>">
	<input type="hidden" name="dom" value="<?php echo $dom; ?>">
	<input type="hidden" name="dow" value="<?php echo $dow; ?>">
	<input type="hidden" name="mon" value="<?php echo $mon; ?>">
	<input type="hidden" name="yea" value="<?php echo $yea; ?>">
	<input type="hidden" name="records" value="<?php echo $records; ?>">


<table border="1">
	<tr>

		<td>
	<input type="text" name="fday" class="m-ctrl-small input-small" value="1" min="1" max="31"> 
	<select name="fmonth" class="m-wrap" onchange="document.filterform.datestring.value='';">
		<option value="">Select Month</option>
		<option value="01">Jan</option>
		<option value="02">Feb</option>
		<option value="03">Mar</option>
		<option value="04">Apr</option>
		<option value="05">May</option>
		<option value="06">Jun</option>
		<option value="07">Jul</option>
		<option value="08">Aug</option>
		<option value="09">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
	</select> 
	<input type="number" name="fyear" class="input-small" value="2013" min="2000" max="2020"> to <input type="number" name="tday" class="input-small" value="31" min="1" max="31"> 
	<select name="tmonth" class="m-wrap" onchange="document.filterform.datestring.value='';">
		<option value="">Select Month</option>
		<option value="01">Jan</option>
		<option value="02">Feb</option>
		<option value="03">Mar</option>
		<option value="04">Apr</option>
		<option value="05">May</option>
		<option value="06">Jun</option>
		<option value="07">Jul</option>
		<option value="08">Aug</option>
		<option value="09">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
	</select> 
	<input type="number" name="tyear" class="input-small" value="2013" min="2000" max="2020"> or&nbsp;<select name=datestring class=selectsmall>
<option value="">Select Timespan</option>
<option value="<?php echo $today; ?>">Today</option>
<option value="<?php echo $yesterday; ?>">Yesterday</option>
<option value="<?php echo $last24; ?>">Last 24 Hours</option>
<option value="<?php echo $lastweek; ?>">Last Week</option>
<option value="<?php echo $lastmonth; ?>">Last Month</option>
<option value="<?php echo $lastyear; ?>">Last Year</option>
		</select></td>

	</tr>


	<tr>

		<td align=center>Show:&nbsp;<input type=checkbox value=1 name=gshits onchange="document.filterform.gsall.checked=false;">&nbsp;Pageloads&nbsp;<input type=checkbox value=1 name=gsclicks onchange="document.filterform.gsall.checked=false;">&nbsp;Clicks&nbsp;<input type=checkbox value=1 name=gsvisitors onchange="document.filterform.gsall.checked=false;">&nbsp;Unique Visitors&nbsp;<input type=checkbox value=1 name=gsrvisitors onchange="document.filterform.gsall.checked=false;">&nbsp;Return Visitors&nbsp;<input type=checkbox value=1 name=gsall onchange="document.filterform.gshits.checked=false;document.filterform.gsclicks.checked=false;document.filterform.gsvisitors.checked=false;document.filterform.gsrvisitors.checked=false;">&nbsp;Show&nbsp;All</td>

	</tr>


	<tr>

		<td align=center><select name=campid class=selectsmall onchange="<?php echo $selectc; ?>"><option value="">All Campaigns</option>
		<?php echo $options; ?></select>&nbsp;<input type=submit value="Filter Stats" class=button>&nbsp;<input type=button value="Clear Filters" class=button onclick="document.location='members.php?stat=<?php echo $stat; ?>&records=<?php echo $records; ?>';"></td>

	</tr>
</table>
<p>

<?php

$qstr = "?campid=$campid&stat=$stat&tday=$tday&tmonth=$tmonth&tyear=$tyear&fday=$fday&fmonth=$fmonth&fyear=$fyear&";
$qstr .= "gshits=$gshits&gsvisits=$gsvisits&gsvisitors=$gsvisitors&gsclicks=$gsclicks&gsall=$gsall";
$lin1 = "<a href=".$qstr."&dow=1 title=\"View by Day of Week\">Day of Week</a>";
$lin2 = "<a href=".$qstr."&dom=1 title=\"View by Day of Month\">Day of Month</a>";
$lin3 = "<a href=".$qstr."&mon=1 title=\"View by Month of Year\">Month of Year</a>";
$lin4 = "<a href=".$qstr."&yea=1 title=\"View by Year\">Year</a>";

echo "$lin1 - $lin2 - $lin3 - $lin4<p>";


if ($gshits) $gshits2 = "true";
else $gshits2 = "false";
if ($gsclicks) $gsclicks2 = "true";
else $gsclicks2 = "false";
if ($gsvisitors) $gsvisitors2 = "true";
else $gsvisitors2 = "false";
if ($gsrvisitors) $gsrvisitors2 = "true";
else $gsrvisitors2 = "false";


if ($fmonth&&$fday&&$fyear&&$tmonth&&$tday&&$tyear) echo "
<script language=javascript>
document.filterform.fmonth.value='$fmonth';
document.filterform.fday.value='$fday';
document.filterform.fyear.value='$fyear';
document.filterform.tmonth.value='$tmonth';
document.filterform.tday.value='$tday';
document.filterform.tyear.value='$tyear';
</script>
";

echo "
<script language=javascript>
document.filterform.campid.value=$campid;
document.filterform.gshits.checked=$gshits2;
document.filterform.gsvisitors.checked=$gsvisitors2;
document.filterform.gsrvisitors.checked=$gsrvisitors2;
document.filterform.gsclicks.checked=$gsclicks2;
</script>
";






?>