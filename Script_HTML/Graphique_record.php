<?php
session_start();
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_log.php');
require_once ('./src/jpgraph_line.php');

$record = $_SESSION['records'];
$minimum1 = min($record) - 1;
$maximum1 = max($record) + 1;
$epreuve = $_SESSION['epreuve'];
$unite = $_SESSION['unite'];

// Convertir les données en chaînes de caractères séparées par des virgules
$ydata_str = $_SESSION['records'];
$datax = $_SESSION['annee'];

// Convertir les chaînes de caractères en entiers
$ydata = array_map('intval', $ydata_str);

// Create the graph. These two calls are always required
$graph = new Graph(500,400);
$graph->clearTheme();
$graph->SetScale('lin', $minimum1, $maximum1); // Définit l'échelle de 5 à 13

$graph->img->SetMargin(80,80,50,80);
$graph->SetShadow();

$graph->ygrid->Show(true,true);
$graph->xgrid->Show(true,false);

// Set the labels for X-axis
$graph->xaxis->SetTickLabels($datax);

// Create the linear plot
$lineplot=new LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

$graph->title->Set("Evolution des records depuis 1896 en :\n '$epreuve' ");
$graph->xaxis->title->Set("Annee");
$graph->yaxis->title->Set($unite);

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$lineplot->SetColor("blue");
$lineplot->SetWeight(2);

$graph->yaxis->SetColor("blue");

$lineplot->SetLegend("Record");

$graph->legend->Pos(0.05,0.5,"right","center");

// Position the X-axis title
$graph->xaxis->SetTitleMargin(10);
$graph->xaxis->title->SetMargin(10);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Position the Y-axis title
$graph->yaxis->SetTitleMargin(10);
$graph->yaxis->title->SetMargin(50);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetTitleSide(SIDE_LEFT);

// Display the graph
$graph->Stroke();


?>


