<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Enregistrer </title>
		<link rel="stylesheet" href="test.css" type="text/css">


		<?php
		require("fonction.php");
		$bdd = getBDD();

		function enregistrer($ps, $mail, $mdp) {
			
    		$bdd = getBDD();
    		
    		$mdpH = md5($mdp);
    		
    		$requete = $bdd->prepare("insert into utilisateurs (pseudo, email, mot_de_passe) Values (?, ?, ?)");
    		
    		$requete->execute(array($ps, $mail, $mdpH));

		}

		$temp = $_POST['mail'];
		$taille = strlen($temp);
		$drap = false;
		$i = 0;
		while($i < $taille){
			if($temp[$i] == '@'){
				echo 'if<br>';
				$drap = true;
				$i = $taille;
			}else{
				
				$i = $i+1;
				$drap = false;

			}
			
		}

		if((isset($_POST['ps']) and empty($_POST['ps']))
			or (isset($_POST['mail']) and empty($_POST['mail']))
			or (isset($_POST['mdp']) and empty($_POST['mdp']))
			or (isset($_POST['mdp2']) and empty($_POST['mdp2']))	
			 ){

			echo '<meta http-equiv="refresh" content="3; url=nouveau.php?ps='.$_POST['ps'].'&mail='.$_POST['mail'].'">';
			echo "pas rempli";			
		
		}else{
			if($_POST['mdp2'] == $_POST['mdp']){

				if($drap){
					echo 'drapeau true';
					
					$verifMail = $bdd -> prepare('select email from utilisateurs where email= ?');
					$mailPara = $_POST['mail'];
					
					$verifMail -> execute([$mailPara]);
					
					if($verifMail -> fetch()){
						echo "adresse mail deja existente merci de la modifier ou de vous connecter avec le compte correspondant &agrave; l'adresse mail renseign&eacute;e";
						echo '<meta http-equiv="refresh" content="3; url= nouveau.php?n='.$_POST['ps'].'&mail='.$_POST['mail'].'">';

					}else {
						$verifPseudo = $bdd -> prepare('select pseudo from utilisateurs where pseudo= ?');
						$PsPara = $_POST['ps'];
						
						$verifPseudo -> execute([$PsPara]);			
						if($verifPseudo -> fetch()){
							echo "Pseudo d&eacute;j&agrave; existent merci de le modifier";
							echo '<meta http-equiv="refresh" content="3; url= nouveau.php?n='.$_POST['ps'].'&mail='.$_POST['mail'].'">';

						}else{
							
							session_start();
							echo '<meta http-equiv="refresh" content="3; url=Profil.php">';

							echo $_POST['ps']."</br>";
							echo $_POST['mail']."</br>";
							echo $_POST['mdp']."</br>";


							enregistrer($_POST['ps'], $_POST['mail'], $_POST['mdp']);
							
							echo "voici les informations que vous avez rentrée, vous serez redirigé vers la page d'accueil d'ici quelques secondes"; 
							echo "<br>";
							echo "Pseudo : ".$_POST['ps'];
							echo "<br>";
							echo "Adresse mail : ".$_POST['mail'];


							$resultT = $bdd -> prepare('select * from utilisateurs where pseudo = ?');

							$resultT -> execute([$_POST['ps']]);
							
							$result = $resultT  -> fetch();
							
							$_SESSION['utilisateur'] = array(
								'utilisateur' => $result['id_utilisateur'],
								'pseudo' => $result['pseudo'],
								'MDP' => $result['mot_de_passe'],
								'email' => $result['email'],
								'photo' => $result['photo'],
								'nb_heures' => $result['nb_heures']);

							echo "test";
							echo $_SESSION['utilisateur']['utilisateur'];
							}
						}

			}else{
				echo 'drapeau false';
				echo "L'adresse mail que vous avez entr&eacute;e ne contient pas de @. Elle n'est donc pas valide. Merci d'entrer une adresse mail valide.";
				echo "<br>";
				
				echo '<meta http-equiv="refresh" content="3; url= nouveau.php?n='.$_POST['ps'].'&mail='.$_POST['mail'].'">';

			}
		}else{
			echo "Les mots de passe entrés ne sont pas les mêmes. Vous serez redirigés dans quelques instant";
			echo "<br>";
			echo '<meta http-equiv="refresh" content="3; url= nouveau.php?n='.$_POST['ps'].'&mail='.$_POST['mail'].'">';
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