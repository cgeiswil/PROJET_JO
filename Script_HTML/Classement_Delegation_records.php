<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Médailles/délégation</title>
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="./Styles/Vision_par_delegations.css" rel="stylesheet" type="text/css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<style type="text/css">
.containe{
	display: flex;
	justify-content : center;
	margin: auto;
	}
	h2,h5,p{
		text-align: center;
	}
	  a{

    color: black;
  }
 #discipline{
width:60px; 
  }
  .mascotte{
		position: fixed; bottom: 0px; left: 0px;
    	width: 300px;
    	height: 300px;
    	
    }
</style>
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

<body class="d-flex flex-column">
	<object data="Barre_de_navigation.html" width="100%" height="100%"></object>

	<h1 style='font-size: 50px;'><strong>Comparons par <span>d&eacute;l&eacute;gations</span></strong></h1>
	<h2 class='mt-1 mb-5'>Par disciplines, m&eacute;dailles ou records.</h2>


	<div class="containe">
	<div class="row">
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('disciplines').style.display='block'"><a href="Classement_Delegation_disciplines.php#disciplines" ><img src="../Images/Boutons/discipline.png" alt="erreur"></a>
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('médailleCIO').style.display='block'"><a href="Classement_Delegation_medailles.php#medailleCIO" >
				<img src="../Images/Boutons/medaille_or.png"></a>
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('records').style.display='block'"> <a href="Classement_Delegation_records.php?nom_discipline=Athletics#record" >
				<img src="../Images/Boutons/record_(podium,couronne).png"></a>
			</button>
		</div>
	</div>
</div>

  </div>
 </div>
	
	<div id = "records">
		<div class="container">
		<h1 id="record">Top 5 des d&eacute;l&eacute;gations par records</h1>
		<h2>Choisissez la discipline des records que vous voulez afficher :</h2>
    
		<table>
			<td><a href="Classement_Delegation_records.php?nom_discipline=Athletics#record"><button type="button" class="btn btn-info">Athl&eacute;tisme</button></a></td>
			<td><a href="Classement_Delegation_records.php?nom_discipline=Swimming#record"><button type="button" class="btn btn-info">Natation</button></a></td>
			<td><a href="Classement_Delegation_records.php?nom_discipline=Cycling#record"><button type="button" class="btn btn-info">Cyclisme</button></a></td>
			<td><a href="Classement_Delegation_records.php?nom_discipline=Weightlifting#record"><button type="button" class="btn btn-info">Halt&eacute;rophilie</button></a></td>
			<td><a href="Classement_Delegation_records.php?nom_discipline=Speed Skating#record"><button type="button" class="btn btn-info">Patinage de vitesse</button></a></td>
		</table>
		
		<div class="centre">
  		<a href="Graphique_record_<?php echo urlencode($_GET['nom_discipline']); ?>.php?sexe=H"><button type="button" class="btn btn-primary espace_button">Voir les graphiques des records de <?php echo ($_GET['nom_discipline'] != "" ? $_GET['nom_discipline'] : 'Athletics'); ?> : Homme</button></a>
  		<a href="Graphique_record_<?php echo urlencode($_GET['nom_discipline']); ?>.php?sexe=F"><button type="button" class="btn btn-primary espace_button">Voir les graphiques des records de <?php echo ($_GET['nom_discipline'] != "" ? $_GET['nom_discipline'] : 'Athletics'); ?> : Femme</button></a>
		</div>

		<?php	
			require("fonction.php");
			session_start();
			$bdd = getBDD();
			$discipline = ($_GET['nom_discipline'] != '' ? $_GET['nom_discipline'] : 'Athletics');
			$requete = "SELECT COUNT(`record olympique`) as 'record', pays_participants.nom_pays, disciplines.nom_discipline, pays_participants.I_drapeau
			FROM records, lier_r, etre_nationalite, pays_participants, epreuves, disciplines 
			WHERE records.id_record = lier_r.id_record 
			AND lier_r.id_athlete = etre_nationalite.ID_athletes 
			AND etre_nationalite.id_pays = pays_participants.Code_CIO 
			AND lier_r.id_epreuve = epreuves.id_epreuves 
			AND epreuves.id_disciplines = disciplines.id_discipline
			AND disciplines.nom_discipline = '$discipline'
			GROUP BY pays_participants.nom_pays, disciplines.nom_discipline, pays_participants.I_drapeau 
			ORDER BY `disciplines`.`nom_discipline` ASC, record DESC
			LIMIT 5";
			$resultat = $bdd->query($requete);


$pictogramme = $bdd->query("SELECT * FROM disciplines WHERE disciplines.nom_discipline = '$discipline'")->fetch();
// AJOUT DU COEUR

$id_discipline = $pictogramme['id_discipline'];
$image = "../Images/Boutons/Coeur_olympiades.jpg";

if (isset($_SESSION['utilisateur'])) {
    $aimer = $bdd->prepare('SELECT * FROM apprecier_d WHERE id_discipline = ? AND id_utilisateur = ?');
    $aimer->execute(array($id_discipline, $_SESSION['utilisateur']['utilisateur']));
    if ($aimer->fetch()) {
        $image = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
    }
}

echo ' <h1><img src="'.$pictogramme['pictogramme'].'" alt="Discipline ' . $discipline .'" class="img-thumbnail border-0" width="80px"> '.$discipline.' <img id="discipline" src="'.$image.'" alt="Coeur Discipline" height="30px; float ="/></h1>';
    

echo '<script type="text/javascript">
    var discipline = document.getElementById("discipline");
    discipline.addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "Classement_Delegation_records.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                discipline.src = "../Images/Boutons/Coeur_olympiades_rempli.jpg";
            } else {
                console.log("[ERREUR] Erreur de mise à jour des données !!!!");
            }
        };
        xhr.send("id_discipline='.$id_discipline.'&utilisateur='.$_SESSION['utilisateur']['utilisateur'].'");
    });
</script>';

if (isset($_POST['id_discipline'], $_POST['utilisateur'])) {
    $aimerBD = $bdd->prepare('INSERT INTO apprecier_d(id_discipline, id_utilisateur) VALUES (?, ?)');
    $aimerBD->execute(array($_POST['id_discipline'], $_POST['utilisateur']));
    unset($_POST['id_discipline'], $_POST['utilisateur']);
}
// FIN AJOUT DU COEUR
			
					if ($resultat->rowCount() > 0) {
						echo "<table>";
						echo "<tr><th></th><th></th><th> Pays</th><th> Nombre de records</th></tr>";
						$i=0;
						while($ligne = $resultat->fetch()) {
							echo "<tr>";
							echo "<td>".++$i."</td>";
						echo '<td><img src="'.$ligne['I_drapeau'].'" alt="Drapeau '.$ligne['nom_pays'].'" class="img-thumbnail border-0" width="100px"></td>';
						echo '<td><strong><a href="Pays_particulier.php?id='.$ligne['id_pays'].'">'.$ligne['nom_pays'].'</a></strong></td>';
							echo "<td><p><img src='../Images/Boutons/athlete_survol.png' alt='M&eacute;daille d\'or' width='40px'> ".$ligne['record']."</p></td>";
							echo "</tr>";
						}
						echo "</table>";
						}
						
		?>
		
	</div>
	</div>
		<img class="mascotte" onmouseout="this.src='../Images/Mascotte/mascottechapeau.png';" onmouseover="this.src='../Images/Mascotte/mascotte_discipline.png';" src="../Images/Mascotte/mascottechapeau.png"  alt="mascotte" />

<footer>	
    <?php
        include "pied_de_page.php";
    ?>
</body>
</html>