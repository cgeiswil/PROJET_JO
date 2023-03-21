<!DOCTYPE html>
<html lang="fr">
	<head>
    <title>Les JO Autrement</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">        
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

    	
    

	<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>
	
    <h1>Explorons les jeux olympiques <br> différemment !</h1>
    
    <div class="gif">
   <div class="cycle-slideshow">
  <div class="cycle-slide">
    <p>Le Saviez-vous ?</p>
    <?php
    require("fonction.php");

    $BDD = getBDD();
   	$anec = $BDD->query("Select anecdote FROM anecdotes
		Order by Rand()
		limit 1");
		$ligne = $anec -> fetch();
		echo "<p>".$ligne['anecdote']."</p>";


    ?>


  </div>
</div>
</div>
<div class="container">
	<h2>Les classements et éditions de Jeux Olympiques</h2>
	</div>

	<div class="container justify-content-center">
	  <div class="row justify-content-center card-deck">
		<div class="col-md-6 col-lg-5">
		  <div class="card border">
			<div class="card-body">
			  <table class="rounded-4">
				<tr>
				  <th>
					<a href="./Vision_par_delegations.php" target="_parent">
					  <img alt="Survol" onmouseout="this.src='../Images/Boutons/podium_drapeau.png';" onmouseover="this.src='../Images/Boutons/podium_drapeau_survol.png';" src="../Images/Boutons/podium_drapeau.png" />
					</a>
					<br>
					<small class="text-muted">Les meilleures délégations.</small>
				  </th>

				  <th>
					<a href="./Vision_par_athletes.php" target="_parent">
					  <img alt="Survol" onmouseout="this.src='../Images/Boutons/discipline_podium.png';" onmouseover="this.src='../Images/Boutons/discipline_podium_survol.png';" src="../Images/Boutons/discipline_podium.png" />
					</a>
					<br>
					<small class="text-muted">Les meilleurs athlètes.</small>
				  </th>
				</tr>
			  </table>
			</div>
		  </div>
		</div>

		<div class="col-md-6 col-lg-5">
		  <div class="card border">
			<div class="card-body">
			  <table class="rounded-4">
				<tr>
				  <th>
					<a href="./Vision_par_editions.php#carte" target="_parent">
					  <img alt="Survol" onmouseout="this.src='../Images/Boutons/planisphere.png';" onmouseover="this.src='../Images/Boutons/planisphere_survol.png';" src="../Images/Boutons/planisphere.png" />
					</a>
					<br>
					<small class="text-muted">La carte des éditions.</small>
				  </th>
				  <th>
					<a href="./Vision_par_editions.php#frise" target="_parent">
					  <img alt="Survol" onmouseout="this.src='../Images/Boutons/frise.png';" onmouseover="this.src='../Images/Boutons/frise_survol.png';" src="../Images/Boutons/frise.png" />
					</a>
					<br>
					<small class="text-muted">La frise des éditions.</small>
				  </th>
				</tr>
			  </table>
			</div>
		  </div>
		</div>
	  </div>
	</div>

	<div class="container">
	<h2>Commençons par explorer par exemple...</h2>
	</div>
	<div class="container">
	<br><p>Recommandations futures.</p>
	</div>
	<br>

	
        
<iframe class="my-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>

    </body>
</html>