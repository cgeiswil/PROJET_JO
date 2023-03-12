<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Edition par frise chronologique</title>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="Styles/frise_chrnologique.css">
	<style>
		.evenement img {
			width: 150px;
			height: 150px;
			margin: auto;
		}
		.slick-slide {
			text-align: center;
			color: #000;
			background: #fff;
			margin: 0 20px;
		}
       
    .slick-prev,
    .slick-next {
        font-size: 0;
        line-height: 0;
        position: absolute; 
        top: 50%;
        display: block;
        width: 20px;
        height: 20px;
        padding: 0;
        -webkit-transform: translate(0, -50%);
        -ms-transform: translate(0, -50%);
        transform: translate(0, -50%);
        cursor: pointer;
        color: transparent;
        border: none;
        outline: none;
        background: transparent;
    }
    .slick-prev:before,
    .slick-next:before {
        font-size: 20px;
        line-height: 1;
        color: #000;
        opacity: 0.75;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .slick-prev {
        left: 10px;
    }
    .slick-next {
        right: 10px;
    }
	</style>
</head>
<body>
	
	<object data="Barre_de_navigation.html" width="100%" height="100%">
	</object>

	<h1>Comparons par <div class="edition">&nbsp; éditions</div></h1>
	<p class="tiret">_______</p>
	<h2>Frise chronologique des Jeux Olympiques <br> depuis leurs créations</h2>
	<br>

	<div class="container">
				<div class="frise slider">
					<?php	
					require("fonction.php");
					$bdd = getBDD();
					$rep = $bdd->query("SELECT logo, annee_o, saison, pays_hote, id_olympiade FROM `olympiades` ORDER BY annee_o");
					while($ligne = $rep->fetch()) {
						echo '<div class="evenement">';
						echo '<p>' . $ligne['saison'] ." ". $ligne['pays_hote'] . '</p>';
						echo '<a href="Edition_particuliere.php?id=' . $ligne['id_olympiade'] . '" target="_top"><img src="' . $ligne['logo'] . '" alt="Logo des Jeux Olympiques">';
						echo '<p class="annee">' . $ligne['annee_o'] . '</p>';
						echo '</div>';
					}
					?>
					<button type="button" class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
   					<button type="button" class="slick-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
				</div>
	</div>
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
    $('.slider').slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 5,
        prevArrow: '<button type="button" class="slick-prev"><</button>',
        nextArrow: '<button type="button" class="slick-next">></button>'
    });
});
</script>

<!--
	<div class="footer">
		<object  data="Pied_de_page.html" width="100%" height="100%">
		</object>
	</div>
	-->

</body>
</html>


