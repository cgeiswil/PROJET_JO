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
		</style> 


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
		$NbOl = $bdd -> prepare('select count(DISTINCT olympiades.id_olympiade) as nb from olympiades, athletes, etre_nationalite, pays_participants
			where etre_nationalite.ID_athletes = athletes.ID_athletes
			and etre_nationalite.id_pays = pays_participants.Code_CIO
			and olympiades.id_olympiade = etre_nationalite.id_olympiade
			and etre_nationalite.id_pays = ?');
		$NbOl -> execute([$pays]);
		$NbOligne = $NbOl -> fetch();


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
		echo "Nombre d'&eacute;dition particip&eacute; : ".$NbOligne['nb'];





		echo '<br><br><br>';
		   echo '<h2 class="tableau"> Tableau historique des m&eacute;dailles </h2>';

	$MedOr = $bdd -> prepare('select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
from (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
        from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes and
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                  and medailles.type = "Gold"
    			and etre_nationalite.id_pays = ?
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
        ORDER BY etre_nationalite.id_pays ASC
	) as requete_imbriquee
	group by requete_imbriquee.id_pays 
	order by  nb_medailles  DESC'); 
	$MedOr -> execute([$pays]);
	$Or = $MedOr -> fetch();

	$MedAr = $bdd -> prepare('select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
	from (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
        from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes and
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                  and medailles.type = "Silver"
    			and etre_nationalite.id_pays = ?
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
        ORDER BY etre_nationalite.id_pays ASC
	) as requete_imbriquee
	group by requete_imbriquee.id_pays 
	order by  nb_medailles  DESC'); 
	$MedAr -> execute([$pays]);
	$Ar = $MedAr -> fetch();




	$MedBr = $bdd -> prepare('select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
	from (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
        from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes and
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                  and medailles.type = "Bronze"
    			and etre_nationalite.id_pays = ?
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
        ORDER BY etre_nationalite.id_pays ASC
	) as requete_imbriquee
	group by requete_imbriquee.id_pays 
	order by  nb_medailles  DESC'); 
	$MedBr -> execute([$pays]);
	$Br = $MedBr -> fetch();


	echo '<table class="tableau">';
	echo '<tr>';
	echo '<th> <img src=../Images/Boutons/medaille_or.png alt= oups width="25px"></th>';
	echo '<th> <img src=../Images/Boutons/medaille_argent.png alt= oups width="25px"></th>';
	echo '<th> <img src=../Images/Boutons/medaille_bronze.png alt= oups width="25px"></th>';
	echo '</tr>';
	echo '<tr>';

	echo '<td><p>'.$Or['nb_medailles'].'</p></td>';
	
	
	echo '<td> <p>'.$Ar['nb_medailles'].'</p></td>';
	
	
	echo '<td> <p margin = "auto">'.$Br['nb_medailles'].'</p></td>';
	
	echo '</tr>';
	echo '<table>';




	//Ajout de l'évolution des médailles en fonction du temps. 




	echo "<h2 class='tableau'> Les meilleurs athlètes de l'histoire </h2>";

	$MeilAth = $bdd -> prepare('select athletes.ID_athletes, athletes.nom, athletes.sexe, etre_nationalite.id_pays,
    COUNT(CASE WHEN medailles.type = "Gold" THEN 1 ELSE NULL END) AS nb_medailles_or, 
    COUNT(CASE WHEN medailles.type = "Silver" THEN 1 ELSE NULL END) AS nb_medailles_Ar,
    COUNT(CASE WHEN medailles.type = "Bronze" THEN 1 ELSE NULL END) AS nb_medailles_Br
FROM athletes, lier_m, medailles, etre_nationalite, epreuves, olympiades
where athletes.ID_athletes=lier_m.ID_athletes 
and lier_m.id_medaille=medailles.id_medaille
and lier_m.id_olympiade = olympiades.id_olympiade
and lier_m.id_epreuves = epreuves.id_epreuves
and etre_nationalite.id_pays = ?
and etre_nationalite.ID_athletes = athletes.ID_athletes
and etre_nationalite.id_olympiade = olympiades.id_olympiade
GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 5');
	$MeilAth -> execute([$pays]);

	echo '<table class="tableau">';
	echo '<tr>';
	echo '<th> classement </th>';
	echo '<th> Nom </th>';
	echo '<th> <img src=../Images/Boutons/medaille_or.png alt= oups width="25px"></th>';
	echo '<th> <img src=../Images/Boutons/medaille_argent.png alt= oups width="25px"></th>';
	echo '<th> <img src=../Images/Boutons/medaille_bronze.png alt= oups width="25px"></th>';
	//echo "<th> Nombre de m&eacute;dailles d'OR </th>";
	//echo "<th> Nombre de m&eacute;dailles d'ARGENT </th>";
	//echo "<th> Nombre de m&eacute;dailles de BRONZE </th>";
	echo "<th> Nombre de m&eacute;dailles Total</th>";
	echo '</tr>';
	$classement = 1;
	foreach($MeilAth as $Ath){
		$medTot = $Ath['nb_medailles_or']+$Ath['nb_medailles_Ar']+$Ath['nb_medailles_Br'];
		echo '<tr>';
		echo "<td>".$classement."</td>";
		echo "<td>".$Ath['nom']."</td>";
		echo "<td>".$Ath['nb_medailles_or']."</td>";
		echo "<td>".$Ath['nb_medailles_Ar']."</td>";
		echo "<td>".$Ath['nb_medailles_Br']."</td>";
		echo "<td>".$medTot."</td>";
		echo '</tr>';
		$classement += 1;
	}
	echo '</table>';



		

	echo '<br><br><br>';
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
		echo "<th> Logo de l'olympiade </th>";
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
			echo '<td><img src="'.$infos['logo'].'" class="img-thumbnail border-0" width="150px"></td>';

			echo '</tr>';
		}
		echo '</table>';

		



		?>




	</body>
</html>
