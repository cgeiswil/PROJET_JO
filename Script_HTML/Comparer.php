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
				
			echo '<div class="card-deck">
					<div class="card">
						<div class="card-body">';
						echo '<img src="'.$olympiade["logo"].'" class="float-right" alt="Logo JO '.$olympiade["nom"]." ".$olympiade["annee_o"].'" style="max-width: 100px; max-height: 75px;">';
						  echo '<h4 class="card-title mb-0"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</b></h4>
						  <h6 class="card-title mb-0 my-1"><img src="' . $olympiade['I_drapeau'] . '" alt="Drapeau ' . $olympiade['pays_hote'] . '" class="img-thumbnail border-0" width="30px">' . $olympiade['pays_hote'] . '</h6>
						  <p class="card-text">Description du classement.</p>
						  <p class="card-text"><small class="text-muted">yruhnj</small></p>
						  <p class="card-text">';
						  
							foreach ($resultats as $resultat) {
								// Affichage des résultats
							}
						  
						  echo '</p>
						  
						</div>
					</div>	
					<div class="card">
						<div class="card-body">
						  <h5 class="card-title">Paris 1924</h5>
						  <p class="card-text">Description du classement.</p>
						  <p class="card-text"><small class="text-muted">yruhnj</small></p>
						  <p class="card-text">';
						  
							foreach ($resultats as $resultat) {
								// Affichage des résultats
							}
						  
						  echo '</p>
						  
						</div>
					</div>	
				</div>';
		?>
<form class="form-inline">
  <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Recherche">
  <button class="btn btn-primary my-2 my-sm-0" type="submit">Rechercher</button>
</form>

<div id="search-results"></div>

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
