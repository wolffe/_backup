<?php



include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_line.php");
include ("jpgraph/src/jpgraph_error.php");
include ("jpgraph/src/jpgraph_bar.php");
include ("jpgraph/src/jpgraph_iconplot.php");
include ("config.php");

$array1 = explode(",",$jpdata1);
$array2 = explode(",",$jpdata2);
$array3 = explode(",",$jpdata3);
$array4 = explode(",",$jpdata4);
$array5 = explode(",",$jpdata5);


$legends_array = explode(",",$jplegends);


// Create the graph. 
$graph = new Graph($graph_width,$graph_height,"auto");	
$graph->SetScale("textlin");
$graph->img->SetMargin(64,40,28,40);

// Set background color of margin area
$graph->SetMarginColor("$bcolor");

# $graph->SetShadow();

if ($legends_array) {
	$graph->xaxis->SetTickLabels($legends_array);
	$graph->xaxis->SetTextLabelInterval(1); }

$graph->xaxis->SetTickSide(SIDE_OFF);
$graph->yaxis->SetTickSide(SIDE_OFF);

if ($jptitle) {
	$graph->title->Set("$jptitle");
	$graph->title->SetFont(FF_FONT1,FS_BOLD); }



$l1plot=new BarPlot($array1);
$l1plot->SetWeight(.5);
$l1plot->SetWidth(.4);
$l1plot->SetFillGradient("$colo1@0.3","$colo2@0.3",GRAD_HOR);
if (!$novalues) $l1plot->value->Show();
$l1plot->value->SetAngle(90);
$l1plot->value->SetFormat('%d');
$l1plot->value->SetFont(FF_FONT0);
if($jpl1) $l1plot->SetLegend("$jpl1");

$l2plot = new BarPlot($array2);
$l2plot->SetWeight(.5);
$l2plot->SetWidth(.4);
$l2plot->SetFillGradient("$colo3@0.3","$colo4@0.3",GRAD_HOR);
if (!$novalues) $l2plot->value->Show();
$l2plot->value->SetAngle(90);
$l2plot->value->SetFormat('%d');
$l2plot->value->SetFont(FF_FONT0);
if($jpl2) $l2plot->SetLegend("$jpl2");

$l4plot = new BarPlot($array4);
$l4plot->SetWeight(.5);
$l4plot->SetWidth(.4);
$l4plot->SetFillGradient("$colo1a@0.3","$colo1b@0.3",GRAD_HOR);
if (!$novalues) $l4plot->value->Show();
$l4plot->value->SetAngle(90);
$l4plot->value->SetFormat('%d');
$l4plot->value->SetFont(FF_FONT0);
if($jpl4) $l4plot->SetLegend("$jpl4");

$l5plot = new BarPlot($array5);
$l5plot->SetWeight(.5);
$l5plot->SetWidth(.4);
$l5plot->SetFillGradient("$colo2a@0.3","$colo2b@0.3",GRAD_HOR);
if (!$novalues) $l5plot->value->Show();
$l5plot->value->SetAngle(90);
$l5plot->value->SetFormat('%d');
$l5plot->value->SetFont(FF_FONT0);
if($jpl5) $l5plot->SetLegend("$jpl5");



$finalplot = array();
if ($jpdata1) $finalplot[]  = $l1plot;
if ($jpdata2) $finalplot[]  = $l2plot;
if ($jpdata3) $finalplot[]  = $l3plot;
if ($jpdata4) $finalplot[]  = $l4plot;
if ($jpdata5) $finalplot[]  = $l5plot;

$gbplot = new GroupBarPlot($finalplot);

# $gbplot->SetAbsWidth(30);
$graph->Add($gbplot);


# $graph->xaxis->title->Set("Website Stats Counter");
# $graph->yaxis->title->Set("$yaxis");

$graph->title->SetFont(FF_FONT1);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->scale->SetGrace(20);
$graph->legend->Pos(0.5,0.01,"center" ,"top");
$graph->legend->SetLayout(LEGEND_HOR);

# $icon = new IconPlot('images/logo.jpg',220,80,1,15);
# $icon->SetAnchor('center','center');
# $graph->Add($icon);



// Display the graph
$graph->Stroke();


?>