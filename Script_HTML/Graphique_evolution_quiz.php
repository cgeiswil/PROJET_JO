<?php // content="text/plain; charset=utf-8"
session_start();
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_line.php');

if((isset($_SESSION['facile']) && !empty($_SESSION['facile'])) ||
   (isset($_SESSION['moyen']) && !empty($_SESSION['moyen'])) ||
   (isset($_SESSION['difficile']) && !empty($_SESSION['difficile']))) {


$facile = $_SESSION['facile'];
$moyen = $_SESSION['moyen'];
$difficile = $_SESSION['difficile'];


$datay1 = $facile;
$datay2 = $moyen;
$datay3 = 	$difficile;

// Create the graph. These two calls are always required
$graph = new Graph(400,300);
$graph->clearTheme();
$graph->SetScale("intlin",0,10);
$graph->SetShadow();
$graph->img->SetMargin(40,30,20,40);

// Create the linear plots for each category
$dplot1 = new LinePLot($datay1);
$dplot1->SetColor('green');
$dplot1->SetWeight('5');
$dplot1->SetLegend('Facile');
$dplot2 = new LinePLot($datay2);
$dplot2->SetColor('orange');
$dplot2->SetWeight('5');
$dplot2->SetLegend('Moyen');
$dplot3 = new LinePLot($datay3);
$dplot3->SetColor('red');
$dplot3->SetWeight('5');
$dplot3->SetLegend('Difficile');


// Add the plot to the graph
$graph->Add($dplot1);
$graph->Add($dplot2);
$graph->Add($dplot3);

$graph->xaxis->SetTextTickInterval(2);
$graph->title->Set("Evolution des resultats de vos quiz");
$graph->yaxis->title->Set("Score");
$graph->xaxis->title->Set("Nombre de quiz");

$graph->title->SetFont(FF_FONT1,FS_BOLD);



// Display the graph
$graph->Stroke();
} else {
    // Les variables n'existent pas ou sont vides
    echo "Veuillez faire les quiz pour afficher les graphiques.";
}
?>
