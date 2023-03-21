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
		.slider {
			display: flex;
			align-items: center;
			justify-content: space-between;
			overflow-x: auto;
			scroll-snap-type: x mandatory;
			scroll-behavior: smooth;
			-webkit-overflow-scrolling: touch;
			margin: 0;
			padding: 0;
		}

		.slider::-webkit-scrollbar {
			display: none;
		}

		.slide {
			flex-shrink: 0;
			scroll-snap-align: center;
			text-align: center;
			margin: 0 10px;
		}

		.evenement_img {
			max-height: 150px;
			max-width: 150px;
			margin:auto;
			object-fit: contain;
			object-position: center center;
		}

		.frise img {
			width: auto;
			height: 150px;
			margin-bottom: 5px;
		}
		
		.d-flex.align-items-center img {
			height: auto;
			width: 40px;
			margin-bottom: 0px;
		}
		
		.d-flex.align-items-center {
			height: 100px;
			justify-content: center;
		}

		.frise div .annee {
			text-align: center;
		}

		.frise .annee {
			margin-top: 5px;
		}

		.slick-prev,
		.slick-next {
			position: absolute;
			top: 50%;
			z-index: 1;
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
		
		.frise a {
		   text-decoration: none;
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
					$rep = $bdd->query("SELECT * FROM olympiades, villes_hotes, pays_participants WHERE olympiades.id_ville_hote = villes_hotes.id_ville AND olympiades.Code_CIO = pays_participants.Code_CIO ORDER BY n_edition");
					while($ligne = $rep->fetch()) {
						echo '<div>';
						echo '<div class="d-flex align-items-center">';
							echo '<img src="' . $ligne['I_drapeau'] .'" alt="Drapeau ' . $ligne['pays_hote'] . '" class="img-thumbnail border-0" width="40px">';
							echo '<p class="mb-0 ms-2"><b>' . $ligne['pays_hote'] .  '</b><br>' . $ligne['nom'] . '</p>';
						echo '</div>';
						echo '<a href="Edition_particuliere.php?id=' . $ligne['id_olympiade'] . '" target="_top"><img class="evenement_img" src="' . $ligne['logo'] . '" alt="Logo des Jeux Olympiques">';
						echo '<p class="annee  pt-2">' . ($ligne['saison']== 'Summer' ? '&Eacutet&eacute; ' : 'Hiver ') . $ligne['annee_o'] . '</p>';
						echo '</a></div>';
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
        slidesToShow: 4,
        slidesToScroll: 4,
        prevArrow: '<button type="button" class="slick-prev"><</button>',
        nextArrow: '<button type="button" class="slick-next">></button>'
    });
});
</script>


</div>
<iframe class="my-5" src="Pied_de_page.html" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>

