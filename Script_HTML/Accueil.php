<!DOCTYPE html>
<html lang="fr">
	<head>
    <title>Les JO Autrement</title>
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">        
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	$(document).ready(function() {
   	 $('.cycle-slideshow').cycle({
      	  fx: 'scrollVert', // effet de transition vertical
      	  speed: 500, // durée de la transition en ms
      	  timeout: 5000 // temps d'affichage de chaque élément en ms
   	 });
	});
	</script>
	</head>
    <body>
    

	<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>
	
	
    <h1>Explorons les jeux olympiques <br> différemment !</h1>
    
    
    
   <div class="cycle-slideshow">
  <div class="cycle-slide">
    <p>Le Saviez-vous ?</p>
  </div>
</div>

	
        
	<div class="footer">
	<object  data="Pied_de_page.html" width="100%" height="100%">
	</object>
	</div>
	<footer>
	<?php
		session_start();
		if(isset($_SESSION['utilisateur'])) {
			echo "~   <a>Bonjour ".$_SESSION['utilisateur']["nom"]." !</a> ";
			echo "   |   <a href='deconnexion.php'>Se déconnecter</a>   ~";
		}
		else {
			echo "~   <a href='contact/contact.php'>Page de Contact</a>";
			echo "   |   <a href='nouveau.php'>Nouveau Client</a>";
			echo "   |   <a href='connection.php'>Se connecter</a>   ~";
		}
	?>
	</footer>  

    </body>
</html>