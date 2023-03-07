<!DOCTYPE html>
<html lang='fr'>
  <head>
  	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">        
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<title> Deconnexion</title>
	<?php
		session_start();
		session_unset();
		session_destroy();
		header('Location: Accueil.php');
		exit();
	?>
  </head>
  <body>
  </body>
</html>


