<div class="wrap">
	<h2>
		<?php
		$pagename = $_GET['page'];
		if($pagename == 'cinnamon_forum_category') {
			echo "Categories";
			echo ' <a href="?page=cinnamon_forum_category&action=add" class="add-new-h2">Add New</a>';
		}
		else if($pagename == 'cinnamon_forum_forums') {
			echo 'Forums';
			echo ' <a href="?page=cinnamon_forum_forums&action=add" class="add-new-h2">Add New</a>';
		}
		else if($pagename == 'cinnamon_forum_threads') {
			echo 'Topics';
			echo ' <a href="?page=cinnamon_forum_threads&action=add" class="add-new-h2">Add New</a>';
		}
		else if($pagename == 'cinnamon_forum_tools') {
			echo 'Cinnamon Tools';
		}
		else if($pagename == 'cinnamon_forum_help') {
			echo 'Cinnamon Help Topics';
		}
		else {
			echo 'Cinnamon Boards';
		}
		?>
	</h2>

	<?php
	$active_tab = isset($_GET['page']) ? $_GET['page'] : 'cinnamon_forum';
	if(isset($_GET['page']))
		$active_tab = $_GET['page'];
	?>

	<h2 class="nav-tab-wrapper">
		<a href="admin.php?page=cinnamon_forum" class="nav-tab <?php echo $active_tab === 'cinnamon_forum' ? 'nav-tab-active' : ''; ?>">Forum dashboard</a>
		<a href="admin.php?page=cinnamon_forum_category&action=add" class="nav-tab <?php echo $active_tab === 'cinnamon_forum_category' ? 'nav-tab-active' : ''; ?>">Add new category</a>
		<a href="admin.php?page=cinnamon_forum_forums&action=add" class="nav-tab <?php echo $active_tab === 'cinnamon_forum_forums' ? 'nav-tab-active' : ''; ?>">Add new forum</a>
		<a href="admin.php?page=cinnamon_forum_threads&action=add" class="nav-tab <?php echo $active_tab === 'cinnamon_forum_threads' ? 'nav-tab-active' : ''; ?>">Add new topic</a>
		<a href="admin.php?page=cinnamon_forum_tools" class="nav-tab <?php echo $active_tab === 'cinnamon_forum_tools' ? 'nav-tab-active' : ''; ?>">Forum tools</a>
		<a href="admin.php?page=cinnamon_forum_help" class="nav-tab <?php echo $active_tab === 'cinnamon_forum_help' ? 'nav-tab-active' : ''; ?>">Help</a>
	</h2>

	<div id="poststuff">
		<div id="post-body">
			<div id="post-body-content">
				<?php
				if(!empty($_GET)) {
					if(isset($_GET['page'])) {
						$page = $_GET['page'];
						require_once(CINNAMON_PLUGIN_PATH . '/adminRender/cinnamon-forum/' . $page . '.php');
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
