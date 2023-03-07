<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Connecter ?</title>
		<link rel="stylesheet" href="test.css" type="text/css">
	</head>
	<body>

		<?php
	include("bd.php");
	$bdd = getBD();

	if(isset($_POST['pseudo']) and $_POST['pseudo'] != '' and isset($_POST['mdp']) and $_POST['mdp'] != '') {
		
		$requete = $bdd->prepare('SELECT * FROM clients WHERE pseudo= ? AND mdp = ?');
		$requete->execute(array($_POST['pseudo'], md5($_POST['mdp'])) );
		
		if ($result = $requete->fetch()) {
			session_start();
			$_SESSION['client'] = array(
				id_utilisateur => $result['id_utilisateur'],
				pseudo => $result['pseudo'],
				MDP => $result['mdp'],
				email => $result['mail'],
				photo => $result['photo'],
				nb_heure => $result['nb_heure']);
			header('Location: Accueil.php');
			exit();
		}
	}
	else {
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		header('Location: connexion.php?email='.urlencode($email));
		exit();
	}
	?>


		
	</body>

</html>