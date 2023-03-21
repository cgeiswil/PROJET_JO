<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_log.php');
require_once ('jpgraph/jpgraph_line.php');
set_include_path(get_include_path().PATH_SEPARATOR.
                 dirname(__FILE__)."/jpgraph/");

require("fonction.php");
$bdd = getBDD();
// Vérifier si le formulaire a été soumis
$discipline = $_POST['discipline'];

// Requête SQL avec une variable préparée
$sql = "SELECT `record olympique` AS records, olympiades.annee_o AS annee, records.unite AS unite FROM records, lier_r, epreuves, olympiades
WHERE records.id_record=lier_r.id_record AND lier_r.id_epreuve=epreuves.id_epreuves AND lier_r.id_olympiade=olympiades.id_olympiade
AND epreuves.epreuves='$discipline' ORDER BY annee ASC, records ASC";
$requete = $bdd->query($sql);
$requete->execute();

// Stocker les résultats dans des variables
$records = array();
$annee = array();
while ($ligne = $requete->fetch()) {
    $records[] = $ligne['records'];
    $annee[] = $ligne['annee'];
    $unite = $ligne['unite'];
}

$minimum1 = min($records) - 1;
$maximum1 = max($records) + 1;

// Définir le type de contenu de la réponse
header("Content-type: image/png");

if (!empty($records) && !empty($annee)) {
    // Fonction qui ajoute des guillemets autour d'une chaîne de caractères
    function add_quotes($str) {
        return '"' . $str . '"';
    }

    // Convertir les données en chaînes de caractères séparées par des virgules
    $ydata = $records;
    $datax = $annee;
    
    // Create the graph. These two calls are always required
$graph = new Graph(1000,800);
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

$graph->title->Set("Evolution des records depuis 1896 en '$discipline' ");
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
$graph->xaxis->title->SetMargin(30);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Position the Y-axis title
$graph->yaxis->SetTitleMargin(10);
$graph->yaxis->title->SetMargin(30);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetTitleSide(SIDE_LEFT);

// Display the graph
$graph->Stroke();
}
?>


