<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>M&eacute;dailles/d&eacute;l&eacute;gation</title>
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

  a{

    color: black;
  }
</style>
</head>

<body  class="d-flex flex-column">
	<object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>
	
	<h1 style='font-size: 50px;'><strong>Comparons par <span>d&eacute;l&eacute;gations</span></strong></h1>
	<h2 class='mt-1 mb-5'>Par disciplines, m&eacute;dailles ou records.</h2>


	<div class="containe">
	<div class="row">
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('disciplines').style.display='block'"><a href="Classement_Delegation_disciplines.php#disciplines" ><img src="../Images/Boutons/discipline.png" alt="erreur"></a>
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('m&eacute;dailleCIO').style.display='block'"><a href="Classement_Delegation_medailles.php#medailleCIO" >
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



<div class="container">

<div id="medailleCIO">
<?php


require("fonction.php");
$bd = getBDD();




$couleur_medaille = array("Gold","Silver","Bronze");
$lignes = array();
$taille_classement = "5";

for ( $i = 0  ; $i < 3; $i++){
$requete = $bd -> query("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
from (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
        from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes and
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                  and medailles.type = '".$couleur_medaille[$i]."'
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
        ORDER BY etre_nationalite.id_pays ASC
) as requete_imbriquee
 group by requete_imbriquee.id_pays 
order by  nb_medailles  DESC 
limit ".$taille_classement);


$lignes[$i]  =  $requete -> fetchall(); 


}




         
?>
         
        
    <br><br>
   
     <center><h2><strong>Classement des m&eacute;dailles CIO</strong></h2></center>
     <br>
     <style>
      #vision

</style>
     <table  id = "troisdrapeaux">

     <tr>
     <td class = " celluletab" > <img class = "drapeaufr"  src = <?= $lignes[0][0]["drapeau"] ?> alt="Drapeau premier" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src=  <?= $lignes[0][1]["drapeau"] ?> alt="Drapeau deuxieme" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src=  <?=$lignes[0][2]["drapeau"] ?> alt="Drapeau troisieme" class="img-thumbnail border-0" width="40px"> </td>

    </tr>

    <tr >
     <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_or.png" alt="medaille or" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_argent.png" alt="medaille argent" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_bronze.png" alt="medaille bronze" class="img-thumbnail border-0" width="40px"> </td>
    </tr>

     </table>
    
     
     <br>
     <div class="container card">
     <div class="card-body">
                  <h5 class="card-title">Classement officiel du Comit&eacute; International Olympique</h5>
                  <p class="card-text">M&eacute;dailles d'or gagn&eacute;es par les d&eacute;l&eacute;gations par ordre croissant.</p>
      <div class="row">
        <div class="col-12">

        
        
            <table class="table">
            <tbody>
              

              <?php     

              
    $i = 0;
    $i = 0;

    while ($i < $taille_classement) {
        echo "<tr>
                  <td>".strval($i + 1)."</td>
                   <th scope='row'><a href='Pays_particulier.php?id=".$lignes[0][$i]["id_pays"]."'><img class='drapeaufr' src='" . $lignes[0][$i]["drapeau"] . "' alt='Drapeau France' class='img-thumbnail border-0' width='40px'> " . $lignes[0][$i]["nom_pays"] . "</a></th>
                  <td><img class='imageclassement' src='../Images/Boutons/medaille_or.png' alt='M&eacute;daille d'or' width='20px'> <span>" . $lignes[0][$i]["nb_medailles"] . "</span></td>
                  <td><img class='imageclassement' src='../Images/Boutons/medaille_argent.png' alt='M&eacute;daille d'argent' width='20px'> <span>" . $lignes[1][$i]["nb_medailles"] . "</span></td>
                  <td><img class='imageclassement' src='../Images/Boutons/medaille_bronze.png' alt='M&eacute;daille de bronze' width='20px'> <span>" . $lignes[2][$i]["nb_medailles"] . "</span></td>
                  <td>= " . ($lignes[0][$i]["nb_medailles"] + $lignes[1][$i]["nb_medailles"] + $lignes[2][$i]["nb_medailles"]) . "</td>
              </tr>";
        $i += 1;
    }
    


    


    
?>






              </tbody>
          </table>
  
        </div>
      </div>
    




    
     <style>

      .petit{
     
      width: 30px;
      height : 30px;

      }
     </style>


     <div class="card-body">
                  <h5 class="card-title">Classement alternatif </h5>
                  <p class="card-text">M&eacute;dailles pond&eacute;r&eacute;es par des valeurs.    <img class = 'petit' src ='../Images/Boutons/medaille_bronze.png' >*1  <img class = 'petit' src ='../Images/Boutons/medaille_argent.png' >*3 <img class = 'petit' src ='../Images/Boutons/medaille_or.png' >*5 </p>
      <div class="row">
        <div class="col-12">

        
        
            <table class="table">
            <tbody>


<?php
// Classements alternatifs

$couleur_medaille = array("Gold","Silver","Bronze");
$lignes = array();
$taille_classement = "5";
$points_medailles = array(5, 3, 1); // Ajout de l'array pour les points des m&eacute;dailles
for ( $i = 0  ; $i < 3; $i++){
    $requete = $bd -> query("select requete_imbriquee.id_pays, sum(requete_imbriquee.nb * ".$points_medailles[$i].") as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
    from (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
        from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
        where athletes.ID_athletes = lier_m.ID_athletes
            and lier_m.id_medaille = medailles.id_medaille
            and athletes.ID_athletes = etre_nationalite.ID_athletes and
            etre_nationalite.id_pays = pays_participants.Code_CIO
            and lier_m.id_olympiade = olympiades.id_olympiade
            and epreuves.id_epreuves = lier_m.id_epreuves 
            and medailles.type = '".$couleur_medaille[$i]."'
            and lier_m.id_olympiade = etre_nationalite.id_olympiade
        group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
        ORDER BY etre_nationalite.id_pays ASC
    ) as requete_imbriquee
    group by requete_imbriquee.id_pays 
    order by nb_medailles DESC 
    limit ".$taille_classement);
    $lignes[$i]  =  $requete -> fetchAll(); 
}  

?>



<?php


// afficher le classement tri&eacute;
$i = 0;
while ($i < $taille_classement) {
      echo "<tr>
              <td>".strval($i + 1)."</td>
              <th scope='row'><a href='Pays_particulier.php?id=".$lignes[0][$i]["id_pays"]."'><img class='drapeaufr' src='" . $lignes[0][$i]["drapeau"] . "' alt='Drapeau France' class='img-thumbnail border-0' width='40px'> " . $lignes[0][$i]["nom_pays"] . "</a></th>
              <td><img class='imageclassement' src='../Images/Boutons/medaille_or.png' alt='M&eacute;daille d'or' width='20px'> <span>" . $lignes[0][$i]["nb_medailles"] . "</span></td>
              <td><img class='imageclassement' src='../Images/Boutons/medaille_argent.png' alt='M&eacute;daille d'argent' width='20px'> <span>" . $lignes[1][$i]["nb_medailles"] . "</span></td>
              <td><img class='imageclassement' src='../Images/Boutons/medaille_bronze.png' alt='M&eacute;daille de bronze' width='20px'> <span>" . $lignes[2][$i]["nb_medailles"] . "</span></td>
              <td>= " . ($lignes[0][$i]["nb_medailles"] + $lignes[1][$i]["nb_medailles"] + $lignes[2][$i]["nb_medailles"]) . "</td>
          </tr>";
      $i += 1;
}


?>



</tbody>
          </table>
  
        </div>
      </div>
    </div>



    
    </div>
    
</div>
<iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
</div>



</body>

</html>