<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Nouveaux Utilisateurs </title>
	    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


	   
	</head>
	<body>

		<div class = "container">

		<?php

		echo "<object data='Barre_de_navigation.html' width='100%'' height='100%''></object>";
		echo"</br>";

		echo "<h3>Bonjour, veuillez entrer les informations necessaire à votre inscription.</h3>";
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
		echo "<a href = connection.php> Se connecter </br></br></br>";
		

		?>

		</div>

		<footer>
			<div class="footer">
			<object data="Pied_de_page.html" width="100%" height="100%">
			</object>
			</div>
		</footer>

	</body>
</html>