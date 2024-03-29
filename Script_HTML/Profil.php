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
	<style>
	.pref{
	width: 80%;
	margin: auto;}
	.picto{width: 100px;
	height: 100px;}
	.logo{
	width: 30%;}
	</style>
  </head>
  <body>
  
	
  <header>
  <?php
    include "Barre_de_navigation.html";
    ?>
  </header>

		
		<?php
		
    require("fonction.php");
    



    $BDD = getBDD();

		session_start();
		if(isset($_SESSION['utilisateur'])){ 
      $anecdotes = $BDD->query("select * from anecdotes, apprecier_an as AA where AA.id_anecdote = anecdotes.id_anecdote and AA.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);
      
      $pays = $BDD->query("select * from pays_participants as pays, apprecier_p as Ap where Ap.CODE_CIO = pays.Code_CIO and Ap.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

      $athletes = $BDD->query("select * from athletes, apprecier_at as At where At.id_athlete = athletes.ID_athletes and At.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

      $discipline = $BDD->query("select * from disciplines, apprecier_d as Ad where Ad.id_discipline = disciplines.id_discipline and Ad.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

     $epreuves = $BDD->query("select * from disciplines, apprecier_e as Ae, epreuves where Ae.id_epreuve = epreuves.id_epreuves and epreuves.id_disciplines = disciplines.id_discipline and Ae.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);

     $olympiade = $BDD->query("select * from olympiades, apprecier_o as Ao where Ao.id_olympiade = olympiades.id_olympiade and Ao.id_utilisateur=".$_SESSION['utilisateur']['utilisateur']);


      ?>
     <div class="pref">
    <div class="row">
		<div class="col-sm-5">
				  <div class="info_pers">
					<img src="../Images/Profil/profil.png" alt="Ma photo">
					<h2 class="information">Informations Personnelles</h2>
					<p>Pseudo : <?php echo $_SESSION['utilisateur']['pseudo'];?></p>
					<p>Email : <?php echo $_SESSION['utilisateur']['email'];?></p>
					
					<a href='deconnexion.php' class='btn btn-primary'>Se d&eacute;connecter</a><br> 
				  </div>
		</div>
		<div class="col-md-5">
			<h1>Mon profil</h1>
		</div>
	</div>
	<br>
	<br>
			 <h2>Mes pr&eacute;f&eacute;rences</h2>
          <h3> Anecdotes favorites</h3>
          <table>
            <tr>  
              <th> Intitul&eacute; &nbsp;</th> 
              <th> Source &nbsp;</th>
            </tr>
            <?php
            while ($ligneAn = $anecdotes ->fetch()) {
              echo "<tr>";
              echo "<td>".$ligneAn['anecdote']."</td>";
              echo "<td> <a href= ".$ligneAn['source'].">".$ligneAn['source']."</td>";
              echo "</tr>";
            }
            ?>
          </table>
          <h3> Mes pays favoris </h3>
          <table>
            <tr>   
              <th> Drapeau </th>
              <th> Pays </th>
            </tr>
          <?php
            while ($ligneAp = $pays ->fetch()) {
              echo "<tr>";
              echo "<td> <img class='drapeau' src= ".$ligneAp['I_drapeau']." alt= 'oups'></td>";
              echo '<td><a href="Pays_particulier.php?id='.$ligneAp['Code_CIO'].'">'.$ligneAp['nom_pays'].'</td>';
              echo "</tr>";
            }
            ?>
          </table>

          <h3> Mes disciplines favorites </h3>
          <table>
            <tr>   
              <th> Pictogramme </th>
              <th> Discipline </th>
            </tr>
          <?php
            while ($ligneAd = $discipline ->fetch()) {
              echo "<tr>";
              echo "<td> <img class='picto' src= ".$ligneAd['pictogramme']." alt= 'oups'></td>";
              echo "<td>".$ligneAd['nom_discipline']."</td>";
              echo "</tr>";
            }
            ?>
          </table>


          <h3> Mes olympiades favorites </h3>
          <table>
            <tr>  
            	 <th>Logo</th>
              <th> Ann&eacute;e </th> 
              <th> Pays h&ocirc;te </th>
              <th> Saison</th>
            </tr>
          <?php
            while ($ligneAo = $olympiade ->fetch()) {
              echo "<tr>";
              echo '<td><a href="Edition_particuliere.php?id='.$ligneAo['id_olympiade'].'"><img class="logo" src= '.$ligneAo["logo"].' alt= "logo"></td>';
              echo '<td><a href="Edition_particuliere.php?id='.$ligneAo['id_olympiade'].'">'.$ligneAo['annee_o'].'</td>';
              echo "<td>".$ligneAo['pays_hote']."</td>";
              echo "<td>".$ligneAo['saison']."</td>";
              echo "</tr>";
            }
            ?>
          </table>
          <h3> Athl&egrave;tes favoris</h3>
	        <table>
	          <tr>  
	            <th>Nom</th> 
	          </tr>
	          <?php
	          while ($ligneAt = $anecdotes ->fetch()) {
	            echo "<tr>";
	            echo "<td>".$ligneAt['nom']."</td>";
	            echo "</tr>";
	          }
	          ?>
	          </table>
       </div>
		<br>
		<br>
		<br>

	  <div class="row">
		<div class="col-md-6">				
				<h2 class="centrer">Historique des quiz</h2>
				<br>
				<h4 class="centrer">Voici l'historique de vos 10 derniers quiz !</h4>
			 	
				<br>

				
				<?php
				
				 $utilisateur_id = $_SESSION['utilisateur']['utilisateur'];
  			 $resultats = $BDD->prepare("select quiz.difficulte, repondre.score FROM repondre, quiz WHERE quiz.id_quiz=repondre.id_quiz AND repondre.id_utilisateur= ? ORDER BY repondre.id_repondre DESC LIMIT 10");
  			 $resultats->execute([$utilisateur_id]);
  			 

 				 if($resultats->rowCount() > 0) {
      				echo "<table class='centrer'><tr><th>Niveau de difficult&eacute; &emsp;</th><th>Score</th></tr>";
      				while ($row = $resultats->fetch()) {
          			echo "<tr><td>".$row["difficulte"]."</td><td>".$row["score"]."/10</td></tr>";
      					}
     					echo "</table>";
 					} else {
     					 echo "<p class='centre'>Vous n'avez pas encore fait de quiz.</p>";
  					}
  				?>
  			</div>
  			<div class="col-md-5">		
  			<h2>Statistique</h2>
  			<div class="graphique">
  			<p>Si les graphiques ne s'affichent pas, <strong>faites des quiz !</strong></p>
  			<br>
  			<?php
  			$utilisateur_id = $_SESSION['utilisateur']['utilisateur'];
			$resultats = $BDD->query("SELECT quiz.difficulte, AVG(repondre.score) as moyenne_score FROM repondre, quiz WHERE repondre.id_quiz=quiz.id_quiz AND repondre.id_utilisateur=$utilisateur_id GROUP BY repondre.id_quiz");
			$difficulte = array();
			$moyenne_score = array();
			while ($row = $resultats->fetch()) {
    			$difficulte[] = $row['difficulte'];
    			$moyenne_score[] = $row['moyenne_score'];
			}
			$_SESSION['moyenne_score'] = $moyenne_score;
			$_SESSION['difficulte'] = $difficulte;
			?>
			<?php
			$utilisateur_id = $_SESSION['utilisateur']['utilisateur'];
			$resultats = $BDD->query("SELECT quiz.difficulte, (repondre.score) as facile FROM repondre, quiz WHERE repondre.id_quiz=quiz.id_quiz AND repondre.id_utilisateur=$utilisateur_id  AND quiz.difficulte='Facile'");
			$facile = array();
			while ($row = $resultats->fetch()) {
    			$facile[] = $row['facile'];
			}
			$_SESSION['facile'] = $facile;
			
			
			$resultats = $BDD->query("SELECT quiz.difficulte, (repondre.score) as moyen FROM repondre, quiz WHERE repondre.id_quiz=quiz.id_quiz AND repondre.id_utilisateur=$utilisateur_id  AND quiz.difficulte='Moyen'");
			$moyen = array();
			while ($row = $resultats->fetch()) {
    			$moyen[] = $row['moyen'];
			}
			$_SESSION['moyen'] = $moyen;
			
			
			$resultats = $BDD->query("SELECT quiz.difficulte, (repondre.score) as difficile FROM repondre, quiz WHERE repondre.id_quiz=quiz.id_quiz AND repondre.id_utilisateur=$utilisateur_id  AND quiz.difficulte='Difficile'");
			$difficile = array();
			while ($row = $resultats->fetch()) {
    			$difficile[] = $row['difficile'];
			}
			$_SESSION['difficile'] = $difficile;
			
			?>
			
			<div class="graph">
    		<?php

    		if(file_exists('./Graphique_moyenne_quiz.php')) {
        		echo "<img src='./Graphique_moyenne_quiz.php'/>";
    		} else {
        		echo "Veuillez faire un quiz pour afficher le graphique.";
    		}
    		?>
			</div>
	
			<div class="graph">
    		<?php
    		if(file_exists('./Graphique_evolution_quiz.php')) {
       		echo "<img src='./Graphique_evolution_quiz.php'/>";
    		} else {
        		echo "Veuillez faire un quiz pour afficher le graphique.";
    		}
    		?>
			</div>
		</div>
		</div>
		</div>

  			
  			
  		<footer>	
    <?php
        include "pied_de_page.php";
    ?>
    </footer>


    <?php 
    }else{
        echo '<meta http-equiv="refresh" content="0; url=connection.php ">';
    }
    ?> 


   
  
  

  </body>
</html>