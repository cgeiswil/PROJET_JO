<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Les JO Autrement</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="Styles/quiz.css" type="text/css">    
	</head>
	<body>

		<object data="Barre_de_navigation.html" width="100%" height="100%">
		</object>

		<h1>Quiz de Niveau <?php echo $_GET['niveau']; ?></h1>

		<?php	
			require("fonction.php");
			$bdd = getBDD();
			$niveau = $_GET['niveau'];
			$requete = "SELECT question, question.id_question FROM question, composer_de, quiz WHERE quiz.id_quiz=composer_de.id_quiz and question.id_question=composer_de.id_question and `difficulte`='$niveau'";
			$resultat = $bdd->query($requete);
			if ($resultat->rowCount() > 0) {
				echo "<form method='post'>";
				while($ligne = $resultat->fetch()) {
					echo "<h3>".$ligne['question']."</h3>";
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

<!--
		<div class="footer">
			<object  data="Pied_de_page.html" width="100%" height="100%">
			</object>
		</div>
-->
	</body>
</html>
