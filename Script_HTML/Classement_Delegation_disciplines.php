<!DOCTYPE html>

<html lang = "fr">


<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <link href="./Styles/Vision_par_delegations.css" rel="stylesheet" type = "text/css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

<title>  Médailles/délégation  </title>
<style type="text/css">
.containe{
	display: flex;
	justify-content : center;
	margin: auto;
	}
	</style>
</head>


<body  class="d-flex flex-column">


	<object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>
<h1>  Comparons par <span> délégations </span>  </h1> 
<br>
<br>
<br>
<br>


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
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('records').style.display='block'"> <a href="Classement_Delegation_records.php#record" >
				<img src="../Images/Boutons/record_(podium,couronne).png"></a>
			</button>
		</div>
	</div>
</div>
  </div>
 </div>

<div id="disciplines">
<div class="container">
	<br><br>
   
     <center><h2><strong>Classement des délégations en fonction des disciplines</strong></h2></center>

	 <br>
	 <br>
     

	 <?php 
	 require("fonction.php");
	 $BDD = getBDD();
	 //echo "avant requete";
	 $Or = $BDD->query("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau, requete_imbriquee.nom_discipline
FROM (
        select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau, disciplines.nom_discipline
        from athletes, lier_m, medailles, pays_participants, etre_nationalite, olympiades, epreuves, disciplines
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes AND
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                and epreuves.id_disciplines = disciplines.id_discipline
                and medailles.type = 'Gold'
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves, disciplines.id_discipline
        ORDER BY `etre_nationalite`.`id_pays` ASC
) as requete_imbriquee
 group by requete_imbriquee.nom_discipline, requete_imbriquee.id_pays 
ORDER BY `nb_medailles`  DESC limit 5
");
	 //echo "apres premiere requete";

	 $Ar = $BDD -> query("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau, requete_imbriquee.nom_discipline
			FROM (select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau, disciplines.nom_discipline
        from athletes, lier_m, medailles, pays_participants, etre_nationalite, olympiades, epreuves, disciplines
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes AND
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                and epreuves.id_disciplines = disciplines.id_discipline
                and medailles.type = 'Silver'
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves, disciplines.id_discipline
        ORDER BY `etre_nationalite`.`id_pays` ASC
) as requete_imbriquee
 group by requete_imbriquee.nom_discipline, requete_imbriquee.id_pays 
ORDER BY `nb_medailles`  DESC limit 5");

	 $Br = $BDD -> query("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau, requete_imbriquee.nom_discipline
			FROM (select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau, disciplines.nom_discipline
        from athletes, lier_m, medailles, pays_participants, etre_nationalite, olympiades, epreuves, disciplines
                where athletes.ID_athletes = lier_m.ID_athletes
                and lier_m.id_medaille = medailles.id_medaille
                and athletes.ID_athletes = etre_nationalite.ID_athletes AND
                etre_nationalite.id_pays = pays_participants.Code_CIO
                and lier_m.id_olympiade = olympiades.id_olympiade
                and epreuves.id_epreuves = lier_m.id_epreuves 
                and epreuves.id_disciplines = disciplines.id_discipline
                and medailles.type = 'Bronze'
         and lier_m.id_olympiade = etre_nationalite.id_olympiade
                group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves, disciplines.id_discipline
        ORDER BY `etre_nationalite`.`id_pays` ASC
) as requete_imbriquee
 group by requete_imbriquee.nom_discipline, requete_imbriquee.id_pays 
ORDER BY `nb_medailles`  DESC limit 5");
	 //echo "requete execute";

	 ?>


<div class="container card">
    <table >

     


	<div class="card-body">
	<h5 class="card-title">Classement officiel du Comité International Olympique</h5>
                  <p class="card-text">Classement en fonction du nombre de médailles  gagnées par discipline  pour les délégations.</p>
	<div class="row">
	<div class="col-12">
	<table class="table">
    <tbody>

	<tr>

	 
     <th> <strong> Discipline </strong> </th>
    <th> <strong>  Pays   </strong></th>
    <th><strong> Drapeau  </strong> </th>
	<th> <strong> </strong></th>
    <th> <strong>Médailles d'Or  </strong></th>
	<th> <strong> </strong></th>
    <th> <strong>Médailles d'argent  </strong></th>
	<th> <strong> </strong></th>
    <th> <strong>Médailles de bronze </strong> </th>
    <th> <strong> Total de médailles </strong> </th>
   </tr>
     <?php 

	 
     	
     	$i = 0;
     	while ($i < 5) {
           
     		$medailleOR = $Or -> fetch();
     		$medailleAR = $Ar -> fetch();
     		$medailleBR = $Br -> fetch();
     		echo "<tr>";
     		echo "<td><strong>".$medailleOR['nom_discipline']."</strong></td>";
     		echo "<td> <strong> <a  href='Pays_particulier.php?id=".$medailleOR['id_pays']."'>".$medailleOR['nom_pays']."</a> </strong></td>";
     		echo "<td><a href='Pays_particulier.php?id=".$medailleOR['id_pays']."'> <img class = 'drapeaufr' src =".$medailleOR['I_drapeau']." alt = 'erreur'> </a></td>";
			echo "<td><img class='imageclassement' src='../Images/Boutons/medaille_or.png' alt='Médaille d'or' width='20px'> <span>" . $lignes[0][$i]["nb_medailles"] . "</span></td>";
     		echo "<td><strong> ".$medailleOR['nb_medailles']."</strong></td>";
			echo "<td><img class='imageclassement' src='../Images/Boutons/medaille_argent.png' alt='Médaille d'or' width='20px'> <span>" . $lignes[0][$i]["nb_medailles"] . "</span></td>";
     		echo "<td><strong>".$medailleAR['nb_medailles']."</strong></td>";
			echo "<td><img class='imageclassement' src='../Images/Boutons/medaille_bronze.png' alt='Médaille d'or' width='20px'> <span>" . $lignes[0][$i]["nb_medailles"] . "</span></td>";
     		echo "<td><strong>".$medailleBR['nb_medailles']."</strong></td>";
     		echo  "<td><strong>= ".$medailleBR['nb_medailles']+$medailleOR['nb_medailles']+$medailleAR['nb_medailles']."</strong></td>";
     		$i = $i+1;
			
     	}
 
     ?> 
	 </tbody>
	</table>
	</div>
	</div>
	</div>



    </table>
  
     

</div>


</div>

</div>
 

</body>


 <iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>


</html>