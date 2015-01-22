<?php include('includes/top.php');?>
<div id="content">
	<?php
	if(is_authed()) {
		echo '<h2>Mortgage Calculator</h2>';
		?>

		<p>The mortgage calculator is used to help a current or potential real estate owner determine how much they can afford to borrow on a piece of real estate.</p>
		<p>It can also be used to compare the costs, interest rates, payment schedules, or help determine the change in the length of the mortgage loan by making added principal payments.</p>

		<h3>Mortgage Information</h3>
		<form method="get">
			<table class="report">
				<tr>
					<td class="flabel">Sale price of home</td>
					<td class="finput"><input type="text" name="loan" size="12" /></td>
				</tr>
				<tr>
					<td class="flabel">Percentage down</td>
					<td class="finput"><input type="text" name="downpayment_percent" size="12" /> %</td>
				</tr>
				<tr>
					<td class="flabel">Length of mortgage</td>
					<td class="finput"><input type="text" name="year" size="12" /> years</td>
				</tr>
				<tr>
					<td class="flabel">Interest rate</td>
					<td class="finput"><input type="text" name="interest_rate" size="4" /> %</td>
				</tr>
				<tr>
					<td class="flabel">Show amortization</td>
					<td class="finput"><input type="checkbox" name="amortization" /></td>
				</tr>
				<tr><td colspan="2" align="center"><input type="hidden" name="periodicity" value="12" /><input type="submit" value="Calculate" name="action" /></td></tr>
			</table>
		</form>

		<?php
		if(isset($_GET['action'])) {
			$year 					= $_GET['year'];
			$downpayment_percent 	= $_GET['downpayment_percent'];
			$loan 					= $_GET['loan'];
			$interest_rate 			= $_GET['interest_rate'];
			$periodicity 			= $_GET['periodicity'];
			if(isset($_GET['amortization']))
				$amortization = $_GET['amortization'];

			include('includes/formulas.php');
		?>

<table class="report">
	<tr>
		<td colspan="2" class="header">Mortgage Payment Report</td>
	</tr>
	<tr>
		<td align="right" width="50%">Down Payment:</td>
		<td width="50%"><strong><?php echo CURRENCY.$downpayment;?></strong></td>
	</tr>
	<tr>
		<td align="right">Amount Financed:</td>
		<td><strong><?php echo CURRENCY.$loan;?></strong></td>
	</tr>
	<tr>
		<td align="right">Length:</td>
		<td><strong><?php echo $year.' years';?></strong></td>
	</tr>
	<tr>
		<td align="right">Annual interest:</td>
		<td><strong><?php echo $interest_rate;?>%</strong></td>
	</tr>
	<tr class="toptotal">
		<td colspan="2">Monthly Payment: <strong><?php echo CURRENCY.$periodic_payment;?></strong> <small>(excluding tax and insurance)</small></td>
	</tr>
</table>

<table cellspacing="1" class="report">
	<tr class="total1">
		<td colspan="4">Totals</td>
	</tr>
	<tr class="total2">
		<td>&nbsp;</td>
		<td colspan="3">
			You will spend <?php echo CURRENCY.$total_paid;?> on your property<br />
			<?php echo CURRENCY.$total_interest;?> will go towards INTEREST<br />
			<?php echo CURRENCY.$loan;?> will go towards PRINCIPAL
		</td>
	</tr>

	<?php if(isset($_GET['amortization'])) {?>
		<tr class="aheader">
			<td colspan="4">Amortization</td>
		</tr>
		<tr class="aheader" align="right">
			<td>Month</td>
			<td>Interest Paid</td>
			<td>Principal Paid</td>
			<td>Remaining Balance</td>
		</tr>

		<?php
		$yr = 0;
		for($i=0; $i<$year*12; $i++) {
			echo '<tr class="acontent">';
			echo '<td>'.(($i%12)+1).'</td>';
			echo '<td>'.CURRENCY.$periodic_interest[$i].'</td>';
			echo '<td>'.CURRENCY.$periodic_principal[$i].'</td>';
			echo '<td>'.CURRENCY.$balance[$i].'</td>';
			echo '</tr>';

			if($i%12 == 11) {
				$ytotal = $yinterest[$yr] + $yprincipal[$yr];

				echo '<tr class="total1">';
				echo '<td colspan="4">Totals for year '.($yr+1).'</td>';
				echo '</tr>';
				echo '<tr class="total2">';
				echo '<td>&nbsp;</td>';
				echo '<td colspan="3">';
				echo 'You will spend '.CURRENCY.$ytotal.' on your property in year '.($yr+1).'<br />';
				echo CURRENCY.$yinterest[$yr].' will go towards INTEREST<br />';
				echo CURRENCY.$yprincipal[$yr].' will go towards PRINCIPAL<br />';
				echo '</td>';
				echo '</tr>';

				if ($yr != $year-1) {
					echo '<tr class="aheader" align="right">';
					echo '<td>Month</td>';
					echo '<td>Interest Paid</td>';
					echo '<td>Principal Paid</td>';
					echo '<td>Remaining Balance</td>';
					echo '</tr>';
				}
				$yr++;
			}
		}
	}
	?>
</table>
<?php }?>
<?php }
	else restrictedAccess();
?>
</div>
<?php include('includes/bottom.php');?>
