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
		
		<div class="container">
		<h3>Bienvenue, on esp&egrave;re que vous allez bien !</h3>
		<h4 class="mb-3">Entrez vos informations pour vous connecter &agrave; votre compte.</h4>

			<form class="form-horizontal" action="enConnection.php" method="post" autocomplete="on">
			  <div class="form-group">
				<label for="pseudo" class="col-sm-2 control-label">Nom d'utilisateur</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $_GET['pseudo']; ?>" style="max-width: 400px;">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mdp" class="col-sm-2 control-label">Mot de passe</label>
				<div class="col-sm-10">
				  <input type="password" class="form-control" id="mdp" name="mdp" value="" style="max-width: 400px;">
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <input type="submit" class="btn btn-success" value="C'est parti !">
				</div>
			  </div>
			</form>

		<div class="container">
			<?php
				session_start();
				if(isset($_SESSION['utilisateur'])) {
				  echo "<a>Bonjour ".$_SESSION['utilisateur']["pseudo"]." !</a>";
				  echo "<a href='deconnexion.php' class='btn btn-primary'>Se d&eacute;connecter</a>";
				  header('Location: Profil.php');
				  exit();
				} else {
				  echo "<a href='nouveau.php' class='btn btn-primary'>Je cr&eacute;e mon compte.</a>";
				}
			?>
		</div>
	</div>
	
	<iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
	</body>
</html>