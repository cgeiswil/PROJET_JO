<!DOCTYPE html>
<html lang="fr">
<style>
    
</style>

<head>
    <title>Meilleurs athletes</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">      
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

</head>

<body>

		<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>

    <h1><center> Les meilleurs Athlètes de tous les temps </center></h1>
    <h2> <center>TOP 6 (toutes disciplines confondus)</center></h2>

    <div class="container">

		<br>

	<?php 
    // Connexion à votre base de données
    require("fonction.php");
    $bdd = getBDD();
    
    // Récupération de tous les athlètes et leur nombre de médailles d'or
    $athletes = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, athletes.sexe,
    COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, 
    COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar,
    COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Br
FROM athletes, lier_m, medailles 
where athletes.ID_athletes=lier_m.ID_athletes and lier_m.id_medaille=medailles.id_medaille
GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 3");
    $athletes->execute();
    
   
    
    echo '<div class="card-deck">';
    $i = 1;
    while ($i < 10 && $athlete = $athletes->fetch()) {

         // Récupération du pays de l'athlète
    $pays = $bdd->prepare("SELECT pays_participants.nom_pays, pays_participants.I_drapeau FROM pays_participants, etre_nationalite where etre_nationalite.id_pays=pays_participants.Code_CIO and etre_nationalite.ID_athletes=".$athlete['ID_athletes'].' Limit 3');
        // Exécution de la requête pour récupérer le pays de l'athlète
        $pays->execute();
        $resultat_pays = $pays->fetch();

        //Récupération de la discipline de l'athlete
    $discipline = $bdd->prepare("Select athletes.ID_athletes, disciplines.nom_discipline, disciplines.pictogramme From athletes, disciplines, lier_m, epreuves where athletes.ID_athletes=lier_m.ID_athletes and lier_m.id_epreuves=epreuves.id_epreuves and epreuves.id_disciplines=disciplines.id_discipline and athletes.ID_athletes=".$athlete['ID_athletes'] );
        // Exécution de la requête pour récupérer la discipline de l'athlète
        $discipline->execute();
        $resultat_discipline = $discipline->fetch();

        //Récupération du nombre de records de l'athlete
    $records = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, count(records.id_record) as nb_records FROM athletes, lier_r, records where athletes.ID_athletes=lier_r.id_athlete and lier_r.id_record=records.id_record and athletes.ID_athletes=".$athlete['ID_athletes']." GROUP BY athletes.ID_athletes, athletes.nom; ") ;
    // Exécution de la requête pour récupérer le nombre de records de l'athlete
    $records->execute();
    $r_records = $records->fetch();

        
        echo '<div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-0"><center><b>'.$i.' '. $athlete['nom'] . '</b></center></h4>
                    <h6 class="card-title mb-0 my-1"><img src="' . $resultat_pays['I_drapeau'] . '" alt="Drapeau ' . $resultat_pays['nom_pays'] . '" class="img-thumbnail border-0" width="40px">' . $resultat_pays['nom_pays'] . '</h6>';


        echo '<div class="row">';        
        echo '<div class="col-12">';
        echo '<table class="table">'; 
        echo '<tbody>';
					
						echo '<tr>
                            
							<th scope="row" ><img src="'.$resultat_discipline['pictogramme'].'"  alt="Discipline ' . $resultat_discipline['nom_discipline'] .'" class="img-thumbnail border-0" width="80px"> '.$resultat_discipline['nom_discipline'].'</th>
                            
                            <th>
							<td>
                            <img src="../Images/Boutons/medaille_or.png" alt="M&eacute;daille d\'or" width="20px"> <span><center>'.$athlete['nb_medailles_or'].'</center></span>
                            </td>

                            <td>
							<img src="../Images/Boutons/medaille_argent.png" alt="M&eacute;daille d\'argent" width="20px"> <span><center>'.$athlete['nb_medailles_Ar'].'</center></span>
                            </td>

                            <td>
							<img src="../Images/Boutons/medaille_bronze.png" alt="M&eacute;daille de bronze" width="20px"> <span><center>'.$athlete['nb_medailles_Br'].'</center></span>
                            </td>
							
						</th>';
					
				
				echo'</tbody>';
			  echo '</table>';
              echo '<div class="card">
                <div class="card-body">';
                 if($r_records['nb_records'] != NULL) {
                    echo '<p><strong>'.$athlete['nom'].'</strong> a déja battus <strong> '.$r_records['nb_records'].'</strong> records !
                    <br>Dernier record en date : ___';
                }else{
                    echo'<p><strong>'.$athlete['nom'].'</strong> n\'a jamais battus de records.';
                }

                echo'</div>
		  </div>
			</div>
		  </div>


                </div>
                </div>';
            $i++;       
    }
    echo '</div>';
    ?>
</body>

<footer >

    <object data="pied_de_page.html" width="100%" height="100%">
    </object>
  </footer>


</html>
