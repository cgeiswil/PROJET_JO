<!DOCTYPE html>
<html lang="fr">
	<head>
		<title> Connecter ?</title>
		<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	    <meta charset="utf-8">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">        
	    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		</head>
	<body>

		<?php
		require("fonction.php");
		$bdd = getBDD();

		if(isset($_POST['pseudo']) and $_POST['pseudo'] != '' and isset($_POST['mdp']) and $_POST['mdp'] != '') {
			
			$requete = $bdd->prepare('select * FROM utilisateurs WHERE pseudo= ? AND mot_de_passe = ?'); 
			
			$requete->execute(array($_POST['pseudo'], md5($_POST['mdp'])));
			
			
			if($result = $requete->fetch()) {
				echo 'deuxieme if';
				session_start();
				echo 'session ouverte';
				$_SESSION['utilisateur'] = array(
					'utilisateur' => $result['id_utilisateur'],
					'pseudo' => $result['pseudo'],
					'MDP' => $result['mot_de_passe'],
					'email' => $result['email'],
					'photo' => $result['photo'],
					'nb_heures' => $result['nb_heures']);
				echo 'avant redirection';
				header('Location: Profil.html');
				exit();
			}
		}else {
			$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
			header('Location: connection.php?pseudo='.urlencode($pseudo));
			exit();
		}
	?>


		
	</body>

</html>