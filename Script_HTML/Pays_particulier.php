<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf8">
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	</head>
	<body>

		<?php
		require('fonction.php');
		$pays = $_GET['id'];
		//echo $pays;


		$bdd = getBDD();
		$informationPP = $bdd -> prepare('select * from pays_participants Where Code_CIO = ?');
		$informationPP -> execute([$pays]);
		$ligne = $informationPP -> fetch();

		echo '<body>

  <iframe class="navbar" src="Barre_de_navigation.html" width="100%" height="5%" frameborder="0"></iframe>  
  
  <div class="container">
    <div class="row">
        <div class="col-md-12">';
        	echo '<img src= '.$ligne['I_drapeau'].' class= "float-right" alt= Logo JO'.$ligne['nom_pays'].' style="max-width: 200px; max height: 150px;">';
        

					echo '<h1><strong> Pays : '.$ligne['nom_pays'].'</strong>';
					echo '<button type="button" class="btn btn-lg bg-white text-danger border-0">';
			 		echo '<img src="../Images/Boutons/coeur_plein.svg" alt="Coeur rempli" />';
		   		echo "</button></h1>";
		   	echo '</div>';
		   echo '</div>';

		$nbath = $bdd -> prepare('select etre_nationalite.id_pays, count(DISTINCT etre_nationalite.ID_athletes) as nbAth from etre_nationalite, athletes, pays_participants, olympiades
			where etre_nationalite.ID_athletes = athletes.ID_athletes
			and etre_nationalite.id_pays = pays_participants.Code_CIO
			and etre_nationalite.id_olympiade = olympiades.id_olympiade
			and etre_nationalite.id_pays = ?');

		$nbath -> execute([$pays]);
		$AthP = $nbath -> fetch();
		echo $AthP['nbAth'].": athlètes depuis le d&eacutebut des jeux olympiques modernes";


		$OlympOrg = $bdd -> prepare('select * from olympiades, villes_hotes
			where olympiades.Code_CIO = ?
			and villes_hotes.id_ville = olympiades.id_ville_hote
       ORDER By olympiades.annee_o');
		$OlympOrg -> execute([$pays]);
		$now = time();
		$Olpasse = array();
		$Olfutur = array();
		$OlenCours = array();


		echo '<h2> Olympiades Organis&eacute;es </h2>';
		echo '<table>';
		echo '<tr>';
		echo '<th> Ann&eacute;e</th>';
		echo '<th> Ville h&ocirc;te </th>';
		echo "<th> Nombre d'athletes</th>";
		echo "<th> Nombre de discplines</th>";
		echo "<th> Nombre d'&eacute;preuves</th>";
		echo "<th> Nombre de d&eacute;l&eacute;gations</th>";
		echo '</tr>';
		foreach ($OlympOrg as $infos ) {
			$NbAthEd = $bdd -> prepare("select count(DISTINCT athletes.ID_athletes) as nbAth from athletes, etre_nationalite, pays_participants, olympiades
				where athletes.ID_athletes = etre_nationalite.ID_athletes
				and olympiades.id_olympiade = etre_nationalite.id_olympiade
				and pays_participants.Code_CIO = pays_participants.Code_CIO
				and olympiades.id_olympiade = ?");
			$NbAthEd -> execute([$infos['id_olympiade']]);
			$nbath = $NbAthEd -> fetch();

			echo '<tr>';
			echo '<td>'.$infos['annee_o'].'</td>';
			echo '<td> <a href="Vision_par_editions.php?view=p&lat='.$infos['latitude_pays'].'&lon='.$infos['longitude_pays'].'#carte" class="text-primary">'.$infos['nom'].'</a> </td>';
			echo '<td>'.$nbath['nbAth'].'</td>';
			echo '<td>'.$infos['nb_discplines'].'</td>';
			echo '<td>'.$infos['nb_sports'].'</td>';
			echo '<td>'.$infos['nb_delegations'].'</td>';
			echo '</tr>';
		}




		?>




	</body>
</html>
