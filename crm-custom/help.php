<?php include('includes/header.php');?>

<?php if(is_authed()) {?>
	<div class="table-wrap-wide">
		<h2><?php echo $lang['HELP'];?></h2>

		<div style="float: right; width: 300px; margin-left: 16px; border: 1px solid #CCCCCC; border-radius: 12px; padding: 16px">
			<p>
				<strong>Table of contents</strong>
				<br /><small>Click on an item to be redirected to the corresponding section below</small>
			</p>
			<ul>
				<li><a href="#1">What is tasks stream?</a></li>
				<li><a href="#2">What is contracts stream?</a></li>
				<li><a href="#3">Dashboard items</a></li>
				<li><a href="#4">Adding/editing CVs</a></li>
				<li><a href="#5">Searching and reports</a></li>
				<li><a href="#6">CV custom fields</a></li>
				<li><a href="#7">Settings: Managing users</a></li>
				<li><a href="#8">Settings: General options</a></li>
			</ul>
		</div>

		<h3><a name="1"></a>What is tasks stream?</h3>
		<p>Tasks stream is a feed of manually added tasks, featuring TODO tasks, important tasks and other tasks. As they approach a deadline, they appear both on dashboard area and in the top notification bar. The tasks are colour-coded, and appear on dashboard, only if active in the next 30 days. A list of all tasks appears in the <strong>Diary</strong> section of CRM.</p>
		<p>Adding new tasks, or reminders, is as easy as accessing the <strong>Diary</strong> page and adding a new item. A candidate drop-down is also available, for cases when a task is linked to a candidate.</p>
		<p>Tasks can be marked as done by clicking on the icon in the bottom right corner of their container box. If a task is overdue, it will be marked accordingly.</p>

		<h3><a name="2"></a>What is contracts stream?</h3>
		<p>Contracts stream is a list of all upcoming contract notifications. When a candidate's contract ends soon (in the next 30 days), a colour-coded notification appears on dashboard.</p>
		<p>A candidate's contract end date can be set up using the <strong>Contract Duration / End Date</strong> date picker.</p>

		<h3><a name="3"></a>Dashboard items</h3>
		<p>The dashboard also features a user activity box, displaying latest access information and user data, and also a candidate activity stream, showing recent candidate placings, along with date and comments.</p>

		<h3><a name="4"></a>Adding/editing CVs</h3>
		<p>Adding CVs is done by filling in the special form, and using as many fields as possible. All fields are optional. Date pickers are marked with a calendar icon and accept only dates.</p>
		<p>Viewing a CV displays the edit form, where, if desired, modifications can be done. Wherever a candidate name or ID appears, a link to the View/Edit form is available.</p>

		<h3><a name="5"></a>Searching and reports</h3>
		<p>Searching candidates can be done using multiple criteria and parameters, either single or combined. A list of results is then displayed, with links to each candidate found.</p>
		<p>If a report is desired, it is available in DOC or XLS form, and is highly dependent on the user's Microsoft Office version installed locally.</p>

		<h3><a name="6"></a>CV custom fields</h3>
		<p>Custom fields are various option available in CV form's drop-downs. They are available for editing in the secondary menu, below the primary navigation. Options can be added, modified or deleted.</p>

		<h3><a name="7"></a>Settings: Managing users</h3>
		<p>A special <strong>Users</strong> panel is available, displaying a list of all users with their respective email address. New users can be added or deleted. It is recommended that a user is deleted and recreated with a new password every 3 months.</p>

		<h3><a name="8"></a>Settings: General options</h3>
		<p>The Options <strong>panel</strong> currently holds the database backup options and available backups. The buttons are self-explanatory. A user will receive the database backup by email, if he/she filled in the email address. ZIP backups for CVs and photos may take a while if there are lots of profiles.</p>

		<p><em>&quot;CV stands for curriculum vitae (Latin for &quot;course of life&quot;), a summary of academic and professional history and achievements.&quot;</em></p>
		<p><em>&quot;A curriculum vitae (CV, also spelled curriculum vit&aelig;) provides an overview of a person's life and qualifications. In some countries, a CV is typically the first item that a potential employer encounters regarding the job seeker and is typically used to screen applicants, often followed by an interview, when seeking employment.&quot;</em></p>
	</div>
<?php }?>
<?php include('includes/footer.php');?>
