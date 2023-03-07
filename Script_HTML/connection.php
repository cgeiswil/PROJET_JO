<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Connection </title>
		<link rel="stylesheet" href="test.css" type="text/css">
	</head>
	<body>

		<?php

		

		echo "<form action='enConnection.php' method='post' autocomplete='off'>";

		echo "Nom utilisateur/pseudo <INPUT type='text' name = 'pseudo' value = ''> <br> ";
		echo "Mot de passe <INPUT type='text' name = 'mdp' value = ''><br>";
		echo "<INPUT type='submit'  value = 'Envoyer'>";


		echo "</form>";

		?>

 		<footer>
	<?php
		session_start();
		if(isset($_SESSION['utilisateur'])) {
			echo "~   <a>Bonjour ".$_SESSION['utilisateur']["pseudo"]." !</a> ";
			echo "   |   <a href='deconnexion.php'>Se déconnecter</a>   ~";
		}
		else {
			echo "   |   <a href='nouveau.php'>Nouveau Utilisateur</a>";
			echo "   |   <a href='connection.php'>Se connecter</a>   ~";
		}
	?> 
	</footer>  

	</body>
</html>