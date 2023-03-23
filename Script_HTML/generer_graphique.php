<?php
$score = array();
while ($ligne = $resultat->fetch()) {
  $score[] = $ligne['score'];
}

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');

// Some data
$ydata = $score;

// Create the graph. These two calls are always required
$graph = new Graph(500,500);
$graph->SetScale('lin', 0, 10); // Définit l'échelle de 5 à 13

// Create the linear plot
$lineplot=new LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Définir le type de contenu de la réponse
header("Content-type: image/png");

// Display the graph
$graph->Stroke();
?>
