<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Connecter ?</title>
		<link rel="stylesheet" href="test.css" type="text/css">
	</head>
	<body>

		<?php
		require ("fonction.php");

		$con = getBDD();

		$verifP = $con -> query("Select mot_de_passe from utilisateurs
								Where mot_de_passe = '".$_GET['mdp']."'");
		$nbL = $verifP->rowCount();



		if($nbL = 0){
			echo 'mot de passe incorrect';

		}

		?>

	</body>

</html>