<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Vision par disciplines</title>
    <meta charset="utf-8">
	<link href="./Styles/style_classement.css" rel="stylesheet" type = "text/css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">      
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

</head>

<body>

		<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>

    <?php include("../fonction.php");
    $id = $_GET['id'];
    $bdd = getBDD();
    $rep = $bdd->query("Select * FROM (SELECT id_discipline FROM disciplines WHERE nom_discipline IN ('Athletics', 'Speed Skating', 'Weightlifting', 'Shooting','Cycling','Short Track Speed Skating','Swimming','Archery') ORDER BY FIELD(nom_discipline, 'Athletics', 'Speed Skating', 'Weightlifting', 'Shooting','Cycling','Short Track Speed Skating','Swimming','Archery')) as disciplines1 ,epreuves, lier_r, records Where disciplines1.id_discipline = epreuves.id_disciplines and epreuves.id_epreuves=lier_r.id_epreuve and lier_r.id_record= records.id_record and disciplines1.id_discipline = ".$id."; ");
    $ligne = $rep -> fetch();
    ?>
   
    <div  class = "container" >

    <h1> Records <span id  =  "recath" > Athlétisme  </span> </h1>
<a  href = "./Vision_par_disciplines.html" >  choix discipline</a>
<br>
<br>
<table class = "table">
    <tr  id = "premiereligne">
        <td>Nom</td>
        <td>Prénom</td>
        <td>nation représentée</td>
        <td>année</td>
        <td>lieu</td>
        <td>épreuve</td>
        <td>sexe</td>
        <td>record olympique</td>
        <td>unité</td>
        <td>stade de la compétition</td>
    </tr>
    </div>
    
    
    <tr>
        <td>Burke </td>
        <td>Thomas</td>
        <td>USA </td>
        <td>1896</td>
        <td>Athènes</td>
        <td>100 m </td>
        <td>H </td>
        <td>11,80 </td>
        <td>seconde </td>
        <td>Round1 </td>
    </tr>
</table>

    

</body>
    <footer>
		<object data="pied_de_page.html" width="100%" height="100%">
		</object>
	</footer>
</html>