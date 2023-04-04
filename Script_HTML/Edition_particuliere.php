<!DOCTYPE html>
<html>
<head>
  <meta charset="utf8">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	<?php	
	require("fonction.php");
	$bdd = getBDD();
	
	$id_olympiade = $_GET['id'];
	if (!$id_olympiade) {
		// L'ID est invalide ou absent
		header("Location: Vision_par_editions.php");
		exit;
	}

	$stmt = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE id_olympiade = ? AND villes_hotes.id_ville = olympiades.id_ville_hote AND olympiades.Code_CIO = pays_participants.Code_CIO');
	$stmt->execute([$id_olympiade]);
	$olympiade = $stmt->fetch();

	if (!$olympiade) {
		// L'olympiade n'existe pas
		header("Location: Vision_par_editions.php");
		exit;
	}
	
	echo '<title>'.$olympiade["nom"]." ".$olympiade["annee_o"].'</title>
</head>

<body>
<header>';
  include "Barre_de_navigation.html";
  echo'</header>
	<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">';
		
			echo '<img src="'.$olympiade["logo"].'" class="float-right" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 200px; max-height: 150px;">';

			echo "<h1><strong>Olympiade ".$olympiade["nom"]." ".$olympiade["annee_o"]."</strong>";
					
				// AJOUT DU COEUR
					session_start();
					$image = "../Images/Boutons/Coeur_olympiades.jpg";
					if (isset($_SESSION['utilisateur'])) {
						$aimer = $bdd->prepare('SELECT * FROM apprecier_o WHERE id_olympiade = ? AND id_utilisateur = ?');
						$aimer->execute(array($id_olympiade, $_SESSION['utilisateur']['utilisateur']));
						if ($aimer->fetch()) {
							$image = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
						}
					}

					echo '<button type="button" class="btn btn-lg bg-white text-danger border-0 ml-2">';
					echo '<img id="coeur" src="'.$image.'" alt="Coeur Olympiades" height="60px"/>';
					echo "</button>";

					echo '<script>
						var coeur = document.getElementById("coeur");
						coeur.addEventListener("click", function() {
							var xhr = new XMLHttpRequest();
							xhr.open("POST", "Edition_particuliere.php?id='.$id_olympiade.'");
							xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
							xhr.onload = function() {
								if (xhr.status === 200) {
									coeur.src = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
								} else {
									console.log("[ERREUR] Erreur de mise à jour des données !!!!");
								}
							};
							xhr.send("id_olympiade='.$id_olympiade.'&utilisateur='.$_SESSION['utilisateur']['utilisateur'].'");
						});
					</script>';
				
					if (isset($_POST['id_olympiade']) && isset($_POST['utilisateur'])) {
						$aimerBD = $bdd->prepare('INSERT INTO apprecier_o(id_olympiade, id_utilisateur) VALUES (?, ?)');
						$aimerBD->execute(array($_POST['id_olympiade'], $_POST['utilisateur']));
						unset($_POST['id_olympiade']);
					}
				// FIN AJOUT DU COEUR
				
				// AJOUT BOUTON COMPARER				
				   echo '<a href="Comparer.php?id='.$olympiade["id_olympiade"].'#Comparons"><button type="button" class="btn btn-lg bg-white text-danger border-0  ml-2">';
					 echo '<img src="../Images/Boutons/Comparer_olympiades.jpg" alt="Balance de comparaison de pays" height="60px" />';
				   echo "</button><a>";
				 echo "</h1>";
			
		# Boutons JO AVANT < > JO APRES			
			$olympiade_avant = $bdd->query('SELECT * FROM olympiades, villes_hotes WHERE n_edition = (SELECT MAX(n_edition) FROM olympiades WHERE n_edition < '.$olympiade["n_edition"].') AND villes_hotes.id_ville = olympiades.id_ville_hote')->fetch();
			$olympiade_apres = $bdd->query('SELECT * FROM olympiades, villes_hotes WHERE n_edition = (SELECT MIN(n_edition) FROM olympiades WHERE n_edition > '.$olympiade["n_edition"].') AND villes_hotes.id_ville = olympiades.id_ville_hote')->fetch();
			
			 echo '<div class="mb-3">';
				if($olympiade_avant != "") {
					echo '<a class="badge badge-pill badge-secondary" href="Edition_particuliere.php?id='.$olympiade_avant['id_olympiade'].'">'.($olympiade_avant['saison'] == 'Summer' ? '&Eacute;t&eacute; ' : 'Hiver ').$olympiade_avant["nom"]." ".$olympiade_avant["annee_o"].' &lt;</a>';
				} 
				if($olympiade_apres != "") {
					echo '<a class="badge badge-pill badge-secondary" href="Edition_particuliere.php?id='.$olympiade_apres['id_olympiade'].'">&gt; '.($olympiade_apres['saison'] == 'Summer' ? '&Eacute;t&eacute; ' : 'Hiver ').$olympiade_apres["nom"]." ".$olympiade_apres["annee_o"].'</a>';
				}
			 echo "</div>";

			  
				   echo '<div class="row">';
					 echo '<div class="col-sm">';
					
					$nb_pays = $bdd->query('SELECT COUNT(olympiades.pays_hote) as olymp FROM olympiades WHERE olympiades.pays_hote = "'.$olympiade['pays_hote'].'" GROUP BY olympiades.pays_hote')->fetch();
					$pays = $bdd->query("SELECT * FROM pays_participants WHERE pays_participants.Code_CIO = '".$olympiade['Code_CIO']."'")->fetch();
					
					 //  echo '<p><img src="'.$pays['I_drapeau'].'" alt="Drapeau '.$olympiade['pays_hote'].'" class="img-thumbnail border-0" width="35px"> <a href="Vision_par_editions.php?view=p&lat='.$olympiade['latitude_pays'].'&lon='.$olympiade['longitude_pays'].'#carte" class="text-dark">'.$olympiade['pays_hote'].'</a> ('.$nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions' : ' &eacute;dition').' au total)</p>';
					  echo '<p><a href="Pays_particulier.php?id='.$olympiade['Code_CIO'].'" class="text-dark"><img src="'.$pays['I_drapeau'].'" alt="Drapeau '.$olympiade['pays_hote'].'" class="img-thumbnail border-0" width="35px"><b>'.$olympiade['pays_hote'].'</b></a> ('.$nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions organis&eacute;es' : ' &eacute;dition organis&eacute;e').')</p>';
					  echo '<p>Jeux Olympiques d\''.($olympiade['saison'] == 'Summer' ? '&Eacute;t&eacute;' : 'Hiver').'</p>';

					  // Calcul du nb de jour
						// Convertir les dates en objets DateTime
						$dateObj1 = DateTime::createFromFormat('m/d/Y', $olympiade['date_ouverture']);
						$dateObj2 = DateTime::createFromFormat('m/d/Y', $olympiade['date_fermeture']);

							// Soustraire les dates et obtenir la diff&eacute;rence en jours
							$diff = $dateObj2->diff($dateObj1)->format("%a");

							// Configuration locale en français avec encodage UTF-8
							setlocale(LC_TIME, "fr_FR.utf8");

							// Affichage des dates en français
							$dateDebut = strftime("%B", $dateObj1->getTimestamp()) == strftime("%B", $dateObj2->getTimestamp()) ? strftime("%e", $dateObj1->getTimestamp()) : strftime("%e %B", $dateObj1->getTimestamp());
							$dateFin = strftime("%e %B", $dateObj2->getTimestamp());

							echo '<p>'.$diff.' jours - '.strtolower($dateDebut). " au " .strtolower($dateFin).'</p>';



				   
					echo '</div>';
					echo '<div class="col-sm">';
					
					  $nb_ath = $bdd->query("SELECT count(DISTINCT etre_nationalite.ID_athletes) as nb FROM olympiades, etre_nationalite WHERE olympiades.id_olympiade = etre_nationalite.id_olympiade AND olympiades.id_olympiade = '".$olympiade['id_olympiade']."'")->fetch();	
					  echo $nb_ath['nb']!=0 ? '<p class="text-success">'.$nb_ath['nb'].' athlètes</p>' : "";
					  echo '<p class="text-danger">'.$olympiade['nb_delegations'].' d&eacute;l&eacute;gations repr&eacute;sent&eacute;es</p>';
					  echo '<p class="text-warning">'.$olympiade['nb_discplines'].' disciplines, '.$olympiade['nb_epreuves'].' &eacute;preuves</p>';
					echo '</div>';
				  echo '</div>';
		
					 	
			   echo "<div class='container'>";
				$anecdote = $bdd->query("SELECT * FROM anecdotes WHERE annee =".$olympiade['annee_o']." ORDER BY RAND() LIMIT 1")->fetch();
				if($anecdote != "") {
					echo "<p><strong>Le saviez-vous ?</strong> ".$anecdote['anecdote']." <a href='".$anecdote['source']."'>Lien de la source</a>.</p>";
				}
				
				$record = $bdd->query("SELECT * FROM records, lier_r WHERE lier_r.id_record = records.id_record AND lier_r.id_olympiade = '".$olympiade['id_olympiade']."' ORDER BY RAND() LIMIT 1")->fetch();

				if($record != "") {
					$athlete = $bdd->query("SELECT * FROM athletes WHERE ID_athletes=".$record['id_athlete']." LIMIT 1")->fetch();
					$epreuve = $bdd->query("SELECT * FROM epreuves WHERE id_epreuves='".$record['id_epreuve']."'")->fetch();
					$discipline = $bdd->query("SELECT * FROM disciplines WHERE disciplines.id_discipline =".$epreuve['id_disciplines'])->fetch();
					$pays =  $bdd->query("SELECT * FROM etre_nationalite, pays_participants WHERE etre_nationalite.id_pays = pays_participants.Code_CIO AND etre_nationalite.ID_athletes =".$record['id_athlete']." LIMIT 1")->fetch();
					
					echo "<p><strong>Record olympique al&eacute;atoire :</strong> ".$epreuve['epreuves']." - ".($athlete['Sexe'] == 'M' ? 'Monsieur ' : 'Madame ').$athlete['nom']." (".$pays['nom_pays'].") a fait ".$record['record olympique']." ".strtolower($record['unite'])." au ".strtolower($record['stade de la compétition'])." de la comp&eacute;tition.</p>";
				}
				
			   echo '</div>';
			echo '</div>';
		echo '</div>';
	  

if ($nb_ath['nb']!=0) {
  echo '<div class="container">';
	echo '<br><br>';
	echo '<center><h2><strong>Classement des m&eacute;dailles CIO</strong></h2></center>';
	echo '<br>';
	
	$classement_or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC LIMIT 5');	
  
	echo '<div class="container card">';
	echo '<div class="card-body">';
		echo '<h5 class="card-title">Classement officiel du Comit&eacute; International Olympique</h5>';
		echo '<p class="card-text">Description du classement.</p>';

		  echo '<div class="row">';
			echo '<div class="col-12">';
			  echo '<table class="table">';
				echo '<tbody>';
					
					$i = 0;
					while ($ligne_classement_or = $classement_or ->fetch()) {
						$argent = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 2 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();
						$bronze = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 3 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();

						echo '<tr>
							<td>'.++$i.'</td>
							<th scope="row"><a href="Pays_particulier.php?id='.$ligne_classement_or['Code_CIO'].'" class="text-dark"><img src="'.$ligne_classement_or['I_drapeau'].'" alt="Drapeau '.$ligne_classement_or['nom_pays'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$ligne_classement_or['Code_CIO'].'" class="text-dark">'.$ligne_classement_or['nom_pays'].'</a></th>
							<td><img src="../Images/Boutons/medaille_or.png" alt="M&eacute;daille d\'or" width="20px"> <span>'.$ligne_classement_or['nb'].'</span></td>
							<td><img src="../Images/Boutons/medaille_argent.png" alt="M&eacute;daille d\'argent" width="20px"> <span>'.$argent['nb'].'</span></td>
							<td><img src="../Images/Boutons/medaille_bronze.png" alt="M&eacute;daille de bronze" width="20px"> <span>'.$bronze["nb"].'</span></td>
							<td>= '.($ligne_classement_or['nb']+$argent['nb']+$bronze['nb']).'</td>
						</tr>';
					}
				
				echo'</tbody>
			  </table>
			</div>
		  </div>
		</div>
	</div>

	  <div class="container">
		<br><br>
		<center><h2><strong>Classement alternatifs des m&eacute;dailles</strong></h2></center>
		<br>
			 <div class="card-deck">
			  <div class="card">
				<div class="card-body">
				  <h5 class="card-title">Par athlètes (m&eacute;dailles d\'or)</h5>
				  <p class="card-text">Description du classement.</p>
				  <p class="card-text">
				  
					
					 <div class="row">
						<div class="col-12">
						  <table class="table">
							<tbody>
							 
							</tbody>
						  </table>
						</div>
					  </div>
				  
				  
				  </p>
				  
				</div>
			  </div>
			  <div class="card">
				<div class="card-body">
				  <h5 class="card-title">Par population des d&eacute;l&eacute;gations</h5>
				  <p class="card-text">Description du classement.</p>
							  <p class="card-text">';
					
					$classement_or_pop = $bdd->query('SELECT (count(DISTINCT lier_m.id_epreuves) / (pays_participants.population)) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade and pays_participants.population != -1 AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY `nb`  ASC LIMIT 3');	
					
					 echo '<div class="row">
						<div class="col-12">
						  <table class="table">
							<tbody>';
							$i = 0;
							while ($ligne_classement_or_pop = $classement_or_pop ->fetch()) {
								$or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();
								$argent = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 2 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();
								$bronze = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 3 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();

								echo '<tr>
									<td>'.++$i.'</td>
									<th scope="row"><a href="Pays_particulier.php?id='.$ligne_classement_or_pop['Code_CIO'].'" class="text-dark"><img src="'.$ligne_classement_or_pop['I_drapeau'].'" alt="Drapeau '.$ligne_classement_or_pop['nom_pays'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$ligne_classement_or_pop['Code_CIO'].'" class="text-dark">'.$ligne_classement_or_pop['nom_pays'].'</a></th>
									<td><img src="../Images/Boutons/medaille_or.png" alt="M&eacute;daille d\'or" width="20px"> <span>'.$or['nb'].'</span></td>
									<td><img src="../Images/Boutons/medaille_argent.png" alt="M&eacute;daille d\'argent" width="20px"> <span>'.$argent['nb'].'</span></td>
									<td><img src="../Images/Boutons/medaille_bronze.png" alt="M&eacute;daille de bronze" width="20px"> <span>'.$bronze["nb"].'</span></td>
									<td>= '.($or['nb']+$argent['nb']+$bronze['nb']).'</td>
								</tr>';
							}
							echo'</tbody>
						  </table>
						</div>
					  </div>
				  
				  </p>
				  
				</div>
			  </div>
			  <div class="card">
				<div class="card-body">
				  <h5 class="card-title">Par m&eacute;dailles pond&eacute;r&eacute;es</h5>
				  <p class="card-text">Description du classement.</p>
				  
							  <p class="card-text">
				  
					
					 <div class="row">
						<div class="col-12">
						  <table class="table">
							<tbody>
							  
							</tbody>
						  </table>
						</div>
					  </div>
		
				  </p>
				  
				</div>
			  </div>
			</div>
		</div>';
		
}
?>
	</div></div>

	<footer class='mt-5'>
	<?php
		include "pied_de_page.php";
	?>
	</footer>
	</body>
	</html>
