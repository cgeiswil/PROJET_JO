<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Connecter ?</title>
		<link rel="stylesheet" href="test.css" type="text/css">
	</head>
	<body>

		<?php
		require("fonction.php");
		$bdd = getBDD();

		if(isset($_POST['pseudo']) and $_POST['pseudo'] != '' and isset($_POST['mdp']) and $_POST['mdp'] != '') {
			echo 'premier if';
			$requete = $bdd->prepare('select * FROM utilisateurs WHERE pseudo= ? AND mdp = ?'); 
			echo 'requete preparee';
			$requete->execute(array($_POST['pseudo'], md5($_POST['mdp'])));
			echo 'requete execute';
			
			if($result = $requete->fetch()) {
				echo 'deuxieme if';
				session_start();
				$_SESSION['client'] = array(
					id_utilisateur => $result['id_utilisateur'],
					pseudo => $result['pseudo'],
					MDP => $result['mdp'],
					email => $result['mail'],
					photo => $result['photo'],
					nb_heure => $result['nb_heure']);
				echo 'avant redirection';
				header('Location: Accueil.php');
				exit();
			}
		}else {
			$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
			header('Location: connection.php?email='.urlencode($pseudo));
			exit();
		}
	?>


		
	</body>

</html>