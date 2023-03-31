<?php
require_once('./src/jpgraph.php');
require_once('./src/jpgraph_line.php');
require("fonction.php");

$bd = getBDD();

$req = $bd->query("select olympiades.annee_o, olympiades.coût
                    from olympiades
                    where olympiades.annee_o in ('1992', '1994', '1996', '1998', '2000', '2002', '2004', '2006', '2008', '2010', '2012', '2014', '2016', '2018', '2020')
                    and olympiades.saison = 'Summer'; ");

$donnees = $req->fetchAll();

$axeX = array();
$axeY = array();
foreach ($donnees as $element) {
    array_push($axeX, intval(($element['annee_o'])));
    array_push($axeY, floatval($element['coût']));
}

// Création d'un graphique de taille 600x400 pixels
$graph = new Graph(600, 400);

// Définition de l'échelle des axes X et Y
$graph->SetScale('lin');

// Création de la courbe
$lineplot = new LinePlot($axeY, $axeX);

// Ajout de la courbe au graphique
$graph->Add($lineplot);

// Configuration de l'apparence de la courbe
$lineplot->SetColor('blue');
$lineplot->SetWeight(2);

// Configuration de l'apparence de l'axe X
$graph->xaxis->SetTickLabels($axeX);
$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);

// Configuration de l'apparence de l'axe Y
$graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 10);

// Ajout du titre
$graph->title->Set('Évolution du coût des jeux olympiques.');

// Rendu du graphique en mémoire tampon

$graph->Stroke();


?>




