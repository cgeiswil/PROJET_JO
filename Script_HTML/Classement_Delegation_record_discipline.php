<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Les JO Autrement</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Styles/quiz.css" type="text/css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">   
		<style type="text/css">
		img{
		width: 135px;
		height: 80px;		
		}
		p{
		text-align: center;		
		}
		a{
		display: flex;
		justify-content: center;
		margin: auto;		
		}
		</style> 
	</head>
	<body>

		<object data="Barre_de_navigation.html" width="100%" height="100%">
		</object>

		<h1>Record de la discipline : <?php echo $_GET['nom_discipline']; ?></h1>

		<?php	
			require("fonction.php");
			$bdd = getBDD();
			$discipline = $_GET['nom_discipline'];
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
		LIMIT 3";
			 $resultat = $bdd->query($requete);
    if ($resultat->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>Drapeau</th><th>Pays</th><th>Nombre de records</th></tr>";
        while($ligne = $resultat->fetch()) {
            echo "<tr>";
            echo "<td><img src='".$ligne['I_drapeau']."' alt='drapeau'></td>";
            echo "<td><p>".$ligne['nom_pays']."</p></td>";
            echo "<td><p>".$ligne['record']."</p></td>";
            echo "</tr>";
        }
        echo "</table>";
        }
				
		?>
		<br>
	<a href="Classement_Delegation_record.html"><button type="button" class="btn btn-primary">Retour vers le choix des disciplines</button></a>

		<div class="footer">
			<object  data="Pied_de_page.html" width="100%" height="100%">
			</object>
		</div>

	</body>
</html>