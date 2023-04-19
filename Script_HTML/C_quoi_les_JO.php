<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Qu'est ce que les JO </title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<style>
		h1{
			font-weight: bold;
			color: #194aa5;
		}

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

	<header>
  <?php
    include "Barre_de_navigation.html";
    ?>
  </header> 

		<div class="container mt-5">
		<h1><strong>Au fait. C'est quoi les JO ?</strong></h1>
		<h2>Le retour des JO modernes après 1500 ans d'absence</h2>

 

		<p>&Agrave; la fin XIX° siècle la volont&eacute; de lancer des Jeux Olympiques modernes. Suite &agrave; de nombreux &eacute;checs, c'est finalement le Baron Pierre de Coubertin qui d&eacute;cida de rassembler des acteurs importants &agrave; Paris.

		Ainsi c'est lors du premier congrès olympique organis&eacute; du 16 au 23 juin 1894 &agrave; la Sorbonne que les JO sont r&eacute;tablis. Environ 2000 personnes assistent &agrave; ce congrès avec la pr&eacute;sence de 13 f&eacute;d&eacute;rations sportives &eacute;trangères. Ainsi &agrave; la fin de la conf&eacute;rence le 23 juin le CIO est cr&eacute;&eacute;.</p> 

​

		<h2>Les principes de l'olympisme</h2>

​

		<ul>
			<li>Promouvoir le d&eacute;veloppement des qualit&eacute;s physiques et morales qui sont au fondement du sport ; </li>

			<li>&Eacute;duquer les jeunes par le sport dans un esprit de bonne compr&eacute;hension mutuelle et d'amiti&eacute;, dans le but d'aider &agrave; construire un monde meilleur et pacifique ;</li>

 			<li>Diffuser les principes olympiques dans le monde entier et cr&eacute;er de la sorte une bonne volont&eacute; internationale ; </li>

			<li>Rassembler les athlètes du monde dans le grand festival quadriennal que sont les JO.</li>
		</ul>

​

		<h2>D'une première &eacute;dition exclusivement masculine &agrave; la parit&eacute; en 2024</h2>

​

		<p>La première &eacute;dition des JO modernes ont eu lieu &agrave; Athènes capitale du pays originel en avril 1896. 
		Lors de cette &eacute;dition, 241 athlètes, uniquement masculins, concoururent dans 43 &eacute;preuves diff&eacute;rentes.
		 C'est &agrave; partir de l'&eacute;dition suivante en 1900 que les  athlètes f&eacute;minines participent.
		  Pour cette &eacute;dition bas&eacute;e &agrave; Paris 22 femmes sur 997 athlètes (2,21%) participent dans 5 sports :
		   le golf, le tennis, la voile, le croquet et l'&eacute;quitation ; les deux premiers cit&eacute;s &eacute;tant des sports uniquement f&eacute;minin en 1900.
		    Depuis, la participation des athlètes f&eacute;minines ne cesse d'augmenter avec une parit&eacute; 
		    (50/50) pr&eacute;vue pour les Jeux-Olympiques de Paris en 2022 et une augmentation s'&eacute;tant acc&eacute;l&eacute;r&eacute;e &agrave;
		     partir des ann&eacute;es 80 (x2 entre 84 et 2020). </p>

		   <h2> Les Jeux Olympiques en quelques chiffres </h2>

		   <?php 
		   require("fonction.php");
		   $bdd = getBDD();
		   $NbAthTotS = $bdd -> query("select Count(DISTINCT  athletes.ID_athletes) as NB
				FROM athletes, olympiades, etre_nationalite, pays_participants
				Where athletes.ID_athletes = etre_nationalite.ID_athletes
				AND olympiades.id_olympiade = etre_nationalite.id_olympiade
				AND etre_nationalite.id_pays = pays_participants.Code_CIO
				and olympiades.saison = 'summer'");
		   $NbAthTotW = $bdd -> query("select Count(DISTINCT  athletes.ID_athletes) as NB
			   FROM athletes, olympiades, etre_nationalite, pays_participants
				Where athletes.ID_athletes = etre_nationalite.ID_athletes
				AND olympiades.id_olympiade = etre_nationalite.id_olympiade
				AND etre_nationalite.id_pays = pays_participants.Code_CIO
				and olympiades.saison = 'winter'");

		   $ligneS = $NbAthTotS -> fetch();
		   $ligneW = $NbAthTotW -> fetch();
		   $EdS = $bdd -> query("select Count(DISTINCT olympiades.id_olympiade) as NB From olympiades
				Where olympiades.saison = 'summer'
				and olympiades.annee_o < 2018
				");
		   $nbEDS = $EdS -> fetch();
		   $EdW = $bdd -> query("select Count(DISTINCT olympiades.id_olympiade) as NB From olympiades
				Where olympiades.saison = 'winter'
				and olympiades.annee_o < 2018
				");
		   $nbEDW = $EdW -> fetch();


		   $NbAthEdS = $bdd -> query("select olympiades.id_olympiade, Count(DISTINCT  athletes.ID_athletes) as NB , olympiades.annee_o FROM athletes, olympiades, etre_nationalite, pays_participants
				Where athletes.ID_athletes = etre_nationalite.ID_athletes
				AND olympiades.id_olympiade = etre_nationalite.id_olympiade
				AND etre_nationalite.id_pays = pays_participants.Code_CIO
				and olympiades.saison = 'summer'
				GROUP by etre_nationalite.id_olympiade
				order by NB");
		   $i = 0;
		   while ($i < 15){
		   		$mediane = $NbAthEdS -> fetch();
		   		$i = $i+1;
		   }

		   $NbAthEdW = $bdd -> query("select olympiades.id_olympiade, Count(DISTINCT  athletes.ID_athletes) as NB , olympiades.annee_o FROM athletes, olympiades, etre_nationalite, pays_participants
				Where athletes.ID_athletes = etre_nationalite.ID_athletes
				AND olympiades.id_olympiade = etre_nationalite.id_olympiade
				AND etre_nationalite.id_pays = pays_participants.Code_CIO
				and olympiades.saison = 'winter'
				GROUP by etre_nationalite.id_olympiade
				order by NB");
		    $j = 0;
		    while ($j < 10){
		   		$medianeW = $NbAthEdW -> fetch();
		   		$j = $j+1;
		   }
		   $tmp = $medianeW['NB'];
		   
		   $medianeW = $NbAthEdW -> fetch();
		   
		   $Mediane = round(($tmp + $medianeW['NB'])/2, 0);

		   ?>


		   <table class='tableau'> 
		   	<tr>
		   		<th> Nombre total d'Athl&egrave;tes </th>
			   	<th> Nombre moyen d'Athl&egrave;tes par &eacute;dition &eacute;t&eacute;</th>
			   	<th> Nombre m&eacute;dian d'Athl&egrave;tes par &eacute;dition &eacute;t&eacute; </th>
			   	<th> Nombre moyen d'Athl&egrave;tes par &eacute;dition hiver </th>
			   	<th> Nombre m&eacute;dian d'Athl&egrave;tes par &eacute;dition hiver </th>
			</tr>
			<tr>
				<td> <?php echo $ligneS['NB']+$ligneW['NB'] ?> </td>
				<td> <?php echo round($ligneS['NB']/$nbEDS['NB'], 2) ?> </td>
				<td> <?php echo $mediane['NB']?> </td>
				<td> <?php echo round($ligneW['NB']/$nbEDW['NB'], 2) ?> </td>
				<td> <?php echo $Mediane ?> </td>

			</td>
		   </table>



	</div>


<footer class='mt-3'>	
    <?php
        include "pied_de_page.php";
    ?>
    </footer>
</body>
</html>
