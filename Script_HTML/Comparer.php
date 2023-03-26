<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Comparer</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="Styles/comparer.css" type="text/css"> 
	     <!-- liens vers les fichiers CSS et JS n&eacute;cessaires pour faire fonctionner la barre de navigation -->
		  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
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
	
    <h1>Que voulez-vous comparer ?</h1>
    
    <br>
    
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			 <ul class="navbar-nav mr-auto ml-auto mt-lg-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pays</a>  
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&Eacute;ditions</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Discipline</a>
				</li>
			</ul>
		</div>
    </nav>
    
	  <div class="container">
		<br><br>
		<center><h2 id='Comparons'><strong>Comparons des &eacute;ditions !</strong></h2></center>
		<br>

		<?php 
			// Connexion à la BD
			require("fonction.php");
			$bdd = getBDD();		
		
			$olympiade_aleatoire = $bdd->prepare('SELECT id_olympiade FROM olympiades WHERE olympiades.annee_o < 2017 ORDER BY RAND() LIMIT 2');
			$olympiade_aleatoire->execute();

			$view = $_GET['view'];
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
						echo '</select></div><hr>';
						
							
						echo '<a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'"><img src="'.$olympiade["logo"].'" class="float-right mr-2" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 100px; max-height: 70px;"></a>';
						echo '<h4 class="card-title mb-0"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</b>
											
							<button type="button" class="btn btn-lg bg-white text-danger border-0">
							<img id="coeur_' . $olympiade["id_olympiade"] . '" src="../Images/Boutons/Coeur_olympiades.jpg" alt="Coeur Olympiades" height="30px"/>
							</button>
						
						</h4>';
					
						echo'<h6 class="card-title mb-0 my-1"><a href="Pays_particulier.php?id='.$olympiade['Code_CIO'].'" class="text-dark"><img src="' . $olympiade['I_drapeau'] . '" alt="Drapeau ' . $olympiade['pays_hote'] . '" class="img-thumbnail border-0" width="30px">' . $olympiade['pays_hote'] . '</a> (' . $nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions organis&eacute;es' : ' &eacute;dition organis&eacute;e'). ')</h6>
						  <p class="card-text">';					
						
										
			
			
				// AJOUT DU COEUR
					session_start();
					$image = "../Images/Boutons/Coeur_olympiades.jpg";
					if (isset($_SESSION['utilisateur']['utilisateur'])) {
						$aimer = $bdd->prepare('SELECT * FROM apprecier_o WHERE id_olympiade = ? AND id_utilisateur = ?');
						$aimer->execute(array($olympiade["id_olympiade"], $_SESSION['utilisateur']['utilisateur']));
						if ($aimer->fetch()) {
							$image = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
						}
					}

					echo '<div class="float-right">
							<button type="button" class="btn btn-lg bg-white text-danger border-0">
							<img id="coeur_' . $olympiade["id_olympiade"] . '" src="' . $image . '" alt="Coeur Olympiades" height="40px"/>
							</button>
					</div>';

					echo '<script>
					var coeur = document.getElementById("coeur_' . $olympiade["id_olympiade"] . '");
					coeur.addEventListener("click", function() {
						var xhr = new XMLHttpRequest();
						xhr.open("POST", "Comparer.php?id=' . $olympiade["id_olympiade"] . '#Comparons");
						xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						xhr.onload = function() {
							if (xhr.status === 200) {
								coeur.src = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
							} else {
								console.log("[ERREUR] Erreur de mise à jour des données !!!!");
							}
						};
						xhr.send("id_olympiade=' . $olympiade["id_olympiade"] . '&utilisateur=' . $_SESSION['utilisateur']['utilisateur'] . '");
					});
					</script>';

					if (isset($_POST['id_olympiade']) && isset($_POST['utilisateur']) && $_POST['id_olympiade'] == $olympiade["id_olympiade"]) {
						$aimerBD = $bdd->prepare('INSERT INTO apprecier_o(id_olympiade, id_utilisateur) VALUES (?, ?)');
						$aimerBD->execute(array($_POST['id_olympiade'], $_POST['utilisateur']));
						unset($_POST['id_olympiade']);
					}
			// FIN AJOUT DU COEUR
					
					
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
						  
						  
						  echo '<div class="container">';
	echo '<br>';
	
	$classement_or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau, Code_CIO FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC LIMIT 5');	
 

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
		</div>';
						  
						  
						  echo '<p class="card-text"><small class="text-muted">Recommandations.</small></p>
						  
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
