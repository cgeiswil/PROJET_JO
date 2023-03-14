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

<p><em>&ensp;« L’important dans la vie n'est point le triomphe mais le combat, <br>&ensp; l’essentiel ce n'est pas d’avoir vaincu, mais de s’être bien battu »</em> &ensp; Maxime de l'Olympisme.</p>
<!-- Footer -->
<footer class="page-footer font-small indigo">

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <?php
      session_start();
      if(isset($_SESSION['utilisateur'])) {
        echo "~   <a>Bonjour ".$_SESSION['utilisateur']["nom"]." !</a> ";
        echo "   |   <a href='deconnexion.php'>Se déconnecter</a>   ~";
      }
      else {
        echo "   |   <a href='nouveau.php'>Nouveau Client</a>";
        echo "   |   <a href='connection.php'>Se connecter</a>   ~";
      }
      ?>


      <!-- Grid column -->
      <div class="col-md-3 mx-auto">

        <!-- Links -->
        <h5 class="font-weight-bold mt-3 mb-4"><a href="Accueil.html" target="_top"> Accueil</a></h5>

    

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-3 mx-auto">

        <!-- Links -->
        <h5 class="font-weight-bold  mt-3 mb-4"><a href="Bibliographie.html" target="_top"> Bibliographie</a></h5>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-3 mx-auto">

        <!-- Links -->
        <h5 class="font-weight-bold  mt-3 mb-4"><a href="Mentions_legales.html" target="_top"> Mentions Légales et CGU</a></h5>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      

 

    </div>
    <!-- Grid row -->



  </div>
  <!-- Footer Links -->

</footer>
<!-- Footer -->
  <!-- End -->

</body>
</html>