<?php
$downpayment = $downpayment_percent / 100 * $loan;
$downpayment = number_format($downpayment, 2, '.', '');
$interest_rate = number_format($interest_rate, 2, '.', '');

$loan = (1-$downpayment_percent/100)*$loan;
$loan = number_format($loan, 2, '.', '');

$periodic_payment = ($loan*$interest_rate/100)/($periodicity*(1-pow(1+($interest_rate/100)/$periodicity, -$year*$periodicity)));
$total_paid = $periodic_payment * $year * $periodicity;
$total_interest = $total_paid - $loan;

$amount_left = $loan;
$year_interest = $year_principal = 0;
$periodic_interest = array();
$periodic_principal = array();
$balance = array();
$yinterest = array();
$yprincipal = array();
$j = 0;

for($i=0; $i<$year*$periodicity; $i++) {
	$periodic_interest[$i] = $amount_left * ($interest_rate/100) / $periodicity;
	$periodic_principal[$i] = $periodic_payment - $periodic_interest[$i];
	$amount_left -= $periodic_principal[$i];
	$balance[$i] = $amount_left;

	$year_interest += $periodic_interest[$i];
	$year_principal += $periodic_principal[$i];

	$periodic_interest[$i] = number_format($periodic_interest[$i], 2, '.', '');
	$periodic_principal[$i] = number_format($periodic_principal[$i], 2, '.', '');
	$amount_left = $amount_left < 0 ? 0 : $amount_left;
	$balance[$i]= number_format($amount_left, 2, '.', '');

	if(!(($i+1) % $periodicity)) {
		$yinterest[$j] = number_format($year_interest, 2, '.', '');
		$yprincipal[$j] = number_format($year_principal, 2, '.', '');
		$j++;
		$year_interest = $year_principal = 0;
	}
}
$periodic_payment = number_format($periodic_payment, 2, '.', '');
$total_paid = number_format($total_paid, 2, '.', '');
$total_interest = number_format($total_interest, 2, '.', '');
?>
