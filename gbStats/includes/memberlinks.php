<div class="m-btn-group">
	<a class="m-btn green"><i class="icon-cog icon-white"></i> Account</a>
	<a class="m-btn green dropdown-carettoggle" data-toggle="dropdown" href="#">
		<span class="caret white"></span>
	</a>
	<ul class="m-dropdown-menu">
		<li><a href="members.php">Database Usage</a></li>
		<li class="divider"></li>
		<li><a href="edit.php?m=ad"><i class="icon-user"></i> Account Details</a></li>
		<?php if($paytype != 3) { ?><li><a href="edit.php?m=ad">Upgrade Account</a></li><?php } ?>
		<li><a href="edit.php?">Settings</a></li>
		<li><a href="edit.php?m=cp">Change Password</a></li>
	</ul>
</div>

<div class="m-btn-group">
	<a class="m-btn blue"><i class="icon-cog icon-white"></i> Stat Reports</a>
	<a class="m-btn blue dropdown-carettoggle" data-toggle="dropdown" href="#">
		<span class="caret white"></span>
	</a>
	<ul class="m-dropdown-menu">
		<li><a href="members.php?stat=all">Summary</a></li>
		<li><a href="members.php?stat=url">Popular Pages</a></li>
		<li><a href="members.php?stat=href">Popular Links</a></li>
		<li><a href="members.php?stat=domains">Popular Domains</a></li>
		<li class="divider"></li>
		<li><a href="members.php?stat=entry">Entry Pages</a></li>
		<li><a href="members.php?stat=exit">Exit Pages</a></li>
		<li><a href="members.php?stat=referer">Came From</a></li>
		<li class="divider"></li>
		<li><a href="members.php?stat=keywords">Keyword Analysis</a></li>
		<li><a href="members.php?stat=engine">Search Engine Wars</a></li>
		<li><a href="members.php?stat=ipaddress">Visitor Paths/Activity</a></li>
		<li><a href="members.php?stat=online">Online Visitors</a></li>
		<li><a href="members.php?records1=1">Pageload Activity</a></li>
		<li><a href="members.php?records2=1">Click Activity</a></li>
		<li class="divider"></li>
		<li><a href="members.php?stat=countrylanguage">Countries/Languages</a></li>
		<li><a href="members.php?stat=browser">Browser</a></li>
		<li><a href="members.php?stat=operatingsystem">Operating Systems</a></li>
		<li><a href="members.php?stat=screenresolution">Screen Resolutions</a></li>
		<li><a href="members.php?stat=colordepth">Color Depths</a></li>
		<li><a href="members.php?stat=ip">Lookup IP Address</a></li>
		<li class="divider"></li>
		<li><a href="members.php?stat=log">Download Logs</a></li>
	</ul>
</div>

<div class="m-btn-group">
	<a href="edit.php?m=cc" class="m-btn">Create Campaign</a>
	<a href="members.php?stat=campaigns" class="m-btn">Manage Campaigns</a>
</div>

<div class="m-btn-group">
	<a href="edit.php?m=da" class="m-btn red">Delete Account</a>
	<a href="logout.php" class="m-btn red-stripe"><i class="icon-off"></i> Logout</a>
</div>

<div class="clearfix"></div>