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
		header("Location: Frise_des_editions.php");
		exit;
	}

	$stmt = $bdd->prepare('SELECT * FROM olympiades, villes_hotes WHERE id_olympiade = ? AND villes_hotes.id_ville = olympiades.id_ville_hote');
	$stmt->execute([$id_olympiade]);
	$olympiade = $stmt->fetch();

	if (!$olympiade) {
		// L'olympiade n'existe pas
		// header("Location: Frise_des_editions.php");
		exit;
	}
	
	echo '<title>'.$olympiade["nom"]." ".$olympiade["annee_o"].'</title>';
echo'</head>

<body>

  <iframe class="navbar" src="Barre_de_navigation.html" width="100%" height="5%" frameborder="0"></iframe>  
  
  <div class="container">
    <div class="row">
        <div class="col-md-12">';
		
			echo '<img src="'.$olympiade["logo"].'" class="float-right" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 200px; max-height: 150px;">';

			echo "<h1><strong>Olympiade ".$olympiade["nom"]." ".$olympiade["annee_o"]."</strong>";


				  echo '<button type="button" class="btn btn-lg bg-white text-danger border-0">';
					 echo '<img src="../Images/Boutons/coeur_plein.svg" alt="Coeur rempli" />';
				   echo "</button>";
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
					
					   echo '<p><img src="'.$pays['I_drapeau'].'" alt="Drapeau '.$olympiade['pays_hote'].'" class="img-thumbnail border-0" width="35px"> <a href="http://localhost/PROJET_JO/Script_HTML/Carte_des_editions.php?lat='.$olympiade['latitude'].'&lon='.$olympiade['longitude'].'#ancre" class="text-primary">'.$olympiade['pays_hote'].'</a> ('.$nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions' : ' &eacute;dition').' au total)</p>';
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
					
					  $nb_ath = $bdd->query("SELECT count(etre_nationalite.ID_athletes) as nb FROM olympiades, etre_nationalite WHERE olympiades.id_olympiade = etre_nationalite.id_olympiade AND olympiades.id_olympiade = '".$olympiade['id_olympiade']."'")->fetch();	
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
					
					echo "<p><strong>Record olympique al&eacute;atoire :</strong> ".$epreuve['epreuves']." - ".($athlete['Sexe'] == 'M' ? 'Monsieur ' : 'Madame ').$athlete['Name']." (".$pays['nom_pays'].") a fait ".$record['record olympique']." ".strtolower($record['unite'])." au ".strtolower($record['stade de la comp&eacute;tition'])." de la comp&eacute;tition.</p>";
				}
				
			   echo '</div>';
			echo '</div>';
		echo '</div>';
	  

if ($nb_ath['nb']!=0) {
  echo '<div class="container">';
	echo '<br><br>';
	echo '<center><h2><strong>Classement des m&eacute;dailles CIO</strong></h2></center>';
	echo '<br>';
	
	$classement_or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC LIMIT 5');	
  
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
						$argent = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 2 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();
						$bronze = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 3 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();

						echo '<tr>
							<td>'.++$i.'</td>
							<th scope="row"><img src="'.$ligne_classement_or['I_drapeau'].'" alt="Drapeau '.$ligne_classement_or['nom_pays'].'" class="img-thumbnail border-0" width="40px"> '.$ligne_classement_or['nom_pays'].'</th>
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
					
					$classement_or_pop = $bdd->query('SELECT (count(DISTINCT lier_m.id_epreuves) / (pays_participants.population)) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade and pays_participants.population != -1 AND lier_m.id_med = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY `nb`  ASC LIMIT 3');	
					
					 echo '<div class="row">
						<div class="col-12">
						  <table class="table">
							<tbody>';
							$i = 0;
							while ($ligne_classement_or_pop = $classement_or_pop ->fetch()) {
								$or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();
								$argent = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 2 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();
								$bronze = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_med = 3 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or_pop['id_pays'].'"')->fetch();

								echo '<tr>
									<td>'.++$i.'</td>
									<th scope="row"><img src="'.$ligne_classement_or_pop['I_drapeau'].'" alt="Drapeau '.$ligne_classement_or_pop['nom_pays'].'" class="img-thumbnail border-0" width="40px"> '.$ligne_classement_or_pop['nom_pays'].'</th>
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
				  
				  
				  
				  <!--<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
				  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
				</div>
			  </div>
			</div>

		<br><br>
		</div>';
		
}
?>

	<br><br><br>
	<footer>
		<object  data="Pied_de_page.html" width="100%" height="100%">
		</object>
	</footer>
	</body>
	</html>
