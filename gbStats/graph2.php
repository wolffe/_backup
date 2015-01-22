<?php

include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_pie.php");
include ("jpgraph/src/jpgraph_pie3d.php");
include "config.php";

$data = explode(",",$jpdatav2);
$data2 = explode(",",$jplegends2);


foreach ($data as $i) {
	if ($i > $greatest) $greatest = $thiscount;
	$thiscount++; }


// A new pie graph
$graph = new pieGraph($graph_width,$graph_height,"auto");	
# $graph->SetShadow();
$graph->SetMarginColor("$bcolor");

// Title setup
$graph->title->Set("$jptitle $filter");
$graph->title->SetFont(FF_FONT1);

$p1 = new PiePlot3D($data);
$p1->ExplodeSlice($greatest);
$piecolors_array = explode(",",$piecolors);
foreach ($piecolors_array as $i) $newpiecolors_array[] = trim($i);

$p1->SetSliceColors($newpiecolors_array);

# $p1->SetTheme('pastel'); 

$p1->SetCenter(0.33,0.50);
$p1->SetAngle(70);
$p1->SetLegends($data2);


// Setup slice labels and move them into the plot
$p1->value->SetFont(FF_FONT1);
$p1->value->SetColor("#555555");
# $p1->SetLabelPos(0.6);

// Finally add the plot
$graph->Add($p1);

// ... and stroke it
$graph->Stroke();
?>