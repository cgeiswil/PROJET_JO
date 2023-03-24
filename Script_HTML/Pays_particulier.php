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

		$nbath = $bdd -> prepare('select etre_nationalite.id_pays, count(DISTINCT etre_nationalite.ID_athletes) as nbAth from etre_nationalite, athletes, pays_participants, olympiades
			where etre_nationalite.ID_athletes = athletes.ID_athletes
			and etre_nationalite.id_pays = pays_participants.Code_CIO
			and etre_nationalite.id_olympiade = olympiades.id_olympiade
			and etre_nationalite.id_pays = ?');

		$nbath -> execute([$pays]);
		$AthP = $nbath -> fetch();
		echo $AthP['nbAth'].": athlètes depuis le d&eacutebut des jeux olympiques modernes";


		$OlympOrg = $bdd -> prepare('select * from olympiades
			where olympiades.Code_CIO = ?');
		$OlympOrg -> execute([$pays]);
		$now = time();
		$Olpasse = array();
		$Olfutur = array();
		$OlenCours = array();
		
		/*while($Info = $OlympOrg -> fetch()){
			
			$RapportDebut = $now-$Info['date_ouverture'];
			$RapportFin = $now-$Info['date_fermeture'];
			
			if($RapportFin > 0 and $RapportDebut > 0){
				array_push($Olpasse, $Info['id_olympiade']);
			}	else{
				
				if($RapportFin < 0 and $RapportDebut < 0)
					array_push($Olfutur, $Info['id_olympiade']);
			}else{
				array_push($OlenCours, $Info['id_olympiade']);
			}
		}*/


		echo '<h2> Olympiades Organis&eacute;es </h2>';
		echo '<h4> Olympiades pass&eacute;e </h4>';
		echo '<table>';
		echo '<tr>';
		echo '<th> Ann&eacute;e</th>';
		echo '</tr>';
		foreach ($Olpasse as $infos ) {
			echo $infos;
		}



		$dtJO = 1721980800 ;
		$now = time();
		$dt = $now-$dtJO;
		echo $dt;
		/*if($dt < $dtJO){
			echo "dt plus petit";
		}else{
			echo "dt plus grand";
		}*/


		?>




	</body>
</html>

