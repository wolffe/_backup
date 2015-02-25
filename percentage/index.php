<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Percentage Calculator</title>

</head>

<body>

<h1>Percentage Calculator</h1>

<p>Sometimes called the <a href="http://en.wikipedia.org/wiki/Rule_of_three_(mathematics)#Rule_of_Three" rel="external">rule of three</a>, this is how you calculate the percentage of a number from another number.</p>
<p>For example, you have 2 numbers, 34 and 116. Let’s say 116 is the total number (100%), and we want to find out what percentage is 34 out of 100%.</p>

<hr>

<form method="post" action="">
    <p>
        <input type="number" name="pmax" id="pmax"> <label for="pmax">Percentage total (maximum value)</label>
    </p>
    <p>
        <input type="number" name="pvalue" id="pvalue"> <label for="pvalue">Value to calculate (percentage value)</label>
    </p>
    <p>
        <input type="submit" name="psubmit" value="Calculate"> <label>Click to calculate</label>
    </p>
</form>
<?php
function percentage($amount, $total, $decimal = 2) {
	if(0 === (int)$total) {
		return $total;
	}
	return number_format((((int)$amount / (int)$total) * 100), $decimal);
}

if(isset($_POST['psubmit'])) {
    $pmax = $_POST['pmax'];
    $pvalue = $_POST['pvalue'];

    echo '<hr>';
    echo '<p>You calculated the percentage of <strong>' . $pvalue . '</strong> from a total of <strong>' . $pmax . '</strong></p>';
    echo '<h3>Result is ' . percentage($pvalue, $pmax) . '%</h3>';
}
?>

</body>
</html>