<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Connection </title>
		<link rel="stylesheet" href="test.css" type="text/css">
	</head>
	<body>

		<?php

		echo "Si vous n'avez pas encore créé votre compte, vous pouvez en créer un ici : <a href = nouveau.php> Nouveau utilisateur </a> ";

		echo "</br>";

		echo "<form action='enConnection.php' method='post' autocomplete='off'>";

		echo "Nom utilisateur/pseudo <INPUT type='text' name = 'pseudo' value = ''> <br> ";
		echo "Mot de passe <INPUT type='text' name = 'mdp' value = ''><br>";
		echo "<INPUT type='submit'  value = 'Envoyer'>";


		echo "</form>";

		?>

 

	</body>
</html>