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
$array6 = explode(",",$jpdata6);


$legends_array = explode(",",$jplegends);


// Create the graph. 
$graph = new Graph($graph_width,$graph_height,"auto");	
$graph->SetScale("textlin");
$graph->img->SetMargin(68,40,20,40);

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
$l1plot->SetWidth(.5);
if (!$alert) $l1plot->SetFillGradient("$colo5@0.3","$colo6@0.3",GRAD_HOR);
if ($alert) $l1plot->SetFillGradient("$colo55@0.3","$colo66@0.3",GRAD_HOR);
if($jpl2) $l1plot->SetLegend("$jpl1");

$l2plot = new BarPlot($array2);
$l2plot->SetWeight(.5);
$l2plot->SetWidth(.5);
$l2plot->SetFillGradient("$colo7@0.3","$colo8@0.3",GRAD_HOR);
if($jpl1) $l2plot->SetLegend("$jpl2");

$l3plot = new BarPlot($array3);
$l3plot->SetWeight(.5);
$l3plot->SetWidth(.5);
$l3plot->SetFillGradient("$colo9@0.3","$colo10@0.3",GRAD_HOR);
if($jpl3) $l3plot->SetLegend("$jpl3");

$l4plot = new BarPlot($array4);
$l4plot->SetWeight(.5);
$l4plot->SetWidth(.5);
$l4plot->SetFillGradient("$colo11@0.3","$colo12@0.3",GRAD_HOR);
if($jpl4) $l4plot->SetLegend("$jpl4");


$l5plot = new BarPlot($array5);
$l5plot->SetWeight(.5);
$l5plot->SetWidth(.5);
$l5plot->SetFillGradient("$colo13@0.3","$colo14@0.3",GRAD_HOR);
if($jpl5) $l5plot->SetLegend("$jpl5");


$l6plot = new BarPlot($array6);
$l6plot->SetWeight(.5);
$l6plot->SetWidth(.5);
$l6plot->SetFillGradient("$colo15@0.3","$colo16@0.3",GRAD_HOR);
if($jpl6) $l6plot->SetLegend("$jpl6");


// Add the plots to the graph
$graph->Add($l1plot);
$graph->Add($l2plot);
$graph->Add($l3plot);
$graph->Add($l4plot);
$graph->Add($l5plot);
$graph->Add($l6plot);


$graph->xaxis->title->Set("$filter");
# $graph->yaxis->title->Set("$yaxis");

$graph->title->SetFont(FF_FONT1);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);


# $icon = new IconPlot('images/logo.jpg',220,80,1,15);
# $icon->SetAnchor('center','center');
# $graph->Add($icon);



// Display the graph
$graph->Stroke();


?>