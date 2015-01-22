<?


$now2 = date("m,d,Y", $now);
$flast24 = date("m,d,Y", ($now-(60*60*24)));
$flastweek = date("m,d,Y", ($now-(60*60*24*7)));
$flastmonth = date("m,d,Y", ($now-(60*60*24*31)));
$flastyear = date("m,d,Y", ($now-(60*60*24*365)));

$last24 = $flast24.",".$now2;
$lastweek = $flastweek.",".$now2;
$lastmonth = $flastmonth.",".$now2;
$lastyear = $flastyear.",".$now2;

$yesterday = strtotime('-1 days');
$yesterday = date("m,d,Y", $yesterday).",".$now2;
$today = strtotime('-0 days');
$today = date("m,d,Y", $today).",".$now2;






$selectc = "document.filterform.domain.value='';document.filterform.page.value='';";
$selectd = "document.filterform.camp.value='';document.filterform.page.value='';";
$selectp = "document.filterform.domain.value='';document.filterform.camp.value='';";






echo "
<form method=post action=members.php name=filterform>
<input type=hidden name=stat value=\"$stat\">
<input type=hidden name=records value=\"$records\">
<table bgcolor=#eeeeee cellpadding=2 width=100%><tr><td align=center>

<table>
	<tr>

		<td><input type=text name=fday class=textinputsmall value=1></td>
		<td><select name=fmonth class=selectsmall onchange=\"document.filterform.datestring.value='';\">
<option value=\"\" class=option>Select Month</option>
<option value=\"01\" class=option>Jan</option>
<option value=\"02\" class=option>Feb</option>
<option value=\"03\" class=option>Mar</option>
<option value=\"04\" class=option>Apr</option>
<option value=\"05\" class=option>May</option>
<option value=\"06\" class=option>Jun</option>
<option value=\"07\" class=option>Jul</option>
<option value=\"08\" class=option>Aug</option>
<option value=\"09\" class=option>Sep</option>
<option value=\"10\" class=option>Oct</option>
<option value=\"11\" class=option>Nov</option>
<option value=\"12\" class=option>Dec</option>
		</select></td>
		<td><input type=text name=fyear class=textinputsmall value=2007></td>
		<td>through&nbsp;<input type=text name=tday class=textinputsmall value=31></td>
		<td><select name=tmonth class=selectsmall onchange=\"document.filterform.datestring.value='';\">
<option value=\"\" class=option>Select Month</option>
<option value=\"01\" class=option>Jan</option>
<option value=\"02\" class=option>Feb</option>
<option value=\"03\" class=option>Mar</option>
<option value=\"04\" class=option>Apr</option>
<option value=\"05\" class=option>May</option>
<option value=\"06\" class=option>Jun</option>
<option value=\"07\" class=option>Jul</option>
<option value=\"08\" class=option>Aug</option>
<option value=\"09\" class=option>Sep</option>
<option value=\"10\" class=option>Oct</option>
<option value=\"11\" class=option>Nov</option>
<option value=\"12\" class=option>Dec</option>
		</select></td>
		<td><input type=text name=tyear class=textinputsmall value=2007></td>
		<td>or&nbsp;<select name=datestring class=selectsmall>
<option value=\"\" class=option>Select Timespan</option>
<option value=\"$today\" class=option>Today</option>
<option value=\"$yesterday\" class=option>Yesterday</option>
<option value=\"$last24\" class=option>Last 24 Hours</option>
<option value=\"$lastweek\" class=option>Last Week</option>
<option value=\"$lastmonth\" class=option>Last Month</option>
<option value=\"$lastyear\" class=option>Last Year</option>
		</select></td>

	</tr>
	<tr>

		<td colspan=8 align=center><select name=camp class=selectsmall onchange=\"$selectc\"><option value=\"\" class=option>All Campaigns</option>
		$options</select>&nbsp;<select name=domain class=selectsmall onchange=\"$selectd\"><option value=\"\" class=option>All Domains</option>
		$options3</select>&nbsp;<select name=page class=selectsmall onchange=\"$selectp\"><option value=\"\" class=option>All Pages</option>
		$options2</select>&nbsp;<input type=submit value=\"Filter Stats\" class=button>&nbsp;<input type=button value=\"Clear Filters\" class=button onclick=\"document.location='members.php?stat=$stat&records=$records';\"></td>

	</tr>
</table>
</table>";



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






?>