<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<h1>TEST DE TOUTES LES PHOTOS !</h1>
	<?php	
	require("../fonction.php");
	$bdd = getBDD();
	
	$images = $bdd->prepare('SELECT * FROM pays_participants');
	$images->execute();

	while ($image = $images->fetch()) {
		echo '<br><img src="'.$image['I_drapeau'].'" class="img-thumbnail border-0" width="40px"> '.($image['nom_pays']);
	}
	
	$pics = $bdd->prepare('SELECT * FROM disciplines');
	$pics->execute();

	while ($pic = $pics->fetch()) {
		echo '<br><img src="'.$pic['pictogramme'].'" class="img-thumbnail border-0" width="40px"> '.($pic['nom_discipline']);
	}
	
	$olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes WHERE villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY n_edition');
	$olympiades->execute();

	while ($olympiade = $olympiades->fetch()) {
		echo '<br><img src="'.$olympiade['logo'].'" class="img-thumbnail border-0" width="40px"> '.$olympiade['nom'].' '.$olympiade['annee_o'];
	}
	?>
</body>
</html>
