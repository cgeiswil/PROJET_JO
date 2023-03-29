<!DOCTYPE html>
<html lang="fr">
	<head>
    <title>Les JO Autrement</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">        
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</head>
    <body>

    	
    

	<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>
	
    <h1>Explorons les jeux olympiques <br> différemment !</h1>
    
    <div class="gif">
   <div class="cycle-slideshow">
  <div class="cycle-slide">
  <div class="divanecdote">
  <p>Le Saviez-vous ?</p>
<?php
require("fonction.php");

$bdd = getBDD();

// AJOUT DU COEUR
session_start();

$anec = $bdd->query("SELECT * FROM anecdotes ORDER BY RAND() LIMIT 1");
$ligne = $anec->fetch();
$id_anecdote = $ligne['id_anecdote'];
$image = "../Images/Boutons/Coeur_olympiades.jpg";

if (isset($_SESSION['utilisateur'])) {
    $aimer = $bdd->prepare('SELECT * FROM apprecier_an WHERE id_anecdote = ? AND id_utilisateur = ?');
    $aimer->execute(array($id_anecdote, $_SESSION['utilisateur']['utilisateur']));
    if ($aimer->fetch()) {
        $image = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
    }
}

echo "<p>".$ligne['anecdote'];
echo " <a href='".$ligne['source']."'>Source.</a>";
echo "<div class='float-right'>";
echo '<img id="anecdote" src="'.$image.'" alt="Coeur Anecdote" height="60px"/>';
echo "</div></p>";

echo '<script type="text/javascript">
    var anecdote = document.getElementById("anecdote");
    anecdote.addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "Accueil.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                anecdote.src = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
            } else {
                console.log("[ERREUR] Erreur de mise à jour des données !!!!");
            }
        };
        xhr.send("id_anecdote='.$id_anecdote.'&utilisateur='.$_SESSION['utilisateur']['utilisateur'].'");
    });
</script>';

if (isset($_POST['id_anecdote'], $_POST['utilisateur'])) {
    $aimerBD = $bdd->prepare('INSERT INTO apprecier_an(id_anecdote, id_utilisateur) VALUES (?, ?)');
    $aimerBD->execute(array($_POST['id_anecdote'], $_POST['utilisateur']));
    unset($_POST['id_anecdote'], $_POST['utilisateur']);
}
// FIN AJOUT DU COEUR
?>

</div>
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