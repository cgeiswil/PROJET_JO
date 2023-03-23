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
  
	<object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>
  
	<div class="container">
		<h1 class="mb-3">Mon profil</h1>
		
		<?php
    require("fonction.php");

    $BDD = getBDD();


		session_start();
		if(isset($_SESSION['utilisateur'])){ 
      $anecdotes = $BDD->query("select * from apprecier_an as AA, anecdotes where AA.id_anecdote = anecdotes.id_anecdote and AA.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);
      
      $pays = $BDD->query("select * from pays_participants as pays, apprecier_p as Ap where Ap.CODE_CIO = pays.Code_CIO and Ap.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

      $athletes = $BDD->query("select * from athletes, apprecier_at as At where At.id_athlete = athletes.ID_athletes and At.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

      $discipline = $BDD->query("select * from disciplines, apprecier_d as Ad where Ad.id_discipline = disciplines.id_discipline and Ad.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

     $epreuves = $BDD->query("select * from disciplines, apprecier_e as Ae, epreuves where Ae.id_epreuve = epreuves.id_epreuves and epreuves.id_disciplines = disciplines.id_discipline and Ae.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

     $olympiade = $BDD->query("select * from olympiades, apprecier_o as Ao where Ao.id_olympiade = olympiades.id_olympiade and Ao.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);


      ?>
			  <div class="row">
				<div class="col-sm bg-light sidebar">
				  <div class="sidebar-sticky">
					<img src="../Images/Profil/profil.png" alt="Ma photo">
					<h2>Informations Personnelles</h2>
					<p>Pseudo : <?php echo $_SESSION['utilisateur']['pseudo'];
          ?></p>
					<p>Email : <?php echo $_SESSION['utilisateur']['email'];
          ?></p>
					<p>Intérêts : Athlètes ..</p>
					
					<a href='deconnexion.php' class='btn btn-primary'>Se d&eacute;connecter</a><br> 
				  </div>
				</div>
				<div class="col-sm">
				  <h2>Mes préférences</h2>
          <h3> Anecdotes </h3>
          <table>
            <tr>  
              <th> Intitul&eacute; </th> 
              <th> Source </th>
              <th> Cat&eacute;gorie </th>
              <th> Olympiade concern&eacute;e </th>
            </tr>
            <?php
            while ($ligneAn = $anecdotes ->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAn['anecdote']."</td>";
              echo "<td> <a href= ".$ligneAn['source'].">".$ligneAn['source']."</td>";
              echo "<td>".$ligneAn['categorie']."</td>";
              echo "<td>".$ligneAn['annee']."</td>";
              echo "</tr>";
            }
            ?>
          </table>
          <h3> Mes pays favoris </h3>
          <table>
            <tr>  
              <th> Pays </th> 
              <th> Population </th>
              <th> PIB nominal </th>
              <th> Olympiade concern&eacute;e </th>
            </tr>
          <?php
            while ($ligneAp = $pays ->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAp['nom_pays']."</td>";
              echo "<td>".$ligneAp['population']."</td>";
              echo "<td>".$ligneAp['pib_en_milliardsUSD']."</td>";
              echo "<td> <img src= ".$ligneAp['l_drapeau']." alt= 'oups'></td>";
              echo "</tr>";
            }
            ?>
          </table>

          <h3> Mes athl&agrave;tes favoris </h3>
          <table>
            <tr>  
              <th> Nom </th> 
            </tr>
          <?php
            while ($ligneAt = $athletes->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAt['nom']."</td>";
              echo "</tr>";
            }
            ?>
          </table>

          <h3> Mes disciplines favorites </h3>
          <table>
            <tr>  
              <th> Discipline </th> 
              <th> Pictogramme </th>
            </tr>
          <?php
            while ($ligneAd = $discipline ->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAd['nom_discipline']."</td>";
              echo "<td> <img src= ".$ligneAd['pictogramme']." alt= 'oups'></td>";
              echo "</tr>";
            }
            ?>
          </table>

          <h3> Mes &eacute;preuves favorites </h3>
          <table>
            <tr>  
              <th> &eacute;preuve </th> 
              <th> Discipline &agrave; laquelle appartient l'&eacute;preuve </th>
              <th> Pictogramme de la discipline</th>
            </tr>
          <?php
            while ($ligneAe = $epreuves ->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAe['epreuves']."</td>";
              echo "<td>".$ligneAe['nom_discipline']."</td>";
              echo "<td> <img src= ".$ligneAe['pictogramme']." alt= 'oups'></td>";
              echo "</tr>";
            }
            ?>
          </table>


          <h3> Mes olympiades favorites </h3>
          <table>
            <tr>  
              <th> Ann&eacute;e </th> 
              <th> Pays h&ocirc;te </th>
              <th> Saison</th>
              <th> Num&eacute;ro d'&eacute;dition </th>
            </tr>
          <?php
            while ($ligneAo = $olympiade ->fetch()) {
              echo "<tr>";
              echo '<td><a href="Edition_particuliere.php?id='.$ligneAo['id_olympiade'].'">'.$ligneAo['annee_o'].'</td>';
              echo "<td>".$ligneAo['pays_hote']."</td>";
              echo "<td>".$ligneAo['saison']."</td>";
              echo "<td>".$ligneAo['n_edition']."</td>";
              echo "</tr>";
            }
            ?>
          </table>



				  
				  <!--<div class="text-center">
					<button type="button" class="btn btn-primary">Changer les informations d'utilisateur</button>
				  </div>-->
				</div>
				<div class="col-sm">
				
				<h2>Historique des quiz</h2>
				
				<?php
				 $utilisateur_id = $_SESSION['utilisateur']['utilisateur'];
  				 $resultats = $BDD->query("SELECT quiz.difficulte, repondre.score FROM repondre, quiz WHERE quiz.id_quiz=repondre.id_quiz AND repondre.id_utilisateur= $utilisateur_id ORDER BY repondre.id_repondre DESC LIMIT 10");
  				 $resultats->execute([$utilisateur_id]);

 				 if($resultats->rowCount() > 0) {
      				echo "<table><tr><th>Niveau de difficult&eacute;</th><th>Score</th></tr>";
      				while ($row = $resultats->fetch()) {
          			echo "<tr><td>".$row["difficulte"]."</td><td>".$row["score"]."</td></tr>";
      					}
     					echo "</table>";
 					} else {
     					 echo "Vous n'avez pas encore fait de quiz.";
  					}
  				?>
  				<!-- Bouton pour afficher le graphique -->
				<button type="button" class="btn btn-primary" onclick="afficherGraphique()">Voir l'&eacute;volution de vos r&eacute;sultats</button>

				<!-- Zone pour afficher le graphique -->
				<div id="graphique"></div>

				<script>
				function afficherGraphique() {
 					// Envoyer une requête AJAX à PHP pour générer le graphique
  					var xhr = new XMLHttpRequest();
  					xhr.onreadystatechange = function() {
    				if (xhr.readyState === 4 && xhr.status === 200) {
      					// Afficher la réponse (le graphique) dans la zone dédiée
      					document.getElementById("graphique").innerHTML = xhr.responseText;
    				}
 				 };
  				xhr.open("GET", "generer_graphique.php", true);
  				xhr.send();
				}
				</script>


			  </div>
			  
			 </div>
			  
	  </div>
      <iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
    


    <?php 
    }else{
        echo '<meta http-equiv="refresh" content="0; url=connection.php ">';
    }
    ?> 


   
  
  

  </body>
</html>