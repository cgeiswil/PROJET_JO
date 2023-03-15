<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ma page web</title>
  <!-- liens vers les fichiers CSS et JS nécessaires pour faire fonctionner la barre de navigation -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
  html{
  background-color: #F5F5F5;
  }
  body{
   background-color: #F5F5F5;
  }
  
  </style>
</head>


<body class="d-flex flex-column" >
<footer class="page-footer font-small indigo">
  <div class="container text-center text-md-left">
    <div class="row">
      <?php
      // session_start();
      // if(isset($_SESSION['utilisateur'])) {
        // echo "~   <a>Bonjour ".$_SESSION['utilisateur']["nom"]." !</a> ";
        // echo "   |   <a href='deconnexion.php'>Se déconnecter</a>   ~";
      // }
      // else {
        // echo "   |   <a href='nouveau.php'>Nouveau Client</a>";
        // echo "   |   <a href='connection.php'>Se connecter</a>   ~<br>";
      // }
      ?>
	
		<p class="my-3"><em>&ensp;« L’important dans la vie n'est point le triomphe mais le combat, l’essentiel ce n'est pas d’avoir vaincu, mais de s’être bien battu. »</em> &ensp; Maxime de l'Olympisme.</p><br>
		
		<div class="col-md-3 mx-auto">
		  <p class="font-weight-bold mt-3 mb-1"><a href="Accueil.php" target="_top">Accueil</a></p>
		</div>
		<div class="col-md-3 mx-auto">
		  <p class="font-weight-bold mt-3 mb-1"><a href="Qui_sommes_nous.html" target="_top">Qui sommes-nous ?</a></p>
		</div>
		<div class="col-md-3 mx-auto">
		  <p class="font-weight-bold mt-3 mb-1"><a href="Bibliographie.html" target="_top">Bibliographie</a></p>
		</div>
		<div class="col-md-3 mx-auto">
		  <p class="font-weight-bold mt-3 mb-1"><a href="Mentions_legales.html" target="_top">Mentions Légales et CGU</a></p>
		</div>
    </div>
  </div>

</footer>
</body>
</html>