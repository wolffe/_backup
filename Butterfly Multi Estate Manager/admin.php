<?php include('includes/top.php');?>
<div id="content">
	<?php if(is_authed()) {?>
		<h2>My Properties</h2>
		<?php
		$currentuser = $_SESSION['username'];

		// print tables
		echo '<p>Select a category to view your existing properties.</p>';
		echo '<ul>';
		$result = mysql_query("SELECT * FROM categories");
		while($row = mysql_fetch_array($result)) {
			$result1 = mysql_query("SELECT * FROM data WHERE category='".$row['category']."' AND user='".$currentuser."'");
			$numres = mysql_num_rows($result1);
			if($numres > 0)
				echo '<li><a href="viewdb2.php?category='.$row['category'].'">'.$row['category'].' <strong>('.$numres.')</strong></a></li>';
		}
		echo '</ul>';
		echo '<p>&raquo; <a href="addedit.php">Add new property</a></p>';
	}
	else restrictedAccess();
	?>
</div>
<?php include('includes/bottom.php');?>
