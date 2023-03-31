<?php
session_start();
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_bar.php');

// Vérifier si les variables $_SESSION existent et sont non vides
if (isset($_SESSION['difficulte']) && isset($_SESSION['moyenne_score']) &&
    !empty($_SESSION['difficulte']) && !empty($_SESSION['moyenne_score'])) {

    // Les variables existent et sont non vides
    $difficulte = $_SESSION['difficulte'];
    $databary=$_SESSION['moyenne_score'];

    // New graph with a drop shadow
    $graph = new Graph(400,300,'auto');
    $graph->clearTheme();
    $graph->SetShadow();

    // Use a "text" X-scale
    $graph->SetScale("textlin",0,10);

    // Specify X-labels
    $graph->xaxis->SetTickLabels($difficulte);

    // Set title and subtitle
    $graph->title->Set("Moyenne des quiz !");

    // Use built in font
    $graph->title->SetFont(FF_FONT1,FS_BOLD);

    // Create the bar plot
    $b1 = new BarPlot($databary);

    $b1->SetShadow();

    // The order the plots are added determines who's ontop
    $graph->Add($b1);

    // Finally output the  image
    $graph->Stroke();
} else {
    // Les variables n'existent pas ou sont vides
    echo "Veuillez faire les quiz pour afficher les graphiques.";
}
?>
