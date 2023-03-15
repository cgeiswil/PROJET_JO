<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Comparer</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="Styles/comparer.css" type="text/css"> 
	     <!-- liens vers les fichiers CSS et JS nécessaires pour faire fonctionner la barre de navigation -->
		  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
	   <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	</head>
    <body>
    

	<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>
	
	
    <h1>Que voulez-vous comparer ?</h1>
    
    <br>
    
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			 <ul class="navbar-nav mr-auto ml-auto mt-lg-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Athlètes</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pays</a>  
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Editions</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle font-weight-bold active" href="classement_par_delegation.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Discipline</a>
				</li>
			</ul>
		</div>
    </nav>
    
	  <div class="container">
		<br><br>
		<center><h2><strong>Comparons des éditions !</strong></h2></center>
		<br>

		<?php 
			// Connexion à votre base de données
			require("fonction.php");
			$bdd = getBDD();

			// Récupération de toutes les olympiades
			$olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.annee_o < 2017 AND olympiades.Code_CIO = pays_participants.Code_CIO ORDER BY RAND() LIMIT 1');
			$olympiades->execute();
			$olympiade = $olympiades->fetch();
			
						// Récupération de toutes les olympiades
			$olympiades = $bdd->prepare('SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.annee_o < 2017 AND olympiades.Code_CIO = pays_participants.Code_CIO ORDER BY RAND() LIMIT 2');
			$olympiades->execute();
				
			echo '<div class="card-deck">';
			
	while ($olympiade = $olympiades->fetch()) {
			
			$nb_pays = $bdd->query('SELECT COUNT(olympiades.pays_hote) as olymp FROM olympiades WHERE olympiades.pays_hote = "'.$olympiade['pays_hote'].'" GROUP BY olympiades.pays_hote')->fetch();
					echo'<div class="card">
						<div class="card-body">';
						echo '<img src="'.$olympiade["logo"].'" class="float-right" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 100px; max-height: 75px;">';
						  echo '<h4 class="card-title mb-0"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</b></h4>
						  <h6 class="card-title mb-0 my-1"><img src="' . $olympiade['I_drapeau'] . '" alt="Drapeau ' . $olympiade['pays_hote'] . '" class="img-thumbnail border-0" width="30px">' . $olympiade['pays_hote'] . ' (' . $nb_pays['olymp'].($nb_pays['olymp'] > 1 ? ' &eacute;ditions' : ' &eacute;dition'). ')</h6>
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
						  
							foreach ($resultats as $resultat) {
								// Affichage des résultats
							}
						  
						  echo '</p>';
						  
						  
						  echo '<div class="container">';
	echo '<br>';
	
	$classement_or = $bdd->query('SELECT count(DISTINCT lier_m.id_epreuves) as nb, etre_nationalite.id_pays, pays_participants.nom_pays, pays_participants.I_drapeau FROM lier_m, etre_nationalite, athletes, pays_participants WHERE pays_participants.Code_CIO = etre_nationalite.id_pays AND lier_m.ID_athletes = athletes.ID_athletes AND athletes.ID_athletes = etre_nationalite.ID_athletes AND lier_m.id_olympiade = etre_nationalite.id_olympiade AND lier_m.id_medaille = 1 AND lier_m.id_olympiade = "'.$olympiade['id_olympiade'].'" GROUP BY etre_nationalite.id_pays ORDER BY nb DESC LIMIT 5');	
 

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
		</div>';
						  
						  
						  echo '<p class="card-text"><small class="text-muted">Recommandations.</small></p>
						  
						</div>
					</div>';
		}	
		?>
		</div>


<br><br><br>
<form class="form-inline">
  <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Recherche">
  <button class="btn btn-primary my-2 my-sm-0" type="submit">Rechercher</button>
</form>

<div id="search-results"></div>
<br>
<script>
  // Récupérer les éléments de la barre de recherche
  const searchForm = document.querySelector('form');
  const searchInput = document.querySelector('input[type="search"]');
  const searchResults = document.querySelector('#search-results');

  // Ajouter un gestionnaire d'événement pour le formulaire de recherche
  searchForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Empêcher l'envoi du formulaire

    const searchTerm = searchInput.value; // Récupérer le terme de recherche

    // Effectuer une recherche et récupérer les résultats
    const results = performSearch(searchTerm);

    // Afficher les résultats dans la zone de résultats
    renderResults(results);
  });

  // Fonction pour effectuer une recherche
  function performSearch(term) {
    // Effectuez une requête AJAX ou utilisez une autre bibliothèque pour récupérer les résultats de la recherche
    const results = [
      { title: 'Résultat 1', description: 'Description du résultat 1.' },
      { title: 'Résultat 2', description: 'Description du résultat 2.' },
      { title: 'Résultat 3', description: 'Description du résultat 3.' },
    ];

    return results;
  }

  // Fonction pour afficher les résultats
  function renderResults(results) {
    // Effacer les résultats précédents
    searchResults.innerHTML = '';

    // Ajouter chaque résultat à la zone de résultats
    results.forEach(result => {
      const item = document.createElement('a');
      item.classList.add('dropdown-item');
      item.href = '#';
      item.innerHTML = `<strong>${result.title}</strong><br>${result.description}`;
      searchResults.appendChild(item);
    });
  }
</script>
<div class="form-group">
  <label for="exampleFormControlSelect1">Choisir une option :</label>
  <select class="form-control" id="exampleFormControlSelect1">
    <option value=""><h1>Sélectionner une option</h1></option>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
    <option value="4">Option 4</option>
    <option value="5">Option 5</option>
    </label></div>


    <br>
	</div>
	<footer>
		<object class='my-5' data="Pied_de_page.html" width="100%" height="100%">
		</object>
	</footer>
		
	</body>
</html>
