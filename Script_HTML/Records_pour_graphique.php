<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Records pour graphique</title>
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
	h2{
		text-align: center;
	}
</style>
	
</head>

<body class="d-flex flex-column">
	<object data="Barre_de_navigation.html" width="100%" height="100%"></object>
	<h1>Comparons par <span>délégations</span></h1>
	<br>
	<br>
	<br>
	<br>

	<div class="containe">
	<div class="row">
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('disciplines').style.display='block'">
				<img src="../Images/Boutons/discipline.png" alt="erreur">
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('médailleCIO').style.display='block'">
				<img src="../Images/Boutons/medaille_or.png">
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('records').style.display='block'">
				<img src="../Images/Boutons/record_(podium,couronne).png">
			</button>
		</div>
	</div>
</div>
 
<div id = "records">
		<div class="container">
		<h1 id="record">Top 3 des d&eacute;l&eacute;gations par records</h1>
		<h2>Choisissez la discipline des records que vous voulez afficher :</h2>
    
		<table>
			<td><a href="Vision_par_delegations_2.php?nom_discipline=Athletics#record"><button type="button" class="btn btn-info">Athletics</button></a></td>
			<td><a href="Vision_par_delegations_2.php?nom_discipline=Swimming#record"><button type="button" class="btn btn-info">Swimming</button></a></td>
			<td><a href="Vision_par_delegations_2.php?nom_discipline=Cycling#record"><button type="button" class="btn btn-info">Cycling</button></a></td>
			<td><a href="Vision_par_delegations_2.php?nom_discipline=Weightlifting#record"><button type="button" class="btn btn-info">Weightlifting</button></a></td>
			<td><a href="Vision_par_delegations_2.php?nom_discipline=Speed Skating#record"><button type="button" class="btn btn-info">Speed Skating</button></a></td>
		</table>

	

		<?php	
			require("fonction.php");
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
			LIMIT 10";
			$resultat = $bdd->query($requete);
			
			$pictogramme = ($bdd->query("SELECT * FROM disciplines WHERE disciplines.nom_discipline = '$discipline'"))->fetch();
			echo '<h1><img src="'.$pictogramme['pictogramme'].'"  alt="Discipline ' . $discipline .'" class="img-thumbnail border-0" width="80px"> '.$discipline.'</h1>';
			
					if ($resultat->rowCount() > 0) {
						echo "<table>";
						echo "<tr><th></th><th>Pays</th><th>Nombre de records</th></tr>";
						$i=0;
						while($ligne = $resultat->fetch()) {
							echo "<tr>";
							echo "<td>".++$i."</td>";
							echo '<td><img src="'.$ligne['I_drapeau'].'" alt="Drapeau '.$ligne['nom_pays'].'" class="img-thumbnail border-0" width="100px">'.$ligne['nom_pays'];
							echo "<td><p><img src='../Images/Boutons/athlete_survol.png' alt='M&eacute;daille d\'or' width='40px'> ".$ligne['record']."</p></td>";
							echo "</tr>";
						}
						echo "</table>";
						}
						
		?>
		
	</div>
	</div>
	</div>
</body>
</html>