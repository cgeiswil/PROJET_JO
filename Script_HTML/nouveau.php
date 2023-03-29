<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title> Nouveaux Utilisateurs </title>
	    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>
		<object data='Barre_de_navigation.html' width='100%'' height='100%''></object>
		
		<div class="container">
		<h3>&Ecirc;tes-vous pr&ecirc;ts &agrave; d&eacute;couvrir le monde des Jeux Olympiques ?</h3>
		<h4 class="mb-3">Entrez quelques informations, et c&#039;est parti pour explorer les donn&eacute;es !</h4>
		
			<ol>
			  <form method="post" action="enregistrement.php" autocomplete="on">
				<li class="form-group">
				  <label for="pseudo">Pseudo</label>
				  <input type="text" class="form-control" id="pseudo" name="ps" value="<?php echo $_GET['ps'] ?? ''; ?>" style="width: 400px;">
				</li>
				<li class="form-group">
				  <label for="mail">Mail</label>
				  <input type="text" class="form-control" id="mail" name="mail" value="<?php echo $_GET['mail'] ?? ''; ?>" style="width: 400px;">
				</li>
				<li class="form-group">
				  <label for="mdp">Mot de passe</label>
				  <input type="password" class="form-control" id="mdp" name="mdp" value="" style="width: 400px;">
				</li>
				<li class="form-group">
				  <label for="mdp2">Confirmer le mot de passe</label>
				  <input type="password" class="form-control" id="mdp2" name="mdp2" value="" style="width: 400px;">
				</li>
				
				<button type="submit" class="btn btn-success">C'est parti !</button>
			  </form>
			</ol>
		
			<div class="container"><br>
				<?php
					session_start();
					if(isset($_SESSION['utilisateur'])) {
					  echo "<a>Bonjour ".$_SESSION['utilisateur']["pseudo"]." !</a>";
					  echo "<a href='deconnexion.php' class='btn btn-primary'>Se d&eacute;connecter</a>";
					  header('Location: Profil.php');
					  exit();
					} else {
					  echo "<a href='connection.php' class='btn btn-primary'>J&#039;ai d&eacute;j&agrave; un compte.</a>";
					}
				?>
			</div>
		</div>

	<iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
	</body>
</html>