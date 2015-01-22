<table class=member_links>
	<tr>
		<td class=member_links2 align=center>
		<font class=member_links_header_font>Administration</font><hr></td>
	</tr>
	<tr>
		<td class=member_links>


<?php
if ($adminlogged && $dafuser) {
?>

<li>Logged in as '<?echo"$dafuser";?>'</li>
<li><a href=logout.php?admin=1>Logout of '<?echo"$dafuser";?>'</a></li><br>

<?php
}
?>


		<li><a href=admin.php?t=a>View All Accounts</a></li>
		<li><a href=admin.php?t=e>Email Users</a></li>
		<li><a href=admin.php?t=set>Settings</a></li>
		<li><a href=admin.php?t=stats>Site Stats</a></li>

		<li><a href=admin.php?t=purge>Purge Inactive Accounts</a></li>
		<li><a href=admin.php?t=info>More Site Info</a></li>
		<li><a href=admin.php?p=logout>Logout Of Admin</a></li>
	</tr>
</table>


