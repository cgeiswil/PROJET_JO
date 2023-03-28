<!DOCTYPE html>
<html lang="fr">
	<head>
    <title>Les JO Autrement</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">        
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	$(document).ready(function() {
   	 $('.cycle-slideshow').cycle({
      	  fx: 'scrollVert', // effet de transition vertical
      	  speed: 500, // durée de la transition en ms
      	  timeout: 5000 // temps d'affichage de chaque élément en ms
   	 });
	});
	</script>
	</head>
    <body>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<br><br>
	<div class="container">
	
<div class="card-deck">

	<div class="card">
		<div class="card-header"><b>Les olympiades...</b></div>
		  <div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>
			<?php
				require("./fonction.php");
				$bdd = getBDD();
				
				session_start();
				$olympiades_p = "";
				if(isset($_SESSION['utilisateur'])){ 
					$test_olympiades = $bdd->prepare('SELECT * FROM apprecier_o WHERE apprecier_o.id_utilisateur = ? LIMIT 1');
					$test_olympiades->execute([$_SESSION['utilisateur']['utilisateur']]);
					if($test_olympiades->fetch()) {
						$olympiades = $bdd->prepare('SELECT * FROM olympiades, apprecier_o, villes_hotes WHERE  annee_o < 2017 AND apprecier_o.id_olympiade != olympiades.id_olympiade AND apprecier_o.id_utilisateur = ? AND villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY RAND() LIMIT 1');
						$olympiades->execute([$_SESSION['utilisateur']['utilisateur']]);
						
						$olympiades_p = $bdd->prepare('SELECT
    *
FROM
    olympiades,
    apprecier_o,
    villes_hotes,
    apprecier_p,
    pays_participants,
    utilisateurs
WHERE
    utilisateurs.id_utilisateur = apprecier_o.id_utilisateur 
    AND pays_participants.Code_CIO = apprecier_p.Code_CIO 
    AND apprecier_p.id_utilisateur = utilisateurs.id_utilisateur 
    AND annee_o < 2017
    AND apprecier_o.id_olympiade != olympiades.id_olympiade
    AND apprecier_o.id_utilisateur = ?
    AND villes_hotes.id_ville = olympiades.id_ville_hote 
    AND olympiades.Code_CIO = "FRA"
ORDER BY
    RAND()
LIMIT 1');
						$olympiades_p ->execute([$_SESSION['utilisateur']['utilisateur']]);
			
						while ($olympiade_p = $olympiades_p->fetch()) {
							echo '<p><a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><img src="'.$olympiade['logo'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</a></b>'.
							' <abbr title="Vous avez aimé la '.France.', alors pourquoi pas ces olympiades. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr></p>';
						}
					}
					else {
						$olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes WHERE annee_o < 2017 AND villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY RAND() LIMIT 3');
						$olympiades->execute();
					}
				}
				else {
					$olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes WHERE annee_o < 2017 AND villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY RAND() LIMIT 3');
					$olympiades->execute();
				}

				while ($olympiade = $olympiades->fetch()) {
					echo '<p><a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><img src="'.$olympiade['logo'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</a></b>'.
					' <abbr title="Un peu de découverte, ça fait pas de mal. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr></p>';
				}

			?>		
			</div>
			<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez la souris 	<abbr title="Et voilà, le message caché s'affiche. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr> pour avoir des détails sur les recommandations.</small></p>
			</div>
		</div>
		
	<div class="card">
		<div class="card-header"><b>Les délégations...</b></div>
		  <div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>
			<?php				
				session_start();
				if(isset($_SESSION['utilisateur'])){
					$test_pays_r = $bdd->prepare('SELECT * FROM apprecier_p WHERE apprecier_p.id_utilisateur = ? LIMIT 1');
					$test_pays_r->execute([$_SESSION['utilisateur']['utilisateur']]);
					if($test_pays_r->fetch()) {
						$pays_r = $bdd->prepare('SELECT * FROM pays_participants, apprecier_p WHERE apprecier_p.Code_CIO != pays_participants.Code_CIO AND apprecier_p.id_utilisateur = ? ORDER BY RAND() LIMIT 2');
						$pays_r->execute([$_SESSION['utilisateur']['utilisateur']]);
					}
					else {
						$pays_r = $bdd->prepare('SELECT * FROM pays_participants ORDER BY RAND() LIMIT 3');
						$pays_r->execute();
					}
				}
				else {
					$pays_r = $bdd->prepare('SELECT * FROM pays_participants ORDER BY RAND() LIMIT 3');
					$pays_r->execute();
				}

				while ($pays = $pays_r->fetch()) {
					echo '<p><a href="Pays_particulier.php?id='.$pays["Code_CIO"].'" class="text-dark"><img src="'.$pays['I_drapeau'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$pays["Code_CIO"].'" class="text-dark"><b> ' . $pays['nom_pays'] . '</a></b>'.' <abbr title="Un peu de découverte, ça fait pas de mal. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr></p>';
				}
			?>		
			</div>
			<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez la souris 	<abbr title="Et voilà, le message caché s'affiche. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr> pour avoir des détails sur les recommandations.</small></p>
			</div>
	</div>
	
	<div class="card">
		<div class="card-header"><b>Les disciplines...</b></div>
		<div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>		
			<?php				
				session_start();
				if(isset($_SESSION['utilisateur'])){
					$test_disciplines_r = $bdd->prepare('SELECT * FROM apprecier_d WHERE apprecier_d.id_utilisateur = ? LIMIT 1');
					$test_disciplines_r ->execute([$_SESSION['utilisateur']['utilisateur']]);
					if($test_disciplines_r->fetch()) {
						$disciplines_r = $bdd->prepare('SELECT * FROM disciplines, apprecier_d WHERE apprecier_d.id_discipline != disciplines.id_discipline	
						AND apprecier_d.id_utilisateur = ? ORDER BY RAND() LIMIT 2');
						$disciplines_r->execute([$_SESSION['utilisateur']['utilisateur']]);
					}
					else {
						$disciplines_r = $bdd->prepare('SELECT * FROM disciplines ORDER BY RAND() LIMIT 3');
						$disciplines_r->execute();
					}
				}
				else {
					$disciplines_r = $bdd->prepare('SELECT * FROM disciplines ORDER BY RAND() LIMIT 3');
					$disciplines_r->execute();
				}
					
				while ($discipline_r = $disciplines_r->fetch()) {
					echo '<p><img src="'.$discipline_r['pictogramme'].'" class="img-thumbnail border-0" width="40px"> <b>' . $discipline_r['nom_discipline'] . '</b>'.' <abbr title="Un peu de découverte, ça fait pas de mal. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr></p>';
				}
			?>	
		</div>
					<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez la souris 	<abbr title="Et voilà, le message caché s'affiche. (:" class="tooltip-hover text-info">&#x1F5B0;</abbr> pour avoir des détails sur les recommandations.</small></p>
			</div>
	</div>
		
	<!--<div class="card">
		<div class="card-header">Les athletes...</div>
		  <div class="card-body">
			<h5 class="card-title">Light card title</h5>
			<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
			</div>
	</div>
	
				<div class="card-body">
				<h5 class="card-title">Light card title</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
			</div>
			<div class="card-footer bg-transparent">
				<h5 class="card-title mt-2">Light card title</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<p class="card-text mb-2"><small class="text-muted">Last updated 3 mins ago</small></p>
			</div>-->
	
</div>
	
	
	
</div>
		<footer class='mt-5'>
	<?php
		include "pied_de_page.php";
	?>
	</footer>
</body></html>