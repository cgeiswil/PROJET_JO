<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Nouveaux Utilisateurs </title>
		<link rel="stylesheet" href="test.css" type="text/css">

	</head>
	<body>

		<?php

		//echo "<object data="Barre_de_navigation.html" width="100%" height="100%"></object>";

		echo "Bonjour, veuillez entrer les informations necessaire à votre inscription.";
		echo "<ol>";

		echo "<form method=get action = enregistrement.php autocomplete= on>";
		echo "<li> Pseudo <INPUT type = text name = 'ps' value = ".$_GET['ps']."> </li>";
		echo "<li> Mail <INPUT type = text name = 'mail' value = ".$_GET['mail']."> </li>";
		echo "<li> Mot de Passe <INPUT type = password name = 'mdp' value = ></li> ";
		echo "<li> Confirmer le mot de passe <INPUT type = password name = 'mdp2' value = ></li> ";

		echo "</br>";


		echo "<INPUT type = 'submit' value = 'Envoyer'>";

		echo "</br></br></br>";
		echo "Si vous avez deja un compte vous pouvez vous connecter via ce lien :";
		echo "<a href = connection.php> Se connecter";
		

		?>
	</body>
</html>