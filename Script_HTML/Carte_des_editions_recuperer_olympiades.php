<?php
// Connexion à votre base de données
require("fonction.php");
$bdd = getBDD();

// Récupération de toutes les olympiades
$result = $bdd->prepare('SELECT * FROM olympiades, villes_hotes WHERE villes_hotes.latitude != 0 AND villes_hotes.id_ville = olympiades.id_ville_hote');
$result->execute();

// Stockage des données dans un tableau
$olympiades = array();
if ($result->rowCount() > 0) {
  while ($row = $result->fetch()) {
    $olympiades[] = $row;
  }
}

// Fermeture de la connexion à la base de données
$bdd = null;

// Envoi des données sous forme de JSON
echo json_encode($olympiades);
?>