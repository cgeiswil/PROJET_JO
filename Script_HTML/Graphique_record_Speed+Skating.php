<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Graphique record</title>
    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="./Styles/Vision_par_delegations.css" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>

<body>
    <object data="Barre_de_navigation.html" width="100%" height="100%"></object>
    
    <h1>Graphiques des records de Patinage de vitesse</h1>
     <h3>Choisissez l'&eacute;preuve dans la liste ci-dessous afin d'afficher le graphique !</h3>
    
    <?php
     $sexe = $_GET['sexe'];
     	if ($sexe == "H") {
    	echo "<h2>Cat&eacute;gorie : Homme </h2>";
    	 } else if ($sexe == "F") {
    	 	echo "<h2>Cat&eacute;gorie : Femme </h2>";
    	 }
    ?>
    
   <nav>
  <ul>
    <li class="deroulant">
      <?php
      require("fonction.php");
       $bdd = getBDD();
       $nom_discipline = "Speed Skating";
       $sexe = $_GET['sexe'];
       if ($sexe == "H") {
       	echo "<a href='Graphique_record_Speed+Skating.php?sexe=H'>Liste des &eacute;preuves</a>";
        	$requete = "SELECT nom_discipline, epreuves.id_epreuves, epreuves.epreuves FROM disciplines, lier_r, records, epreuves 
        	WHERE records.id_record=lier_r.id_record AND lier_r.id_epreuve=epreuves.id_epreuves AND 
        	epreuves.id_disciplines=disciplines.id_discipline AND disciplines.nom_discipline='$nom_discipline' AND epreuves.epreuves LIKE '______________men%' GROUP BY epreuves.id_epreuves";
        	$resultat = $bdd->query($requete);
        } else if ($sexe == "F") {
          echo "<a href='Graphique_record_Speed+Skating.php?sexe=F'>Liste des &eacute;preuves</a>";
        	$requete = "SELECT nom_discipline, epreuves.id_epreuves, epreuves.epreuves FROM disciplines, lier_r, records, epreuves 
        	WHERE records.id_record=lier_r.id_record AND lier_r.id_epreuve=epreuves.id_epreuves AND 
        	epreuves.id_disciplines=disciplines.id_discipline AND disciplines.nom_discipline='$nom_discipline' AND epreuves.epreuves LIKE '%women%' GROUP BY epreuves.id_epreuves";
        	$resultat = $bdd->query($requete);
        }
      ?>
      <ul class="sous">
        <?php
          while ($ligne = $resultat->fetch()) {
            $epreuve = $ligne['epreuves'];
            $id_epreuve =$ligne['id_epreuves'];
            echo "<li><a href='Graphique_record_Speed+Skating.php?nom_discipline=$nom_discipline&id_epreuve=$id_epreuve&sexe=$sexe'>$epreuve</a></li>";
          }
        ?>
      </ul>
    </li>
  </ul>
</nav>

<?php
$id_epreuve = $_GET['id_epreuve'];
// Requête SQL avec une variable préparée
$sql = "SELECT `record olympique` AS records, olympiades.annee_o AS annee, records.unite AS unite, epreuves.epreuves, disciplines.nom_discipline FROM records, lier_r, epreuves, olympiades, disciplines
        WHERE records.id_record=lier_r.id_record AND lier_r.id_epreuve=epreuves.id_epreuves AND lier_r.id_olympiade=olympiades.id_olympiade
        AND epreuves.id_disciplines=disciplines.id_discipline AND disciplines.nom_discipline='$nom_discipline' AND epreuves.id_epreuves=:id_epreuve ORDER BY annee ASC, records ASC";
$requete = $bdd->prepare($sql); // Utilisation d'une requête préparée pour éviter les injections SQL
$requete->bindValue(':id_epreuve', $id_epreuve, PDO::PARAM_INT); // Liaison de la variable préparée à la valeur de $_GET['id_epreuve']
$requete->execute();

// Stocker les résultats dans des variables
$records = array();
$annee = array();
$unite = "";
$epreuve = "";
while ($ligne = $requete->fetch()) {
    $records[] = $ligne['records'];
    $annee[] = $ligne['annee'];
    $unite = $ligne['unite'];
    $epreuve = $ligne['epreuves'];
}
// Créer une session et transmettre les variables
session_start();
$_SESSION['records'] = $records;
$_SESSION['annee'] = $annee;
$_SESSION['unite'] = $unite;
$_SESSION['epreuve'] = $epreuve;

?>

	<div>
	
		<?php
		echo "<img class='graph' src='./Graphique_record.php'/>";
		?>
	</div>
	
	<div class="centre">
    <a href="Classement_Delegation_records.php?nom_discipline=Athletics#record"><button type="button" class="btn btn-primary">Retour vers la page pr&eacute;c&eacute;dente</button></a>
    </div>

    <iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>