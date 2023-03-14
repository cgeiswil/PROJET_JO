<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/profil.css" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
  </head>
  <body>

    <?php
    session_start();
    if(isset($_SESSION['utilisateur'])){ ?>
      <object data="Barre_de_navigation.html" width="100%" height="100%">
      </object>
       <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 bg-light sidebar">
              <div class="sidebar-sticky">
                <img src="../Images/Profil/profil.png" alt="Ma photo">
                <h2>Informations Personnelles</h2>
                <p>Pseudo : ...</p>
                <p>Email : exemple@gmail.com</p>
                <p>Intérêts : Athlètes ..</p>
              </div>
            </div>
            <div class="col-md-9">
              <h1>Mon profil</h1>
              <p>Mon contenu principal ici...</p>
              <div class="text-center">
                <button type="button" class="btn btn-primary">Changer les informations d'utilisateur</button>
              </div>
            </div>
          </div>
        </div> 
      <div class="footer">
      <object  data="Pied_de_page.html" width="100%" height="100%">
      </object>
      </div>
    <?php 
    }else{
        echo '<meta http-equiv="refresh" content="0; url=connection.php ">';
    } 


    ?> 


   
  
  

  </body>
</html>