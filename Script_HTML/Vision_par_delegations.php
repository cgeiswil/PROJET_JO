<!doctype html>

<html lang = "fr">


<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <link href="./Styles/Vision_par_delegations.css" rel="stylesheet" type = "text/css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

<title>  Médailles/délégation  </title>
<style>
	html{
	background-color: #F5F5F5;
	}
	body{
	 background-color: #F5F5F5;
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

<div class="container">


<table class = "rounded-4" >

 <tr> <td>  <button type=submit onclick = "document.getElementById('disciplines').style.display='block'">

<img  src = "../Images/Boutons/discipline.png"  alt = "erreur" >
</button>  </td>   
 

<td> <button type=submit  onclick = "document.getElementById('médailleCIO').style.display='block'">  <img  src = "../Images/Boutons/medaille_or.png"> </button>  </td>   

 <td>  <button type=submit  onclick = "document.getElementById('records').style.display='block'">    <img src = "../Images/Boutons/record_(podium,couronne).png">  </button> </td> 

</table>

</div>


<div id="médailleCIO" style="display:none">
<div class="container">
	<br><br>
   
     <center><h2><strong>Classsement des médailles CIO</strong></h2></center>
	 <br>
	 <?php 
	 require("fonction.php");
	 $BDD = getBDD();
	 echo "avant requete";
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
	 echo "apres premiere requete";

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
	 echo "requete execute";

	 ?>


     <table >

     <tr>
     	<th> Discipline </th>
     	<th> Pays </th>
     	<th> Drapeau </th>
     	<th> Médailles d'Or </th>
     	<th> Médailles d'argent </th>
     	<th> Médailles de bronze </th>
     	<th> Total de médailles </th>
     </tr>
     <?php 
     	
     	$i = 0;
     	while ($i < 5) {
     		$medailleOR = $Or -> fetch();
     		$medailleAR = $Ar -> fetch();
     		$medailleBR = $Br -> fetch();
     		echo "<tr>";
     		echo "<td>".$medailleOR['nom_discipline']."</td>";
     		echo "<td>".$medailleOR['nom_pays']."</td>";
     		echo "<td> <img src =".$medailleOR['I_drapeau']." alt = 'erreur'></td>";
     		echo "<td>".$medailleOR['nb_medailles']."</td>";
     		echo "<td>".$medailleAR['nb_medailles']."</td>";
     		echo "<td>".$medailleBR['nb_medailles']."</td>";
     		echo "<td>".$medailleBR['nb_medailles']+$medailleOR['nb_medailles']+$medailleAR['nb_medailles']."</td>";
     		$i = $i+1;

     	}

     ?> 


     <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	</tr>

	<tr >
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_or.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_argent.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "../Images/Boutons/medaille_bronze.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
    </tr>

	 




	 </table>