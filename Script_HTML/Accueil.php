<!DOCTYPE html>
<html lang="fr">
	<head>
    <title>Les JO Autrement</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link rel="stylesheet" href="Styles/accueil_css.css" type="text/css">        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">        
   <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
		spanblue{
			text-align:center;
			color: #194aa5;
		}
		span {
			 color:#00968D;	
		}
	</style>
   <script>
	$(document).ready(function() {
   	 $('.cycle-slideshow').cycle({
      	  fx: 'scrollVert', // effet de transition vertical
      	  speed: 500, // duree de la transition en ms
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
  <div class="divanecdote">
  <p style="display: flex; justify-content : center; font-size: 20px; color: #424240">Le Saviez-vous ?</p>
  
<?php
require("fonction.php");

$bdd = getBDD();

// AJOUT DU COEUR
session_start();

$anec = $bdd->query("SELECT * FROM anecdotes ORDER BY RAND() LIMIT 1");
$ligne = $anec->fetch();
$id_anecdote = $ligne['id_anecdote'];
$image = "../Images/Boutons/Coeur_olympiades.png";

if (isset($_SESSION['utilisateur'])) {
    $aimer = $bdd->prepare('SELECT * FROM apprecier_an WHERE id_anecdote = ? AND id_utilisateur = ?');
    $aimer->execute(array($id_anecdote, $_SESSION['utilisateur']['utilisateur']));
    if ($aimer->fetch()) {
        $image = "../Images/Boutons/Coeur_olympiades_rempli.png";
    }
}
echo '<div class="row">
    <div class="col-md-1">
	<p><img id="anecdote" src="'.$image.'" alt="Coeur Anecdote" height="60px"/>
    </div>
    <div class="col">
      <p>'.$ligne['anecdote'].'
      <a href="'.$ligne['source'].'">Source</a></p>
      <p style="color: #424240; font-size: 12px;">Likez les anecdotes et retrouvez-les dans votre profil !</p>
    </div>
  </div>';
echo "</div></p>";

echo '<script type="text/javascript">
    var anecdote = document.getElementById("anecdote");
    anecdote.addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "Accueil.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                anecdote.src = "../Images/Boutons/Coeur_olympiades_rempli.png";
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

	<div class="container mt-5" style="display: flex; justify-content: center;">
		<h2>Consultez les <spanblue>classements</spanblue> & <spanblue>&eacute;ditions</spanblue> des Jeux Olympiques</h2>
	</div>

	<div class="container justify-content-center mt-4">
	  <div class="row justify-content-center">
		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
		  <a href="./Meilleurs_athletes.php" target="_parent" class="btn btn-link">
			<img alt="Bouton page des meilleurs athletes" onmouseout="this.src='../Images/Boutons/athlete.png';" onmouseover="this.src='../Images/Boutons/athlete_survol.png';" src="../Images/Boutons/athlete.png" class="bouton"/>
			<br>
			<small class="text-muted">Les meilleurs athl&egrave;tes.</small>
		  </a>		 
		</div>
		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
		 <a href="./Vision_par_delegations.php" target="_parent" class="btn btn-link">
			<img alt="Bouton meilleures delegations" onmouseout="this.src='../Images/Boutons/podium_drapeau.png';" onmouseover="this.src='../Images/Boutons/podium_drapeau_survol.png';" src="../Images/Boutons/podium_drapeau.png" class="bouton"/>
			<br>
			<small class="text-muted">Les meilleures d&eacute;l&eacute;gations.</small>
		  </a>
		</div>
		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
		  <a href="./Vision_par_editions.php#carte" target="_parent" class="btn btn-link">
			<img alt="Bouton carte des editions" onmouseout="this.src='../Images/Boutons/carte.png';" onmouseover="this.src='../Images/Boutons/Carte_survol.png';" src="../Images/Boutons/carte.png" class="bouton"/>
			<br>
			<small class="text-muted">La carte des &eacute;ditions.</small>
		  </a>
		</div>
	  </div>
	  <div class="row justify-content-center">
		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
		  <a href="./Vision_par_editions.php#frise" target="_parent" class="btn btn-link">
			<img alt="Bouton frise des editions" onmouseout="this.src='../Images/Boutons/frise_survol.png';" onmouseover="this.src='../Images/Boutons/frise.png';" src="../Images/Boutons/frise_survol.png" class="bouton"/>
			<br>
			<small class="text-muted">La frise des &eacute;ditions.</small>
		  </a>
		</div>
		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
		  <a href="./Comparer.php" target="_parent" class="btn btn-link">
			<img alt="Bouton Comparer les editions" onmouseout="this.src='../Images/Boutons/Comparer_olympiades.jpg';" onmouseover="this.src='../Images/Boutons/Comparer_olympiades_survol.jpg';" src="../Images/Boutons/Comparer_olympiades.jpg" class="bouton"/>
			<br>
			<small class="text-muted">Comparer 2 &eacute;ditions.</small>
		  </a>
		</div>

		<div class="col-md-4 col-lg-4 mb-4 mb-md-0">
				<a href="./Bibliographie.php" target="_parent" class="btn btn-link ml-3">
			<img alt="Bouton Bibiliographie" onmouseout="this.src='../Images/Boutons/b_survol.png';" onmouseover="this.src='../Images/Boutons/b.png';" src="../Images/Boutons/b_survol.png" class="bouton"/>
			<br>
			<small class="text-muted">Les donn&eacute;es utilis&eacute;es.</small>
		  </a>
		</div>
	  </div>
	</div>


	<div class="container mt-5" style="display: flex; justify-content: center;">
	<h2 class="mt-3">Ou commencez &agrave; explorer avec un <spanblue>th&egrave;me pr&eacute;cis</spanblue> !</h2>
	</div>
	<div class="container mt-4">
	
<div class="card-deck">

	<div class="card">
		<div class="card-header"><b>Les olympiades...</b></div>
		  <div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>
			<?php
				$olympiades = $bdd->prepare('SELECT olympiades.id_olympiade, olympiades.logo, olympiades.annee_o, villes_hotes.nom FROM olympiades, apprecier_o, villes_hotes WHERE annee_o < 2017 AND villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY RAND() LIMIT 2');
				$olympiades->execute();
					
				if(isset($_SESSION['utilisateur'])){
					$test_olympiades = $bdd->prepare('SELECT * FROM apprecier_o WHERE apprecier_o.id_utilisateur = ? LIMIT 1');
					$test_olympiades->execute([$_SESSION['utilisateur']['utilisateur']]);
					
					if($test_olympiades->fetch()) {
						$olympiades = $bdd->prepare('SELECT olympiades.id_olympiade, olympiades.logo, olympiades.annee_o, villes_hotes.nom FROM olympiades, apprecier_o, villes_hotes WHERE  annee_o < 2017 AND apprecier_o.id_olympiade != olympiades.id_olympiade AND apprecier_o.id_utilisateur = ? AND villes_hotes.id_ville = olympiades.id_ville_hote ORDER BY RAND() LIMIT 1');
						$olympiades->execute([$_SESSION['utilisateur']['utilisateur']]);
						
						// Pays Organisateur que vous avez aimé
						$olympiades_p = $bdd->prepare('SELECT olympiades.id_olympiade, olympiades.logo, olympiades.annee_o, villes_hotes.nom, nom_pays FROM olympiades JOIN villes_hotes ON villes_hotes.id_ville = olympiades.id_ville_hote JOIN pays_participants ON olympiades.Code_CIO = pays_participants.Code_CIO WHERE olympiades.annee_o < 2017 AND olympiades.id_olympiade NOT IN(SELECT a.id_olympiade FROM apprecier_o a WHERE a.id_utilisateur = ?) AND pays_participants.Code_CIO IN(SELECT pp.Code_CIO FROM apprecier_p ap JOIN pays_participants pp ON pp.Code_CIO = ap.Code_CIO WHERE ap.id_utilisateur = ?) ORDER BY RAND() LIMIT 1');
						$olympiades_p ->execute(array($_SESSION['utilisateur']['utilisateur'],$_SESSION['utilisateur']['utilisateur']));
			
						while ($olympiade_pa = $olympiades_p->fetch()) {
							echo '<p><a href="Edition_particuliere.php?id='.$olympiade_pa["id_olympiade"].'" class="text-dark"><img src="'.$olympiade_pa['logo'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Edition_particuliere.php?id='.$olympiade_pa["id_olympiade"].'" class="text-dark"><b>Olympiade ' . $olympiade_pa['nom'] . ' ' . $olympiade_pa['annee_o'] . '</a></b>'.
							' <abbr title="Vous avez aimé le pays organisateur ('.$olympiade_pa['nom_pays'].') de cette olympiade !" class="tooltip-hover text-info"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
						}
					}
				}

				while ($olympiade = $olympiades->fetch()) {
					echo '<p><a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><img src="'.$olympiade['logo'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Edition_particuliere.php?id='.$olympiade["id_olympiade"].'" class="text-dark"><b>Olympiade ' . $olympiade['nom'] . ' ' . $olympiade['annee_o'] . '</a></b>'.
					' <abbr title="Un peu de d&eacute;couverte hors des chemins habituels." class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
				}

			?>		
			</div>
			<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez quelques secondes le curseur <abbr title="Les informations sur les recommandations s'affichent ici !" class="tooltip-hover text-info"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr> pour avoir des d&eacute;tails sur les recommandations.</small></p>
			</div>
		</div>
		
	<div class="card">
		<div class="card-header"><b>Les d&eacute;légations...</b></div>
		  <div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>
			<?php
				$pays_r = $bdd->prepare('SELECT * FROM pays_participants ORDER BY RAND() LIMIT 3');
				$pays_r->execute();
				
				if(isset($_SESSION['utilisateur'])){
					$test_pays_r = $bdd->prepare('SELECT * FROM apprecier_p WHERE apprecier_p.id_utilisateur = ? LIMIT 1');
					$test_pays_r->execute([$_SESSION['utilisateur']['utilisateur']]);
					
					if($test_pays_r->fetch()) {
						$pays_r = $bdd->prepare('SELECT pays_participants.Code_CIO, pays_participants.nom_pays, pays_participants.I_drapeau FROM pays_participants, apprecier_p WHERE apprecier_p.Code_CIO != pays_participants.Code_CIO AND apprecier_p.id_utilisateur = ? ORDER BY RAND() LIMIT 1');
						$pays_r->execute([$_SESSION['utilisateur']['utilisateur']]);
						
						// Olympiade que vous avez aimée
						$pays_r2 = $bdd->prepare('SELECT * FROM olympiades JOIN villes_hotes ON villes_hotes.id_ville = olympiades.id_ville_hote
						JOIN pays_participants ON olympiades.Code_CIO = pays_participants.Code_CIO WHERE olympiades.annee_o < 2017
						AND olympiades.id_olympiade IN(SELECT a.id_olympiade FROM apprecier_o a WHERE a.id_utilisateur = ?) 
						AND pays_participants.Code_CIO NOT IN(SELECT pp.Code_CIO FROM apprecier_p ap JOIN pays_participants pp ON pp.Code_CIO = ap.Code_CIO WHERE ap.id_utilisateur = ?) ORDER BY RAND() LIMIT 1');
						$pays_r2 ->execute(array($_SESSION['utilisateur']['utilisateur'],$_SESSION['utilisateur']['utilisateur']));
						
						while ($pays2 = $pays_r2->fetch()) {
							echo '<p><a href="Pays_particulier.php?id='.$pays2["Code_CIO"].'" class="text-dark"><img src="'.$pays2['I_drapeau'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$pays2["Code_CIO"].'" class="text-dark"><b> ' . $pays2['nom_pays'] . '</a></b>'.' <abbr title="Pays organisateur de '.$pays2['nom'] . ' ' . $pays2['annee_o'].', olympiade que vous avez aim&eacute;e !" class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
						}
						
						// Athlete que vous avez aimé
						$pays_r3 = $bdd->prepare('SELECT athletes.nom, pays_participants.Code_CIO, pays_participants.I_drapeau, pays_participants.nom_pays FROM pays_participants JOIN etre_nationalite ON pays_participants.Code_CIO = etre_nationalite.id_pays JOIN athletes ON athletes.ID_athletes = etre_nationalite.ID_athletes WHERE pays_participants.Code_CIO NOT IN(SELECT ppa.Code_CIO FROM apprecier_p p JOIN pays_participants ppa ON ppa.Code_CIO = p.Code_CIO WHERE p.id_utilisateur = ?) AND pays_participants.Code_CIO IN(SELECT pp.Code_CIO FROM apprecier_at ath JOIN athletes at_ ON at_.ID_athletes = ath.id_athlete JOIN etre_nationalite en ON en.ID_athletes = ath.id_athlete JOIN pays_participants pp ON pp.Code_CIO = en.id_pays WHERE ath.id_utilisateur = ?) ORDER BY RAND() LIMIT 1');
						$pays_r3 ->execute(array($_SESSION['utilisateur']['utilisateur'],$_SESSION['utilisateur']['utilisateur']));
						
						while ($pays3 = $pays_r3->fetch()) {
							echo '<p><a href="Pays_particulier.php?id='.$pays3["Code_CIO"].'" class="text-dark"><img src="'.$pays3['I_drapeau'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$pays3["Code_CIO"].'" class="text-dark"><b> ' . $pays3['nom_pays'] . '</a></b>'.' <abbr title="Vous aimez l\'athl&egrave;te '.$pays3['nom'].' de ce pays !" class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
						}
					}
				}

				while ($pays = $pays_r->fetch()) {
					echo '<p><a href="Pays_particulier.php?id='.$pays["Code_CIO"].'" class="text-dark"><img src="'.$pays['I_drapeau'].'" class="img-thumbnail border-0" width="40px"></a> <a href="Pays_particulier.php?id='.$pays["Code_CIO"].'" class="text-dark"><b> ' . $pays['nom_pays'] . '</a></b>'.' <abbr title="Un peu de d&eacute;couverte hors des chemins habituels." class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
				}
			?>		
			</div>
			<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez quelques secondes le curseur 	<abbr title="Les informations sur les recommandations s'affichent ici !" 
				class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr> pour avoir des d&eacute;tails sur les recommandations.</small></p>
			</div>
	</div>
	
	<div class="card">
		<div class="card-header"><b>Les athl&egrave;tes...</b></div>
		<div class="card-body">
			<h5 class="card-title">Vous allez aimer</h5>		
			<?php			
				$athletes = $bdd->prepare('SELECT * FROM athletes ORDER BY RAND() LIMIT 3');
				$athletes->execute();
				
				if(isset($_SESSION['utilisateur'])){
					$test_athletes = $bdd->prepare('SELECT * FROM apprecier_at WHERE apprecier_at.id_utilisateur = ? ORDER BY RAND() LIMIT 1');
					$test_athletes ->execute([$_SESSION['utilisateur']['utilisateur']]);
					if($test_athletes->fetch()) {
						$athletes = $bdd->prepare('SELECT * FROM athletes, apprecier_at WHERE apprecier_at.id_athlete != athletes.ID_athletes	
						AND apprecier_at.id_utilisateur = ? ORDER BY RAND() LIMIT 2');
						$athletes->execute([$_SESSION['utilisateur']['utilisateur']]);
					}
				}
					
				while ($athlete = $athletes->fetch()) {
					echo '<p><img src="../Images/Boutons/athlete.png" class="img-thumbnail border-0" width="40px"> <b><a href="Athletes.php?id='.$athlete["ID_athletes"].'" class="text-dark">' . $athlete['nom'] . '</a></b>'.' <abbr title="Un peu de d&eacute;couverte hors des chemins habituels." class="tooltip-hover">
					<img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr></p>';
				}
			?>	
		</div>
					<div class="card-footer bg-transparent">
				<p class="card-text mb-2"><small class="text-muted">Survolez quelques secondes le curseur 	<abbr title="Les informations sur les recommandations s'affichent ici !" 
				class="tooltip-hover"><img style="width: 20px;" src="../Images/Boutons/interface_utilisateur.png" alt="Image de survol"></abbr> pour avoir des d&eacute;tails sur les recommandations.</small></p>
			</div>
	</div>
</div> <!-- Fin du tableau des recommandations -->
	
	
	
</div>
	<footer class='mt-5'>
	<?php
		include "pied_de_page.php";
	?>
	</footer>

</body>
</html>