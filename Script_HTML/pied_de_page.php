<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pied de page</title>
  <!-- liens vers les fichiers CSS et JS nécessaires pour faire fonctionner la barre de navigation -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
  #pied{
   background-color: #F5F5F5;
  }
  </style>
</head>

<body class="d-flex flex-column" >
	<footer id="pied" class="page-footer font-small indigo">
	  <div class="container text-center text-md-left">
		<div class="row">
		 
		
			<p class="my-3"><em>&ensp;« L’important dans la vie n'est point le triomphe mais le combat, l’essentiel ce n'est pas d’avoir vaincu, mais de s’être bien battu. »</em> &ensp; Maxime de l'Olympisme.</p><br>
			
			<div class="col-md-2 mx-auto p-auto">
				<p class="font-weight-bold mt-1 mb-1">
					<div class="border-top border-dark"></div>
					<?php
					session_start();
					if(isset($_SESSION['utilisateur'])) {
						echo "   <b><a>Bonjour ".$_SESSION['utilisateur']["pseudo"]." !</a> ";
						echo "   <br>   <a href='deconnexion.php' target='_top'>Se déconnecter</a></b>";
					}
					else {
						echo "   <b><a href='connection.php' target='_top'>Se connecter</a><br>";
						echo "   <a href='nouveau.php' target='_top'>S'inscrire</a></b>";
					}
					?>
					<div class="border-top border-dark"></div>
				</p>
			</div>
			<div class="col-md-2 mx-auto">
			  <p class="font-weight-bold mt-2 mb-1"><a href="Accueil.php" target="_top">Accueil</a></p>
			</div>
			<div class="col-md-2 mx-auto">
			  <p class="font-weight-bold mt-2 mb-1"><a href="Qui_sommes_nous.php" target="_top">Qui sommes-nous ?</a></p>
			</div>
			<div class="col-md-2 mx-auto">
			  <p class="font-weight-bold mt-2 mb-1"><a href="Bibliographie.php" target="_top">Bibliographie</a></p>
			</div>
			<div class="col-md-2 mx-auto">
			  <p class="font-weight-bold mt-2 mb-1"><a href="Mentions_legales.php" target="_top">Mentions L&eacute;gales</a></p>
			</div>
		</div>
	  </div>

	</footer>
</body>
</html>