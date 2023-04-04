<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Comparer des olympiades</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Styles/comparer.css" type="text/css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	   <style>
		h1.olympiade-title {
		  font-weight: bold;
		}
	   </style>
	</head>
    <body>
  	<header>
		<?php
		include "Barre_de_navigation.html";
		?>
	</header>
	<div class="container  mt-5">
    <h2 class='mb-5'>Comparons les Olympiades</h2>		
		
		<?php 
			// Connexion à la BD
			require("fonction.php");
			$bdd = getBDD();		
		
			$olympiade_aleatoire = $bdd->prepare('SELECT id_olympiade FROM olympiades WHERE olympiades.annee_o < 2017 ORDER BY RAND() LIMIT 2');
			$olympiade_aleatoire->execute();

			// $view = $_GET['view'];
			$id_result = $olympiade_aleatoire->fetch();
			$id = isset($_GET['id']) && $_GET['id'] !== '' ? $_GET['id'] : $id_result['id_olympiade'];
			$id2_result = $olympiade_aleatoire->fetch();
			$id2 = isset($_GET['id2']) && $_GET['id2'] !== '' ? $_GET['id2'] : $id2_result['id_olympiade'];


		// Récupération de toutes les olympiades
			$olympiade1 = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.Code_CIO = pays_participants.Code_CIO AND villes_hotes.id_ville = olympiades.id_ville_hote AND olympiades.id_olympiade = ?');
			$olympiade1->execute(array($id));

			$olympiade2 = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.Code_CIO = pays_participants.Code_CIO AND villes_hotes.id_ville = olympiades.id_ville_hote AND olympiades.id_olympiade = ?');
			$olympiade2->execute(array($id2));

			$olympiades = array($olympiade1->fetch(), $olympiade2->fetch());
			$olympiades2 = array($olympiade1->fetch(), $olympiade2->fetch());
	

	// CARTES OLYMPIADES
		echo '<div class="card-deck">';
			$i=0;
			foreach ($olympiades as $olympiade) {
			$i++;
			$toutes_olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.Code_CIO = pays_participants.Code_CIO AND villes_hotes.id_ville = olympiades.id_ville_hote AND olympiades.annee_o < 2017 ORDER BY n_edition ASC');
			$toutes_olympiades->execute();
			
			$nb_pays = $bdd->query('SELECT COUNT(olympiades.pays_hote) as olymp FROM olympiades WHERE olympiades.pays_hote = "'.$olympiade['pays_hote'].'" GROUP BY olympiades.pays_hote')->fetch();
					echo'<div class="card">
						<div class="card-body">';
						
						echo'<div class="form-group">
							<select class="form-control" id="exampleFormControlSelect1" onchange="window.location.href = this.value;">
								<option value="">
							    <h1 class="olympiade-title">Choisir une autre &eacute;dition...</h1>
							</option>';
						while($une_olympiade = $toutes_olympiades->fetch()) {
							if($i == 1) {
								echo'<option value="Comparer.php?id='.$une_olympiade["id_olympiade"].'&id2='.$id2.'#Comparons">Olympiade '. $une_olympiade["nom"] . " " . $une_olympiade["annee_o"] .'</option>';
							}
							 elseif($i > 1) {
								echo'<option value="Comparer.php?id='.$id.'&id2='.$une_olympiade["id_olympiade"].'#Comparons">Olympiade '. $une_olympiade["nom"] . " " . $une_olympiade["annee_o"] .'</option>';
							}
						}
						echo '</select></div><hr>
			<div style="min-height: 190px;">';
							
						echo '<a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'"><img src="'.$olympiade["logo"].'" class="float-right mr-2" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 100px; max-height: 70px;"></a>';
						echo '<h4 class="card-title mb-0"><a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</a></b>
						
							<a href="Vision_par_editions.php?lat='.$olympiade['latitude'].'&lon='.$olympiade['longitude'].'#carte"><button type="button" class="btn btn-lg bg-white text-danger border-0">
							<img src="../Images/Boutons/Carte.png" alt="Bouton carte des pays" onmouseover="this.src=\'../Images/Boutons/Carte_survol.png\'" onmouseout="this.src=\'../Images/Boutons/Carte.png\';" height="40px" />
							</button><a>
						
						</h4>';
					
						echo'<h6 class="card-title mb-0 my-1"><a href="Pays_particulier.php?id='.$olympiade['Code_CIO'].'" class="text-dark"><img src="' . $olympiade['I_drapeau'] . '" alt="Drapeau ' . $olympiade['pays_hote'] . '" class="img-thumbnail border-0" width="30px">' . $olympiade['pays_hote'] . '</a> (' . $nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions organis&eacute;es' : ' &eacute;dition organis&eacute;e'). ')</h6>
						  <p class="card-text">';
					
					
					$pays = $bdd->query("SELECT * FROM pays_participants WHERE pays_participants.Code_CIO = '".$olympiade['Code_CIO']."'")->fetch();
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
							
						  echo '</p>';
						  
						  
						  echo '</div><div class="container">';
	echo '<br>';
	
	$classement_or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC LIMIT 5');	
 
		  echo '<div class="row">';
			echo '<div class="col-12">';
			  echo '<table class="table">';
				echo '<tbody>';
					
					$j = 0;
					while ($ligne_classement_or = $classement_or ->fetch()) {
						$argent = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 2 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();
						$bronze = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 3 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" AND etre_nationalite.id_pays = "'.$ligne_classement_or['id_pays'].'"')->fetch();

					// Détermination des places relatives dans le classement (:
						$trouve = false;
						if($i == 1){
							$autre_classement  = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiades[1]['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC');
						}
						elseif($i == 2) {
							$autre_classement  = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'. $olympiades[0]['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC');
						}
						
						$classement = $autre_classement->fetch();
						$i_classement = 1;
						while ($classement && !$trouve) {
							if (strcmp($ligne_classement_or['Code_CIO'], $classement['Code_CIO'])==0) {
								$trouve = true;
								
							}
							else {
								$classement = $autre_classement->fetch();
								$i_classement++;
							}
						}
						
						++$j;
						if($trouve) {
							$place_relative = $i_classement-$j;
							$couleur = ($place_relative >= 0 ? 'text-success' : 'text-danger');
							
							if ($place_relative == 0) {
								$place_relative = '(=)';
							} else {
								$place_relative = '('.($place_relative >= 0 ? '+' : '').$place_relative.')';
							}
						}
						else {
							// MESSAGE SI DEGATION EXISTE PAS
								$id_du_pays = $ligne_classement_or['Code_CIO'];
								$premiere_olympiade = $bdd->query("SELECT olympiades.n_edition, etre_nationalite.id_olympiade, olympiades.annee_o
								FROM etre_nationalite JOIN olympiades ON olympiades.id_olympiade = etre_nationalite.id_olympiade 
								WHERE etre_nationalite.id_pays = '".$id_du_pays."' AND etre_nationalite.id_olympiade IN (
									SELECT DISTINCT(id_olympiade) FROM etre_nationalite WHERE etre_nationalite.id_pays = '".$id_du_pays."' ORDER BY id_olympiade ASC ) ORDER BY olympiades.n_edition ASC LIMIT 1");
								$derniere_olympiade = $bdd->query("SELECT olympiades.n_edition, etre_nationalite.id_olympiade, olympiades.annee_o
								FROM etre_nationalite JOIN olympiades ON olympiades.id_olympiade = etre_nationalite.id_olympiade 
								WHERE etre_nationalite.id_pays = '".$id_du_pays."' AND etre_nationalite.id_olympiade IN (
									SELECT DISTINCT(id_olympiade) FROM etre_nationalite WHERE etre_nationalite.id_pays = '".$id_du_pays."' ORDER BY id_olympiade DESC ) ORDER BY olympiades.n_edition DESC LIMIT 1");
								$premiere_olympiade = $premiere_olympiade->fetch();
								$derniere_olympiade = $derniere_olympiade->fetch(); 

								$infos = '';
								if ($premiere_olympiade['annee_o'] > $olympiades[($i == 2 ? 0 : 1)]['annee_o']) {
									$infos =' Premi&egrave;re participation en ' . $premiere_olympiade['annee_o'] . '.';
								}
								if ($derniere_olympiade['annee_o'] < $olympiades[($i == 2 ? 0 : 1)]['annee_o']) {
									
									$infos =' Derni&egrave;re participation en ' . $derniere_olympiade['annee_o'] . '.';
								}
						
								$place_relative = '<abbr title="Cette d&eacute;l&eacute;gation n\'a pas participé à l\'olympiade de '.($i == 1 ? 'droite' : 'gauche').' - '.$olympiades[($i == 2 ? 0 : 1)]['nom'].' '. $olympiades[($i == 2 ? 0 : 1)]['annee_o'] . '.' . $infos .'" class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr>';
							// FIN MESSAGE	
						}
								
						echo '<tr>
							<td><b>'.$j.'</b><p class="'.$couleur.' mt-2">'. $place_relative .'</p></td>
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
				<div class="card-footer bg-transparent">
					<p class="card-text mb-2"><small class="text-muted">Survolez quelques secondes le curseur <abbr title="Les informations sur les recommandations s\'affichent ici !" class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr> pour avoir des détails sur les recommandations.</small></p>
				</div>
				
				
				
				
		</div>';
		}	
		?>
		</div>
	</div>

	<footer class='mt-5'>
	<?php
		include "pied_de_page.php";
	?>
	</footer>
		
	</body>
</html>
