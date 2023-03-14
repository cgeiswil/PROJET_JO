
<!DOCTYPE html>

<html>

<head>


    <meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./Styles/style_classement.css" rel="stylesheet" type = "text/css">


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

  <style>
    html{
    background-color: #F5F5F5;
    }
    body{
     background-color: #F5F5F5;
    }
    </style>
	

<title>  Vision athlete   </title>
</head>



<body class="d-flex flex-column">


    <object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>

    
<div  class = "container" >


    <h1> Comparons par  <span>  athlètes  </span> </h1>
    <br>
    <br>

    <h2> <strong>  Les meilleures athlètes de tous les temps  </strong> </h2>



   <br>
   <br>
    <table class = "table">
    
  <tr  id = "premiereligne">
  <td>nom</td>
   <td>ID</td>
   <td>Sexe</td>
   <td>Age</td>
   <td>Taille</td>
   <td>Poids</td>
   <td>équipe</td>
   <td>NOC</td>
   <td>Edition</td>
   <td>ville_hôte</td>
   <td>Discipline</td>
   <td>épreuve</td>
    
  </tr>

  <?php

include('./connexion_bd.php');

$bdd = getBD();


$athletes   =  $bdd -> query("
select DISTINCT athletes.nom,athletes.ID_athletes,athletes.Sexe,lier_m.Age, lier_m.taille,lier_m.poids,pays_participants.nom_pays,pays_participants.Code_CIO, olympiades.annee_o, villes_hotes.nom as villes,
disciplines.nom_discipline,epreuves.epreuves
from athletes,lier_m,etre_nationalite,pays_participants,olympiades,villes_hotes,disciplines,epreuves,lier_r
where athletes.ID_athletes = lier_m.ID_athletes and lier_m.ID_athletes = etre_nationalite.ID_athletes and 
etre_nationalite.id_pays = pays_participants.Code_CIO and lier_m.id_olympiade = olympiades.id_olympiade 
and olympiades.id_ville_hote = villes_hotes.id_ville and athletes.ID_athletes = lier_r.id_athlete and 
lier_r.id_epreuve = epreuves.id_epreuves and disciplines.id_discipline = epreuves.id_disciplines
and  athletes.ID_athletes in (select athletes.ID_athletes
from athletes, medailles, lier_m
where athletes.ID_athletes = lier_m.ID_athletes
and lier_m.id_medaille = medailles.id_medaille
group by athletes.ID_athletes
ORDER BY  count(athletes.ID_athletes)  DESC
 )
 limit 10");

while ( $ligne = $athletes  -> fetch() ) {
  echo "<tr>
  <td>{$ligne["nom"]}</td>
   <td>{$ligne["ID_athletes"]} </td>
   <td>{$ligne["Sexe"]}</td>
   <td>{$ligne["Age"]}</td>
   <td>{$ligne["taille"]}</td>
   <td>{$ligne["poids"]}</td>
   <td>{$ligne["nom_pays"]}</td>
   <td>{$ligne["Code_CIO"]}</td>
   <td>{$ligne["annee_o"]}</td>
   <td>{$ligne["villes"]}</td>
   <td>{$ligne["nom_discipline"]}</td>
   <td>{$ligne["epreuves"]}</td>
   </tr>";


}



  

   ?>
    </table>

    

</div>







</body>




<footer >
    <object data="pied_de_page.html" width="100%" height="100%">
    </object>
   
  
  </footer>








</html>