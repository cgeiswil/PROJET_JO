<?php
// Connexion à votre base de données
require("fonction.php");
$bdd = getBDD();

// Récupération de toutes les olympiades
$result = $bdd->prepare('SELECT * FROM olympiades WHERE latitude != 0');
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