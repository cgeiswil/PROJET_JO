<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf8">
		<title> Pays </title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<style type="text/css">
		p{
		text-align: center;		
		}
		a{
		display: flex;
		justify-content: center;
		margin: auto;		
		}
		td{
		text-align: center;		
		}
		th{
		padding: 20px;
		text-align: center;
		color : red;
		}
		.tableau{
		display: flex;
		justify-content: center;
		margin: auto;
		}
		.titre{
		color:black;
		}

		</style> 


	</head>



	<body>
		

		<?php
		require('fonction.php');
		$bdd = getBDD();
		$req = $bdd -> prepare('select * FROM athletes, etre_nationalite, pays_participants, olympiades 
			WHERE athletes.ID_athletes = ?
			and etre_nationalite.ID_athletes = athletes.ID_athletes
			and etre_nationalite.id_olympiade = olympiades.id_olympiade
			and etre_nationalite.id_pays = pays_participants.Code_CIO');
		$req -> execute([$_GET['id']]);
		$Ath = $req -> fetch();
		//echo $Ath['nom'];

		echo '<body>
	  <iframe class="navbar" src="Barre_de_navigation.html" width="100%" height="5%" frameborder="0"></iframe>  
	  
	  <div class="container">
	    <div class="row">
	        <div class="col-md-12">';
	        
	        	echo '<img src= '.$Ath['I_drapeau'].' class= "float-right" alt= Logo JO'.$Ath['nom_pays'].' style="max-width: 200px; max height: 150px;">';
	        

						echo '<h1><strong> Athl&egrave;te : '.$Ath['nom'].'</strong>';
						echo '<button type="button" class="btn btn-lg bg-white text-danger border-0">';
				 		echo '<img src="../Images/Boutons/coeur_plein.svg" alt="Coeur rempli" />';
			   		echo "</button></h1>";
			   	echo '</div>';
			   echo '</div>';


			  $Med = $bdd -> prepare("select athletes.ID_athletes, athletes.nom, athletes.sexe,
			    COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, 
			    COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar,
			    COUNT(CASE WHEN medailles.type = 'Bronze' THEN 1 ELSE NULL END) AS nb_medailles_Br
			FROM athletes, lier_m, medailles 
			where athletes.ID_athletes=lier_m.ID_athletes and lier_m.id_medaille=medailles.id_medaille and athletes.ID_athletes = ?
			GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
			ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br");
			  $Med -> execute([$_GET['id']]);
			  $AthMed = $Med -> fetch();
			  
			  echo '<h2 class="tableau"> M&eacute;dailles obtenues </h2>';
			  echo '<table class="tableau">';
			  echo '<tr>';
			  echo '<th> <img src=../Images/Boutons/medaille_or.png alt= oups width="25px"></th>';
			  echo '<th> <img src=../Images/Boutons/medaille_argent.png alt= oups width="25px"></th>';
			  echo '<th> <img src=../Images/Boutons/medaille_bronze.png alt= oups width="25px"></th>';
				
			  echo '<th> <img src=../Images/Boutons/medaille_or.png alt= oups width="25px"><img src=../Images/Boutons/medaille_argent.png alt= oups width="25px"><img src=../Images/Boutons/medaille_bronze.png alt= oups width="25px"></th>';
			  echo '</tr>';
			  echo '<tr>';
			  echo '<td>'.$AthMed['nb_medailles_or'].'</td>';
			  echo '<td>'.$AthMed['nb_medailles_Ar'].'</td>';
			  echo '<td>'.$AthMed['nb_medailles_Br'].'</td>';
			  echo '<td>'.$AthMed['nb_medailles_or']+$AthMed['nb_medailles_Ar']+$AthMed['nb_medailles_Br'].'</td>';
			  echo '</tr>';
			  echo '</table>';


			  $Olymp = $bdd -> prepare('select * from olympiades, etre_nationalite, athletes, pays_participants
				  where athletes.ID_athletes = ?
				  and etre_nationalite.ID_athletes = athletes.ID_athletes
				  and etre_nationalite.id_pays = pays_participants.Code_CIO
				  and etre_nationalite.id_olympiade = olympiades.id_olympiade');
			  $Olymp -> execute($_GET['id']);

			  	echo '<h2 class="tableau"> Olympiades Particip&eacute;es </h2>';
				echo '<table>';
				echo '<tr>';
				echo '<th> Ann&eacute;e</th>';
				echo '<th> Ville h&ocirc;te </th>';
				echo "<th> Nombre d'athletes</th>";
				echo "<th> Nombre de discplines</th>";
				echo "<th> Nombre d'&eacute;preuves</th>";
				echo "<th> Nombre de d&eacute;l&eacute;gations</th>";
				echo "<th> Logo de l'olympiade </th>";
				echo '</tr>';

			  while($OlympP = $Olymp -> fetch()){


			  }

		

		?>