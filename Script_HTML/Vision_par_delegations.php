<!DOCTYPE html>

<html lang = "fr">


<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <link href="./Styles/Vision_par_delegations.css" rel="stylesheet" type = "text/css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

<title>  Médailles/délégations  </title>
<style type="text/css">
.containe{
	display: flex;
	justify-content : center;
	margin: auto;
	margin-bottom: 200px;
	}
	</style>
</head>


<body  class="d-flex flex-column">


	<object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>
	
	
	<h1 style='font-size: 50px;'><strong>Comparons par <span>d&eacute;l&eacute;gations</span></strong></h1>
	<h2 class='mt-1 mb-5'>Par disciplines, m&eacute;dailles ou records.</h2>


	<div class="containe">
	<div class="row">
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('disciplines').style.display='block'"><a href="Classement_Delegation_disciplines.php#disciplines" ><img src="../Images/Boutons/discipline.png" alt="erreur"></a>
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('médailleCIO').style.display='block'"><a href="Classement_Delegation_medailles.php#medailleCIO" >
				<img src="../Images/Boutons/medaille_or.png"></a>
			</button>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-outline-dark" onclick="document.getElementById('records').style.display='block'"> <a href="Classement_Delegation_records.php?nom_discipline=Athletics#record" >
				<img src="../Images/Boutons/record_(podium,couronne).png"></a>
			</button>
		</div>
	</div>
</div>

<footer>	
    <?php
        include "pied_de_page.php";
    ?>
    </footer>
</body>

</html>