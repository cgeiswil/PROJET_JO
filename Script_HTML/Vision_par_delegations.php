
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

<img  src = "./Images/Boutons/discipline.png"  alt = "erreur" >
</button>  </td>   
 

<td> <button type=submit  onclick = "document.getElementById('médailleCIO').style.display='block'">  <img  src = "./Images/Boutons/medaille_or.png"> </button>  </td>   

 <td>  <button type=submit  onclick = "document.getElementById('records').style.display='block'">    <img src = "./Images/Boutons/record_(podium,couronne).png">  </button> </td> 
</tr>
</table>
</div>

<div id="disciplines" style="display:none">
<div class="container">
	<br><br>
   
     <center><h2><strong>Classement des délégations en fonction des disciplines</strong></h2></center>
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

     </table>
   </div>
 </div>
 




<div id="médailleCIO" style="display:none">
<div class="container">

<?php
		 include("connexion_bd.php");
		 $bd = getBD();



	    $requete_or = $bd -> query("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
		from (
				select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
				from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
						where athletes.ID_athletes = lier_m.ID_athletes
						and lier_m.id_medaille = medailles.id_medaille
						and athletes.ID_athletes = etre_nationalite.ID_athletes and
						etre_nationalite.id_pays = pays_participants.Code_CIO
						and lier_m.id_olympiade = olympiades.id_olympiade
						and epreuves.id_epreuves = lier_m.id_epreuves 
						and medailles.type = 'Gold'
				 and lier_m.id_olympiade = etre_nationalite.id_olympiade
						group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
				ORDER BY etre_nationalite.id_pays ASC
		) as requete_imbriquee
		 group by requete_imbriquee.id_pays 
		order by  nb_medailles  DESC 
		limit 4");

		

		$requete_argent = $bd -> query ("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
		from (
				select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
				from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
						where athletes.ID_athletes = lier_m.ID_athletes
						and lier_m.id_medaille = medailles.id_medaille
						and athletes.ID_athletes = etre_nationalite.ID_athletes and
						etre_nationalite.id_pays = pays_participants.Code_CIO
						and lier_m.id_olympiade = olympiades.id_olympiade
						and epreuves.id_epreuves = lier_m.id_epreuves 
						and medailles.type = 'Silver'
				 and lier_m.id_olympiade = etre_nationalite.id_olympiade
						group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
				ORDER BY etre_nationalite.id_pays ASC
		) as requete_imbriquee
		 group by requete_imbriquee.id_pays 
		order by  nb_medailles  DESC 
		limit 4");
         

		
		$requete_bronze = $bd -> query ("select requete_imbriquee.id_pays, count(requete_imbriquee.nb) as nb_medailles, requete_imbriquee.nom_pays, requete_imbriquee.I_drapeau as drapeau
		from (
				select etre_nationalite.id_olympiade, etre_nationalite.id_pays, count(DISTINCT lier_m.id_epreuves) as nb, pays_participants.nom_pays, pays_participants.I_drapeau
				from athletes,lier_m,medailles,pays_participants,etre_nationalite,olympiades,epreuves
						where athletes.ID_athletes = lier_m.ID_athletes
						and lier_m.id_medaille = medailles.id_medaille
						and athletes.ID_athletes = etre_nationalite.ID_athletes and
						etre_nationalite.id_pays = pays_participants.Code_CIO
						and lier_m.id_olympiade = olympiades.id_olympiade
						and epreuves.id_epreuves = lier_m.id_epreuves 
						and medailles.type = 'Bronze'
				 and lier_m.id_olympiade = etre_nationalite.id_olympiade
						group by etre_nationalite.id_olympiade, etre_nationalite.id_pays, lier_m.id_epreuves
				ORDER BY etre_nationalite.id_pays ASC
		) as requete_imbriquee
		 group by requete_imbriquee.id_pays 
		order by  nb_medailles  DESC 
		limit 4");
        

		$lignes_or = $requete_or -> fetchAll();
        $lignes_argent = $requete_argent-> fetchAll();

		$lignes_bronze = $requete_bronze -> fetchAll();
		
         function drapeau($nom_pays,$bd){

			$requete =  $bd -> query("select pays_participants.I_drapeau
			from pays_participants
			where pays_participants.nom_pays = '$nom_pays' ") -> fetch();
			return $requete[0];
         

		 };


		
       	
		/*
		echo "<table class='table'>";
		 echo "<tbody>";
        $i = 0;
		 while ($i <= 4 ){
			echo "<tr>";
			echo "<td>1</td>";
			echo "<th scope='row'><img class='drapeaufr' src=".drapeau($lignes_or[$i]["nom_pays"],$bd)." alt='Drapeau France' class='img-thumbnail border-0' width='40px'>  {$lignes_or[$i]["nom_pays"]}</th>
            <td><img class='imageclassement' src='./Images/Boutons/medaille_or.png' alt='Médaille d'or' width='20px'><span>{$lignes_or[$i]["nb_medailles"]}</span></td>
            <td><img class='imageclassement' src='./Images/Boutons/medaille_argent.png' alt='Médaille d'argent' width='20px'><span>{$lignes_argent[$i]["nb_medailles"]} </span></td>
            <td><img class='imageclassement' src='./Images/Boutons/medaille_bronze.png' alt='Médaille de bronze' width='20px'><span>{$lignes_bronze[$i]["nb_medailles"]}</span></td>
            <td> {$lignes_or[$i]["nb_medailles"] + $lignes_argent[$i]["nb_medailles"] + $lignes_bronze[$i]["nb_medailles"]}</td>";

		  echo " </tr>";

		 }


		echo "</tbody>";
	     echo " </table>";

		 */
	
		?>
		
	<br><br>
   
     <center><h2><strong>Classement des médailles CIO</strong></h2></center>
	 <br>
	 <style>
      #vision

</style>
     <table  id = "troisdrapeaux">

     <tr>
     <td class = " celluletab" > <img class = "drapeaufr"  src = <?= $lignes_or[0]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
     <td class = " celluletab" > <img class = "drapeaufr"  src=  <?= $lignes_or[1]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src=  <?= $lignes_or[2]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>

	</tr>

	<tr >
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "./Images/Boutons/medaille_or.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "./Images/Boutons/medaille_argent.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
	 <td class = " celluletab" > <img class = "drapeaufr"  src = "./Images/Boutons/medaille_bronze.png" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
    </tr>

	 




	 </table>
	
	 
	 <br>
	 <div class="container card">
	 <div class="card-body">
				  <h5 class="card-title">Classement officiel du Comité International Olympique</h5>
				  <p class="card-text"> Classement  en fonction du nombre de médailles d'or.  </p>
	  <div class="row">
		<div class="col-12">

		
		
		    <table class="table">
			<tbody>





			
			  <tr>
				<td>1</td>
				<th scope="row"><img class = "drapeaufr"  src= <?= $lignes_or[0]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"> <?= $lignes_or[0]["nom_pays"] ?></th>
				<td> <img class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span> <?= $lignes_or[0]["nb_medailles"] ?></span></td>
				<td><img class = "imageclassement"src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span> <?= $lignes_argent[0]["nb_medailles"] ?></span></td>
				<td><img class = "imageclassement" src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span><?= $lignes_bronze[0]["nb_medailles"] ?></span></td>
				<td>= <?= $lignes_or[0]["nb_medailles"] + $lignes_argent[0]["nb_medailles"] +  $lignes_bronze[0]["nb_medailles"] ?></td>
			  </tr>
			  <tr>
				<td>2</td>
				<th scope="row"><img class = "drapeaufr"  src=<?= $lignes_or[1]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"> <?= $lignes_or[1]["nom_pays"] ?></th>
				<td><img  class = "imageclassement"src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span><?= $lignes_or[1]["nb_medailles"] ?></span></td>
				<td><img  class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span><?= $lignes_argent[1]["nb_medailles"] ?></span></td>
				<td><img  class = "imageclassement" src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span><?= $lignes_bronze[1]["nb_medailles"] ?></span></td>
				<td>= <?= $lignes_or[1]["nb_medailles"] + $lignes_argent[1]["nb_medailles"] +  $lignes_bronze[1]["nb_medailles"]; ?></td>
			  </tr>
						<tr>
				<td>3</td>
				<th scope="row"> <img class = "drapeaufr" src= <?= $lignes_or[2]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"><?= $lignes_or[2]["nom_pays"] ?> </th>
				<td><img class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span><?= $lignes_or[2]["nb_medailles"] ?></span></td>
				<td><img class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span><?= $lignes_argent[2]["nb_medailles"] ?></span></td>
				<td><img class = "imageclassement"  src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span><?= $lignes_bronze[2]["nb_medailles"] ?></span></td>
				<td>= <?=   $lignes_or[2]["nb_medailles"] + $lignes_argent[2]["nb_medailles"] +  $lignes_bronze[2]["nb_medailles"]; ?> </td>
			  <tr>
				<td>4</td>
				<th scope="row"><img class = "drapeaufr" src=<?= $lignes_or[3]["drapeau"] ?> alt="Drapeau France" class="img-thumbnail border-0" width="40px"><?= $lignes_or[3]["nom_pays"] ?></th>
				<td><img  class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span><?= $lignes_or[3]["nb_medailles"] ?></span></td>
				<td><img  class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span><?= $lignes_argent[3]["nb_medailles"] ?></span></td>
				<td><img class = "imageclassement"  src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span><?= $lignes_bronze[3]["nb_medailles"] ?></span></td>
				<td>= <?=  $lignes_or[3]["nb_medailles"] + $lignes_argent[3]["nb_medailles"] +  $lignes_bronze[3]["nb_medailles"]; ?> </td>
			  </tr>

			  </tbody>
		  </table>


		
			
		  

		
		</div>
	  </div>
	</div>

	
</div>
</div>


<div class="container">
	<br><br>
    <center><h2><strong>Classement alternatifs des médailles</strong></h2></center>
	<br>
	     
		 <div class="card-deck">
		  <div class="card">
			<div class="card-body">
			  <h5 class="card-title">Par population</h5>
			  <p class="card-text"> Le nombre de médailles pondéré par la population de la délégation.</p>
			  <p class="card-text">


			  <?php
               $requete = $bd -> query("select pays_participants.nom_pays, pays_participants.population,pays_participants.I_drapeau
			   from pays_participants
			   order by pays_participants.population desc
			   limit 3");

			   $pops = $requete  -> fetchall();

			   


              ?>
		
				
				 <div class="row">
					<div class="col-12">
					  <table class="table" >

						<tbody>
						  <tr>
							<td>1</td>
							<th scope="row"><img class = "drapeaufr" src="pops[0]["I_drapeau"]" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> France</th>
							<td><img   class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span> 10</span></td>
							<td><img   class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span> 50</span></td>
							<td><img   class = "imageclassement" src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>4</span></td>
							<td>= $pops[0]["populatione"]</td>
						  </tr>
						  <tr>
							<td>2</td>
							<th scope="row"><img class = "drapeaufr" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> Etats-Unis</th>
							<td><img  class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
							<td><img  class = "imageclassement"  src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
							<td><img   class = "imageclassement" src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>35</span></td>
							<td>= 111</td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
			  
			  
			  </p>
			  
			</div>
		  </div>
		  <div class="card">
			<div class="card-body">
			  <h5 class="card-title">Par nombre d'éditions. </h5>
			  
			  <p class="card-text">Le nombre de médailles pondéré par le nombre d'éditions auquel la délégations a participée.</p>
			  			  <p class="card-text">

				
				 <div class="row">
					<div class="col-12">
					  <table class="table">
						<tbody>
						  <tr>
							<td>1</td>
							<th scope="row"><img class = "drapeaufr" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> France</th>
							<td>= 111</td>
						  </tr>
						  <tr>
							<td>2</td>
							<th scope="row"><img  class = "drapeaufr"src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> Etats-Unis</th>
							<td><img class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
							<td><img  class = "imageclassement"src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
							<td><img class = "imageclassement" src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>35</span></td>
							<td>= 111</td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
			  
			  
			  </p>
			  
			</div>
		  </div>
		  <div class="card">
			<div class="card-body">
			  <h5 class="card-title">Par médailles pondérées</h5>
			  <p class="card-text">Les médailles sont pondérées en fonction de leurs valeurs.</p>
			  
			  			  <p class="card-text">
			  
				
				 <div class="row">
					<div class="col-12">
					  <table class="table">
						<tbody>
						  <tr>
							<td>1</td>
							<th scope="row"><img class = "drapeaufr" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> France</th>
							<td><img  class = "imageclassement" src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
							<td><img  class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
							<td><img class = "imageclassement"  src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>40</span></td>
							<td>= 111</td>
						  </tr>
						  <tr>
							<td>2</td>
							<th scope="row"><img  class = "drapeaufr" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> Etats-Unis</th>
							<td><img  class = "imageclassement" class = "drapeaufr"src="./Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
							<td><img  class = "imageclassement" src="./Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
							<td><img  class = "imageclassement"src="./Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>35</span></td>
							<td>= 111</td>
						  </tr>
						</tbody>
					  </table>
					</div>
				  </div>
			  
			  
			  </p>
			  
			  
			  
			  <!--<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
			  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
			</div>
		  </div>
		</div>
        </div>
	<br><br>
</div>

</div>

<div id="disciplines" style="display:none">
	<div class="container">
		<br><br>
	   
		 <center><h2><strong>Classement des disciplines CIO</strong></h2></center>
		 <br>
		 <table >
	     


	    <tr >
	    <td class = " celluletab" > <h2> <strong>Natation</strong> </h2> </td>
	    <td class = " celluletab" > <h2> <strong>biathlon </strong></h2>   </td>
		<td class = " celluletab" >  <h2> <strong>curlings</strong></h2> </td>
		</tr>
		 <tr>
		 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
		 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
		 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
		</tr>
	

	
		
	
		 </table>
		 
		 <br>
		 <div class="container card">
		 <div class="card-body">
					  <h5 class="card-title">Classement officiel du Comité International Olympique</h5>
					  <p class="card-text">Description du classement.</p>
		  <div class="row">
			<div class="col-12">
			 
			  <table class="table">
				<tbody>
				  <tr >
					<td>Natation</td>
					<td> <img class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
					<td><img class = "imageclassement"src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
					<td><img class = "imageclassement" src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>40</span></td>
					<td>= 111</td>
				  </tr>
				  <tr>
					<td>Biathlon</td>
					<td><img  class = "imageclassement"src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>30</span></td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>30</span></td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>30</span></td>
					<td>= 90</td>
				  </tr>
							<tr>
					<td>curling</td>
					<td><img class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>11</span></td>
					<td><img class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>22</span></td>
					<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>33</span></td>
					<td>= 66</td>
				  </tr>
				  <tr>
					<td>athlétisme</td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
					<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
					<td>= 6</td>
				  </tr>
				  <tr>
					<td>Escrime</td>
										<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
					<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
					<td>= 6</td>
				  </tr>
				  <tr>
					<td>Gymnastique</td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
					<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
					<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
					<td>= 6</td>
				  </tr>


				  
				
				  
				</tbody>
			  </table>
	
			
			</div>
		  </div>
		</div>
	
		
	</div>
</div>
	


	<div id = "records">
		<div class="container">
			<br><br>
		   
			 <center><h2><strong>Classement records CIO</strong></h2></center>
			 <br>
			 <table >
			 
	
	
			<tr >
			<td class = " celluletab" > <h2> <strong>Athlétisme</strong> </h2> </td>
			<td class = " celluletab" > <h2> <strong>Tir à l'arc </strong></h2>   </td>
			<td class = " celluletab" >  <h2> <strong>Cyclisme</strong></h2> </td>
			</tr>
			 <tr>
			 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
			 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
			 <td class = " celluletab" > <img class = "drapeaufr"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg/1200px-Flag_of_France_%281794%E2%80%931815%2C_1830%E2%80%931974%2C_2020%E2%80%93present%29.svg.png?20230102180422" alt="Drapeau France" class="img-thumbnail border-0" width="40px"> </td>
			</tr>
		
	
		
			 
		
		
		
		
			 </table>
			 
		     <br>
			 <div class="container card">
			 <div class="card-body">
						  <h5 class="card-title">Classement officiel du Comité International Olympique</h5>
						  <p class="card-text">Description du classement.</p>
			  <div class="row">
				<div class="col-12">
				 
				  <table class="table">
					<tbody>
					  <tr >
						<td>Natation</td>
						<td> <img class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>31</span></td>
						<td><img class = "imageclassement"src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>40</span></td>
						<td><img class = "imageclassement" src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>40</span></td>
						<td>= 111</td>
					  </tr>
					  <tr>
						<td>Biathlon</td>
						<td><img  class = "imageclassement"src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>30</span></td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>30</span></td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>30</span></td>
						<td>= 90</td>
					  </tr>
								<tr>
						<td>curling</td>
						<td><img class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>11</span></td>
						<td><img class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>22</span></td>
						<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>33</span></td>
						<td>= 66</td>
					  </tr>
					  <tr>
						<td>athlétisme</td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
						<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
						<td>= 6</td>
					  </tr>
					  <tr>
						<td>Escrime</td>
											<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
						<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
						<td>= 6</td>
					  </tr>
					  <tr>
						<td>Gymnastique</td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_or.png" alt="Médaille d'or" width="20px"> <span>1</span></td>
						<td><img  class = "imageclassement" src="../Images/Boutons/medaille_argent.png" alt="Médaille d'argent" width="20px"> <span>2</span></td>
						<td><img class = "imageclassement"  src="../Images/Boutons/medaille_bronze.png" alt="Médaille de bronze" width="20px"> <span>3</span></td>
						<td>= 6</td>
					  </tr>
					  
					
					  
					</tbody>
				  </table>
		
				
				</div>
			  </div>
			</div>
		
			
		</div>
      

	</div>


</body>

<footer >

	<object data="pied_de_page.html" width="100%" height="100%">
	</object>
 </footer>



</html>