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

    

    <?php 
	echo "<div class='container'>
	<h1><center> Les meilleurs athl&egrave;tes de tous les temps </center></h1>";
		
		
    // Connexion à votre base de données
    require("fonction.php");
    $bdd = getBDD();

         // Récupération de toutes les disciplines
    $req = $bdd->prepare("select disciplines.nom_discipline, disciplines.id_discipline from disciplines; "); // Peut etre changer pour ajouter des disciplines 
    $req->execute();

    echo "<h2> <center>TOP 6 </center> </h2>";

    $sport = ($_GET['sport'] != '' ? $_GET['sport'] : 'Toutes disciplines confondues');

    echo "<form method='get' id='myForm'>";
echo "<div class='form-group'>";
echo "<label for='sport'><h3><center>Choisir une discipline :</center></h3></label>";
echo "<select class='form-control' id='sport' name='sport' onchange='submitForm()'>";
echo "<option value='".$sport."'>".$sport." </option>";
while ($dis = $req->fetch()){
    echo "<option value='".$dis['nom_discipline']."'>".$dis['nom_discipline']."</option>";
}
echo "<option value='Toutes disciplines confondues'>Toutes disciplines confondues </option>";
echo "</select>";
echo "</div>";
echo "</form>";
//bouton comparer et coeur de la discipline

echo "<script>";
echo "function submitForm() {";
echo "  document.getElementById('myForm').submit();";
echo "}";
echo "</script>";



    
if(isset($sport)){

    if ($sport == 'Toutes disciplines confondues') {
        // Toutes disciplines confondues

    // Récupération de tous les athlètes et leur nombre de médailles d'or
    $athletes = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, athletes.sexe,
    COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, 
    COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar,
    COUNT(CASE WHEN medailles.type = 'Bronze' THEN 1 ELSE NULL END) AS nb_medailles_Br
FROM athletes, lier_m, medailles 
where athletes.ID_athletes=lier_m.ID_athletes and lier_m.id_medaille=medailles.id_medaille
GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 3");
    $athletes->execute();
    }else{
        // Pour une discipline spécifique
        $athletes = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, athletes.sexe,
        COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, 
        COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar,
        COUNT(CASE WHEN medailles.type = 'Bronze' THEN 1 ELSE NULL END) AS nb_medailles_Br
    FROM athletes, lier_m, medailles, epreuves, disciplines
    where athletes.ID_athletes=lier_m.ID_athletes 
    and lier_m.id_medaille=medailles.id_medaille
    and lier_m.id_epreuves = epreuves.id_epreuves
    and epreuves.id_disciplines = disciplines.id_discipline
    and disciplines.nom_discipline = '".$sport."'
    GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
    ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 3;");
    $athletes->execute();
    } 
}else{ echo "erreur";} 

    
    echo '<div class="card-deck">';
    $i = 1;
    while ($i <= 3 && $athlete = $athletes->fetch()) {

         // Récupération du pays de l'athlète
    $pays = $bdd->prepare("SELECT pays_participants.nom_pays, pays_participants.I_drapeau, pays_participants.Code_CIO FROM pays_participants, etre_nationalite where etre_nationalite.id_pays=pays_participants.Code_CIO and etre_nationalite.ID_athletes=".$athlete['ID_athletes'].' Limit 3');
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

    //Récupération des derniers reccords en date
    $last_r = $bdd->prepare("SELECT olympiades.annee_o, `record olympique`, records.unite, `stade de la compétition`, epreuves.epreuves from olympiades,lier_r,records,athletes,epreuves where records.id_record = lier_r.id_record and lier_r.id_olympiade = olympiades.id_olympiade and lier_r.id_athlete = athletes.ID_athletes and lier_r.id_epreuve = epreuves.id_epreuves and athletes.ID_athletes = ".$athlete['ID_athletes']." and `stade de la compétition` = 'final' order by annee_o DESC, epreuves.epreuves limit 1") ;
    $last_r->execute();
    $last_r = $last_r->fetch();

        
        echo '<div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-0"><center><b>'.$i.' '. $athlete['nom'] . '</b></center></h4>';
                   //bouton coeur athletes 
                   echo' <h6 class="card-title mb-0 my-1"><a href="Pays_particulier.php?id='.$resultat_pays['Code_CIO'].'"style="color: black;"><img src="' . $resultat_pays['I_drapeau'] . '" alt="Drapeau ' . $resultat_pays['nom_pays'] . '" class="img-thumbnail border-0" width="40px"><strong>' . $resultat_pays['nom_pays'] . '</strong></a></h6>';


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
        // Récupération des sports ou on comptabilise des records
    $rr = $bdd->prepare("select disciplines.nom_discipline from disciplines, epreuves,lier_r, records where disciplines.id_discipline = epreuves.id_disciplines and epreuves.id_epreuves = lier_r.id_epreuve and lier_r.id_record = records.id_record group by disciplines.nom_discipline; ");
        // Exécution de la requête 
        $rr->execute();

        $sports = $rr->fetchAll(PDO::FETCH_COLUMN);

        if (in_array($sport, $sports) || $sport == 'Toutes disciplines confondues' ) {

            // carte d'affichage des records de cet athlete
              echo '<div class="card">
                <div class="card-body">';
                 if($r_records['nb_records'] != NULL) {
                    echo '<p><strong>'.$athlete['nom'].'</strong> a déja battus <strong> '.$r_records['nb_records'].'</strong> records !<br>
                    <br><u>Dernier record en date :</u> ';
                    echo "<table><tr>";
                    echo "<td>".$last_r['epreuves']."</td><td>".$last_r['annee_o']."</td></tr>";
                    echo "<td><strong>".$last_r['record olympique']."</strong> (".$last_r['unite'].")</td><td>".$last_r['stade de la compétition']."</td></tr>";
                    echo "</table>";
                }else{
                    echo'<p><strong>'.$athlete['nom'].'</strong> n\'a jamais battus de records.';
                }

                echo'</div>
		  </div>';
            }else{
                echo "Pas de records enregistrées pour cette discipline.";
            }

            // Récupération des olympades auquels l'athlete à participés
            $olympiades = $bdd->prepare("select olympiades.annee_o, olympiades.logo, villes_hotes.nom from olympiades, etre_nationalite, villes_hotes WHERE villes_hotes.id_ville = olympiades.id_ville_hote and olympiades.id_olympiade = etre_nationalite.id_olympiade and etre_nationalite.ID_athletes =".$athlete['ID_athletes']);
             $olympiades->execute();

             //Récupération du nombre de participation 
             $chiffres_significatifs_1 = $bdd->prepare("select count(DISTINCT olympiades.annee_o) as nbo from olympiades, etre_nationalite, villes_hotes, lier_m, medailles WHERE villes_hotes.id_ville = olympiades.id_ville_hote and olympiades.id_olympiade = etre_nationalite.id_olympiade and etre_nationalite.ID_athletes =".$athlete['ID_athletes']);
             $chiffres_significatifs_1->execute();
            
             //Récupération du nombre de médailles recus au total
             $chiffres_significatifs_2 = $bdd->prepare("SELECT count( DISTINCT id_olympiade) as nbm FROM lier_m, athletes where lier_m.ID_athletes = athletes.ID_athletes and id_medaille != 4 and athletes.ID_athletes =".$athlete['ID_athletes']);
             $chiffres_significatifs_2->execute();

        $olympe = $olympiades->fetchAll();
        $cs1 = $chiffres_significatifs_1->fetchAll();
        $cs2 = $chiffres_significatifs_2->fetchAll();
            // carte d'affichage des olympliades auquels cet athlete à participer
            echo '<div class="card"><div class="card-body">';
                
                echo "Participation à <strong>".$cs1[0]['nbo']."</strong> olympiades <br>(dont <strong>".$cs2[0]['nbm']."</strong> m&eacute;daill&eacute;".($cs2[0]['nbm'] > 1 ? "es" : "e").").<br>";
                foreach ($olympe as $ligne) {
                    echo '<br><img src="'.$ligne['logo'].'" class="img-thumbnail border-0" width="40px"> '.$ligne['nom'].' '.$ligne['annee_o'];
                }

		  echo "</div></div></div></div>


                </div>
                </div>";
            $i++;       
    }
    echo '</div>';

 
    
   //////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    
 

    if ($sport == 'Toutes disciplines confondues') {
        // Toutes disciplines confondues

    // Récupération de tous les athlètes et leur nombre de médailles d'or
    $athletes2 = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, athletes.sexe, COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar, COUNT(CASE WHEN medailles.type = 'Bronze' THEN 1 ELSE NULL END) AS nb_medailles_Br FROM athletes, lier_m, medailles where athletes.ID_athletes=lier_m.ID_athletes and lier_m.id_medaille=medailles.id_medaille GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 3 offset 3; ");
    $athletes2->execute();
    }else{
        // Pour une discipline spécifique
        $athletes2 = $bdd->prepare("SELECT athletes.ID_athletes, athletes.nom, athletes.sexe,
        COUNT(CASE WHEN medailles.type = 'Gold' THEN 1 ELSE NULL END) AS nb_medailles_or, 
        COUNT(CASE WHEN medailles.type = 'Silver' THEN 1 ELSE NULL END) AS nb_medailles_Ar,
        COUNT(CASE WHEN medailles.type = 'Bronze' THEN 1 ELSE NULL END) AS nb_medailles_Br
    FROM athletes, lier_m, medailles, epreuves, disciplines
    where athletes.ID_athletes=lier_m.ID_athletes 
    and lier_m.id_medaille=medailles.id_medaille
    and lier_m.id_epreuves = epreuves.id_epreuves
    and epreuves.id_disciplines = disciplines.id_discipline
    and disciplines.nom_discipline = '".$sport."'
    GROUP BY athletes.ID_athletes, athletes.nom, athletes.sexe
    ORDER BY nb_medailles_or DESC, nb_medailles_Ar DESC, nb_medailles_Br DESC limit 3 offset 3;");
    $athletes2->execute();
    } 


    
    echo '<div class="card-deck">';
    $i = 4;
    while ($i <= 6 && $athlete = $athletes2->fetch()) {

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

    //Récupération des derniers reccords en date
    $last_r = $bdd->prepare("SELECT olympiades.annee_o, `record olympique`, records.unite, `stade de la compétition`, epreuves.epreuves from olympiades,lier_r,records,athletes,epreuves where records.id_record = lier_r.id_record and lier_r.id_olympiade = olympiades.id_olympiade and lier_r.id_athlete = athletes.ID_athletes and lier_r.id_epreuve = epreuves.id_epreuves and athletes.ID_athletes = ".$athlete['ID_athletes']." and `stade de la compétition` = 'final' order by annee_o DESC, epreuves.epreuves limit 1") ;
    $last_r->execute();
    $last_r = $last_r->fetch();

        
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
        // Récupération des sports ou on comptabilise des records
    $rr = $bdd->prepare("select disciplines.nom_discipline from disciplines, epreuves,lier_r, records where disciplines.id_discipline = epreuves.id_disciplines and epreuves.id_epreuves = lier_r.id_epreuve and lier_r.id_record = records.id_record group by disciplines.nom_discipline; ");
        // Exécution de la requête 
        $rr->execute();
        //$rre = $rr->fetch();

        $sports = $rr->fetchAll(PDO::FETCH_COLUMN);

        if (in_array($sport, $sports) || $sport == 'Toutes disciplines confondues' ) {


              echo '<div class="card">
                <div class="card-body">';
                 if($r_records['nb_records'] != NULL) {
                    echo '<p><strong>'.$athlete['nom'].'</strong> a déja battus <strong> '.$r_records['nb_records'].'</strong> records !<br>
                    <br><u>Dernier record en date :</u> ';
                    echo "<table><tr>";
                    echo "<td>".$last_r['epreuves']."</td><td>".$last_r['annee_o']."</td></tr>";
                    echo "<td><strong>".$last_r['record olympique']."</strong> (".$last_r['unite'].")</td><td>".$last_r['stade de la compétition']."</td></tr>";
                    echo "</table>";
                }else{
                    echo'<p><strong>'.$athlete['nom'].'</strong> n\'a jamais battus de records.';
                }

                echo'</div>
		  </div>';
            }else{
                echo "Pas de records enregistrées pour cette discipline.";
            }
            // Récupération des olympades auquels l'athlete à participés
            $olympiades = $bdd->prepare("select olympiades.annee_o, olympiades.logo, villes_hotes.nom from olympiades, etre_nationalite, villes_hotes WHERE villes_hotes.id_ville = olympiades.id_ville_hote and olympiades.id_olympiade = etre_nationalite.id_olympiade and etre_nationalite.ID_athletes =".$athlete['ID_athletes']);
             $olympiades->execute();

             //Récupération du nombre de participation 
             $chiffres_significatifs_1 = $bdd->prepare("select count(DISTINCT olympiades.annee_o) as nbo from olympiades, etre_nationalite, villes_hotes, lier_m, medailles WHERE villes_hotes.id_ville = olympiades.id_ville_hote and olympiades.id_olympiade = etre_nationalite.id_olympiade and etre_nationalite.ID_athletes =".$athlete['ID_athletes']);
             $chiffres_significatifs_1->execute();
            
             //Récupération du nombre de médailles recus au total
             $chiffres_significatifs_2 = $bdd->prepare("SELECT count( DISTINCT id_olympiade) as nbm FROM lier_m, athletes where lier_m.ID_athletes = athletes.ID_athletes and id_medaille != 4 and athletes.ID_athletes =".$athlete['ID_athletes']);
             $chiffres_significatifs_2->execute();

        $olympe = $olympiades->fetchAll();
        $cs1 = $chiffres_significatifs_1->fetchAll();
        $cs2 = $chiffres_significatifs_2->fetchAll();
            // carte d'affichage des olympliades auquels cet athlete à participer
            echo '<div class="card"><div class="card-body">';
                
                echo "Participation à <strong>".$cs1[0]['nbo']."</strong> olympiades <br>(dont <strong>".$cs2[0]['nbm']."</strong> m&eacute;daill&eacute;".($cs2[0]['nbm'] > 1 ? "es" : "e").").<br>";
                foreach ($olympe as $ligne) {
                    echo '<br><img src="'.$ligne['logo'].'" class="img-thumbnail border-0" width="40px"> '.$ligne['nom'].' '.$ligne['annee_o'];
                }

		  echo "</div></div>";
        
			echo "</div>
		  </div>


          </div>
                </div>";
            $i++;       
    }
    echo '</div>';
    
    
    ?>
</div>
 <iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>
