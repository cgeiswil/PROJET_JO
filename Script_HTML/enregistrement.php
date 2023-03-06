<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Enregistrer </title>
		<link rel="stylesheet" href="test.css" type="text/css">


		<?php
		/*require("fonction.php"); 

		function enregistrer($ps, $mail, $mdp){
			$bdd = getBDD();
			$mdpH = md5($mdp);
			
			$bdd -> query("insert into Clients (Pseudo, email, mot_de_passe)
						Values('$ps', '$mail','$mdpH')";	
		}*/

		if((isset($_GET['ps']) and empty($_GET['ps']))
			or (isset($_GET['mail']) and empty($_GET['mail']))
			or (isset($_GET['mdp']) and empty($_GET['mdp']))
			or (isset($_GET['mdp2']) and empty($_GET['mdp2']))	
			 ){

			echo '<meta http-equiv="refresh" content="3; url=nouveau.php?ps='.$_GET['ps'].'&mail='.$_GET['mail'].'">';
			echo "pas rempli";			
		
		}else{

			if($_GET['mdp2'] == $_GET['mdp']){

				echo "mdp egaux";

				echo '<meta http-equiv="refresh" content="3; url=Accueil.html>';

				echo $_GET['ps']."</br>";
				echo $_GET['mail']."</br>";
				echo $_GET['mdp']."</br>";


				//enregistrer($_GET['ps'], $_GET['mail'], $_GET['mdp']);
				
				echo "voici les informations que vous avez rentrée, vous serez redirigé vers la page d'accueil d'ici quelques secondes"; 
				echo "<br>";
				echo "Pseudo : ".$_GET['ps'];
				echo "<br>";
				echo "Adresse mail : ".$_GET['mail'];


			}else{

				echo "Les mots de passe entrés ne sont pas les mêmes. Vous serez redirigés dans quelques instant";
				echo "<br>";
				echo $_GET['mdp2'];
				echo '<meta http-equiv="refresh" content="3; url= nouveau.php?n='.$_GET['ps'].'&mail='.$_GET['mail'].'">';

			}
		}
		?>
	</head>
	<body>


		<?php


		echo "Bonjour enregistrement en cours";


		?>



	</body>
</html>