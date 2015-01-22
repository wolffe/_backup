<div id="sidebar">
	<h2>Categories</h2>
	<ul class="subnav">
		<?php
		$result = mysql_query("SELECT * FROM categories ORDER BY id");
		while($row = mysql_fetch_array($result)) {
			$result1 = mysql_query("SELECT * FROM data WHERE category='".$row[1]."' AND approved=1",$database);
			$numres = mysql_num_rows($result1);
			echo '<li><a href="detail-category.php?category='.urlencode($row['category']).'">'.$row['category'].' <strong>('.$numres.')</strong></a></li>';
		}
		?>
	</ul>
</div>

<div id="sidebarright">
	<h2>Calculator</h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div>Sale price (<?php echo CURRENCY;?>)<br /><input type="text" name="mcPrice" id="mcPrice" class="mortgageField" /></div>
		<div>Down payment (%)<br /><input type="text" name="mcDown" id="mcDown" class="mortgageField" /></div>
		<div>Interest Rate (%)<br /><input type="text" name="mcRate" id="mcRate" class="mortgageField" /></div>
		<div>Term/Duration (years)<br /><input type="text" name="mcTerm" id="mcTerm" class="mortgageField" /></div>
		<p>
			<input type="submit" id="mortgageCalc" onclick="return false" value="Calculate"> 
			<input type="text" name="mcPayment" id="mcPayment" class="mortgageAnswer" size="8" /> <?php echo CURRENCY; ?>/month
		</p>
	</form>
	<ul class="subnav">
		<li><a href="calculator-mortgage.php"><small>Advanced Mortgage Calculator</small></a></li>
	</ul>
</div>
