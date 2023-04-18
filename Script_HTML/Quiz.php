<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Quiz</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<meta charset="utf-8">
		<link rel="stylesheet" href="Styles/quiz.css" type="text/css">    
		<style>
		.center{
		display: flex;
		justify-content: center;
		margin: auto;
		}
		</style>
	</head>
	<body>
	<?php session_start(); ?>

		<header>
  <?php
    include "Barre_de_navigation.html";
    ?>
  </header> 

		<div class="container mt-4">
		
		
		<h1 class='mt-1 mb-4'><strong>Testez vos connaissances <span>olympiques</span></strong></h1>
		
		<h2>Choisissez le niveau de difficulté :</h2>
		
		<h2 class='mt-1 mb-5'><a href="Quiz.php?niveau=facile"><button type="button" class="btn btn-success">Facile</button></a>
		<a href="Quiz.php?niveau=moyen"><button type="button" class="btn btn-warning">Moyen</button></a>
		<a href="Quiz.php?niveau=difficile"><button type="button" class="btn btn-danger">Difficile</button></a></h2>
		
		
		
		<h4 class="center"><img class='mr-2' src='../Images/Mascotte/mascotte2d.png' height='35px'>Quiz de niveau <?php echo ($_GET['niveau'] != "" ? $_GET['niveau'] : 'Facile'); ?> :</h4>
		<br>

	
<?php
require("fonction.php");
$bdd = getBDD();
$niveau_str = ($_GET['niveau'] != "" ? $_GET['niveau'] : 'facile');
$niveau = 1; // par défaut, on suppose que c'est facile
if ($niveau_str == "moyen") {
    $niveau = 2;
} elseif ($niveau_str == "difficile") {
    $niveau = 3;
}
$requete = "SELECT question, question.id_question FROM question, composer_de, quiz WHERE quiz.id_quiz=composer_de.id_quiz and question.id_question=composer_de.id_question and `difficulte`='$niveau_str'";
$resultat = $bdd->query($requete);
if ($resultat->rowCount() > 0) {
    echo "<form method='post'>";
    while($ligne = $resultat->fetch()) {
        echo '<h5 class="center mb-2"><strong>'.$ligne['question'].'</strong></h5>';
        echo "<ul>";
        $requete_reponses = "SELECT reponse, vraie_fausse FROM `reponses` WHERE id_question = '".$ligne['id_question']."' ORDER BY RAND()";
        $resultat_reponses = $bdd->query($requete_reponses);
        while($ligne_reponse = $resultat_reponses->fetch()) {
            $reponse_text = htmlentities($ligne_reponse['reponse'], ENT_QUOTES);
            $reponse_class = "";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $requete_bonnes_reponses = "SELECT reponse FROM reponses WHERE id_question = '".$ligne['id_question']."' AND vraie_fausse = 1";
                $resultat_bonnes_reponses = $bdd->query($requete_bonnes_reponses);
                $bonnes_reponses = array();
                while($ligne_bonne_reponse = $resultat_bonnes_reponses->fetch()) {
                    $bonnes_reponses[] = htmlentities($ligne_bonne_reponse['reponse'], ENT_QUOTES);
                }
                if (in_array($reponse_text, $bonnes_reponses)) {
                    $reponse_class = "text-success";
                } else {
                    $reponse_class = "text-danger";
                }
            }
            echo "<li class='center'><label><input type='radio' name='".$ligne['id_question']."' value='".$reponse_text."'> <span class='".$reponse_class."'>".htmlentities($ligne_reponse['reponse'], ENT_QUOTES)."</span></label></li>";
        }
        echo "</ul>";
    }
    echo "<center><button type='submit' class='btn btn-success center' >Valider les réponses</button></center>";
    echo "</form>";
} else {
    echo "Aucune question trouvée.";
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    $requete = "SELECT reponse, question.id_question FROM question, composer_de, quiz, reponses WHERE quiz.id_quiz=composer_de.id_quiz and question.id_question=reponses.id_question and question.id_question=composer_de.id_question and `difficulte`='$niveau_str' and vraie_fausse=1";
    $resultat = $bdd->query($requete);
    while($ligne = $resultat->fetch()) {
        if ($_POST[$ligne['id_question']] == $ligne['reponse']) {
            $score++;
        }
    }
    $score_text = "Votre score est de ".$score."/". $resultat->rowCount();
    echo "<script>alert('$score_text');</script>";

    // Si l'utilisateur est connecté, enregistrez le score, l'id_utilisateur et l'id_quiz dans la table "répondre" de la base de données
    if (isset($_SESSION['utilisateur'])) {
        

        $id_utilisateur = $_SESSION['utilisateur']['utilisateur'];
        $id_quiz = $niveau;
        $stmt = $bdd->prepare("INSERT INTO repondre (id_utilisateur, id_quiz, score) VALUES (?, ?, ?)");
        $stmt->execute([$id_utilisateur, $id_quiz, $score]);
    }
}

?>

		</div>
		
<footer class='mt-5'>
	<?php
		include "pied_de_page.php";
	?>
	</footer>
	</body>
</html>
