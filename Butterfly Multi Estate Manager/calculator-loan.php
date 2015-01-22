<?php
$year = $_GET['year'];
$downpayment_percent = $_GET['downpayment_percent'];
$loan = $_GET['loan'];
$interest_rate = $_GET['interest_rate'];
			if(isset($_GET['amortization']))
				$amortization = $_GET['amortization'];

	$ptext = periodicity_text($_GET['periodicity']);

	// Show form only if there is no action
	if ($action!="Calculate") {
		print "<form>\n";
		print "<table cellpadding=2 width=100% border=1>\n";
		print "<tr align=center><td colspan=2><b>Loan Information</b></td></tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Loan amount</td>\n";
		print "<td class=finput><input type=text name=loan size=7></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Length of loan, years</td>\n";
		print "<td class=finput><input type=text name=year size=7></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Annual interest rate, %</td>\n";
		print "<td class=finput><input type=text name=interest_rate size=4></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Pay periodicity</td>\n";
		print "<td class=finput>\n";
		print "<select name=periodicity>\n";
		print "<option value=52>Weekly</option>\n";
		print "<option value=26>Bi-weekly</option>\n";
		print "<option value=12>Monthly</option>\n";
		print "<option value=6>Bi-monthly</option>\n";
		print "<option value=4>Quaterly</option>\n";
		print "<option value=2>Semi-annually</option>\n";
		print "<option value=1>Annual</option>\n";
		print "</td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Currency</td>\n";
		print "<td >\n";
		print "<select name=currency>\n";
		print "<option value=$>$</option>\n";
		print "<option value=&euro;>&euro;</option>\n";
		print "<option value=&pound;>&pound;</option>\n";
		print "</td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td class=flabel>Show amortization</td>\n";
		print "<td class=finput><input type=checkbox name=amortization></td>\n";
		print "</tr>\n";

		print "<tr><td colspan=2 align=center><input type=submit value=Calculate name=action></td></tr>\n";
		print "</table>\n";
		print "</form>\n";

	}

			include('includes/formulas.php');
?>

<html>
<head>
<link href="loan.css" rel="stylesheet" type="text/css" />
</head>
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr>
	<td colspan=2 class=header>Mortgage Payment Report</td>
</tr>
<tr class=top>
	<td align="right">Loan amount:</td>
	<td><b>
	<? print CURRENCY.$loan; ?>
	</b></td>
</tr>
<tr class=top>
	<td align="right">Length:</td>
	<td><b>
	<? print "$year years"; ?>
	</b></td>
</tr>
<tr class=top>
	<td align="right">Annual interest:</td>
	<td><b>
	<? print $interest_rate; ?> %
	</b></td>
</tr>
<tr class=top>
	<td align="right">Pay Periodicity:</td>
	<td><b>
	<? print $ptext; ?>
	</b></td>
</tr>
<tr class=toptotal>
	<td align="right"><? print "$ptext Payment:"; ?></td>
	<td><b>
	<? print CURRENCY.$periodic_payment; ?>
	</b><br>(excluding tax and insurance)</td>
</tr>
</table>


<table cellpadding="5" cellspacing="0" border="1" width="100%">
<tr class=total1>
	<td colspan="4">Totals</td>
</tr>
<tr class=total2>
	<td>&nbsp;</td>
	<td colspan="3">
		You will spend <? print CURRENCY.$total_paid; ?> on your loan<br>
		<? print CURRENCY.$total_interest; ?> will go towards INTEREST<br>
		<? print CURRENCY.$loan; ?> will go towards PRINCIPAL<br>
	</td>
</tr>


	<?php if(isset($_GET['amortization'])) {?>

<tr class=aheader>
	<td colspan="4">Amortization</td>
</tr>
<tr class=aheader align=right>
	<td>Month</td>
	<td>Interest Paid</td>
	<td>Principal Paid</td>
	<td>Remaining Balance</td>
</tr>

<?
	$yr = 0;

	for ($i=0; $i<$year*$periodicity; $i++) {
		print "<tr class=acontent>\n";
		print "<td>".(($i%$periodicity)+1)."</td>\n";
		print "<td>".CURRENCY."$periodic_interest[$i]</td>\n";
		print "<td>".CURRENCY."$periodic_principal[$i]</td>\n";
		print "<td>".CURRENCY."$balance[$i]</td>\n";
		print "</tr>\n";

		if (!(($i+1) % $periodicity)) {
			$ytotal = $yinterest[$yr] + $yprincipal[$yr];

			print "<tr class=total1>\n";
			print "<td colspan=4>Totals for year ".($yr+1)."</td>\n";
			print "</tr>\n";
			print "<tr class=total2>\n";
			print "<td>&nbsp;</td>\n";
			print "<td colspan=3>\n";
			print "You will spend ".CURRENCY."$ytotal on your loan in year ".($yr+1)."<br>\n";
			print "".CURRENCY."$yinterest[$yr] will go towards INTEREST<br>\n";
			print "".CURRENCY."$yprincipal[$yr] will go towards PRINCIPAL<br>\n";
			print "</td>\n";
			print "</tr>\n";

			if ($yr != $year-1) {
				print "<tr class=aheader align=right>\n";
				print "<td>Month</td>\n";
				print "<td>Interest Paid</td>\n";
				print "<td>Principal Paid</td>\n";
				print "<td>Remaining Balance</td>\n";
				print "</tr>\n";
			}

			$yr++;
		}
	}
	}
	function periodicity_text ($periodicity)
	{
		switch ($periodicity) {
			case 1:
				$ptext = "Annual";
				break;
			case 2:
				$ptext = "Semi-annually";
				break;
			case 4:
				$ptext = "Quaterly";
				break;
			case 6:
				$ptext = "Bi-monthly";
				break;
			case 12:
				$ptext = "Monthly";
				break;
			case 26:
				$ptext = "Bi-weekly";
				break;
			case 52:
				$ptext = "Weekly";
				break;
		}
		return $ptext;
	}
?>

