<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Quiz</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<meta charset="utf-8">
		<link rel="stylesheet" href="Styles/quiz.css" type="text/css">    
	</head>
	<body>

		<object data="Barre_de_navigation.html" width="100%" height="100%">
		</object>

		<div class="container">
		
		<h1>Quiz</h1>
		<h2>Choisissez le niveau de difficulté :</h2>
		
		<table>
			<td><a href="Quiz.php?niveau=facile"><button type="button" class="btn btn-success">Facile</button></a></td>
			<td><a href="Quiz.php?niveau=moyen"><button type="button" class="btn btn-warning">Moyen</button></a></td>
			<td><a href="Quiz.php?niveau=difficile"><button type="button" class="btn btn-danger">Difficile</button></a></td>
		</table>
		
		
		<h4>Quiz niveau <?php echo ($_GET['niveau'] != "" ? $_GET['niveau'] : 'Facile'); ?></h4>

		<?php	
			require("fonction.php");
			$bdd = getBDD();
			$niveau = ($_GET['niveau'] != "" ? $_GET['niveau'] : 'facile');
			$requete = "SELECT question, question.id_question FROM question, composer_de, quiz WHERE quiz.id_quiz=composer_de.id_quiz and question.id_question=composer_de.id_question and `difficulte`='$niveau'";
			$resultat = $bdd->query($requete);
			if ($resultat->rowCount() > 0) {
				echo "<form method='post'>";
				while($ligne = $resultat->fetch()) {
					echo "<h5>".$ligne['question']."</h5>";
					echo "<ul>";
					$requete_reponses = "SELECT reponse, vraie_fausse FROM `reponses` WHERE id_question = '".$ligne['id_question']."'";
					$resultat_reponses = $bdd->query($requete_reponses);
					while($ligne_reponse = $resultat_reponses->fetch()) {
						echo "<li><label><input type='radio' name='".$ligne['id_question']."' value='".$ligne_reponse['reponse']."'> ".$ligne_reponse['reponse']."</label></li>";
					}
					echo "</ul>";
				}
				echo "<button type='submit' class='btn btn-success'>Valider les réponses</button>";
				echo "</form>";
			} else {
				echo "Aucune question trouvée.";
			}

			// Process form submission
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$score = 0;
				$requete = "SELECT reponse, question.id_question FROM question, composer_de, quiz, reponses WHERE quiz.id_quiz=composer_de.id_quiz and question.id_question=reponses.id_question and question.id_question=composer_de.id_question and `difficulte`='$niveau' and vraie_fausse=1";
				$resultat = $bdd->query($requete);
				while($ligne = $resultat->fetch()) {
					if ($_POST[$ligne['id_question']] == $ligne['reponse']) {
						$score++;
					}
				}
				echo "<h2>Votre score est de ".$score."/". $resultat->rowCount()."</h2>";
			}
		?>
		</div>

	<iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
	</body>
</html>
