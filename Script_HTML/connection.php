<!DOCTYPE html>
<html lang="fr">
	<head>
		<title> Connection </title>
	    <meta charset="utf-8">
	    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	   
		</head>
	<body>



		<object data="Barre_de_navigation.html" width="100%" height="100%">
		</object>
		<h3> Entrez vos informations pour vous connecter à votre compte. Si vous n'avez pa de compte, cliquez sur Nouveau Utilisateur. </h3>
		</br></br>
		<div class ="container">
		<?php
		

		echo "<form action='enConnection.php' method='post' autocomplete='on'>";

		echo "Nom utilisateur/pseudo <INPUT type='text' name = 'pseudo' value = '".$_GET['pseudo']."'> <br> ";
		echo "Mot de passe <INPUT type='password' name = 'mdp' value = ''><br>";
		echo "<INPUT type='submit'  value = 'Envoyer'>";


		echo "</form>";

		?>

		</br></br>
		
		</div>

 		<footer>
	<?php
		session_start();
		if(isset($_SESSION['utilisateur'])) {
			echo "~   <a>Bonjour ".$_SESSION['utilisateur']["pseudo"]." !</a> ";
			echo "   |   <a href='deconnexion.php'>Se déconnecter</a>   ~";
		}
		else {
			echo "   |   <a href='nouveau.php'>Nouveau Utilisateur</a>";
		}
	?> 

		<div class="footer">
		<object data="Pied_de_page.html" width="100%" height="100%">
		</object>
		</div>
	</footer>  

	</body>
</html>