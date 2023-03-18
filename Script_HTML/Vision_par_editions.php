<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Toutes les &eacute;ditions</title>
	<link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
	
	<!-- CARTE -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
	<style>
	#map {
	  width: 100%;
	  height: 400px;
	}
	</style>
  
	<!-- FRISE -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
	<script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="Styles/frise_chrnologique.css">
</head>

<body> <!-- CARTE -->
	<iframe src="Barre_de_navigation.html" width="100%" height="5%" frameborder="0"></iframe>
	<div class="container">
	  <h1>Comparons par<div class="edition">&eacute;ditions</div></h1>
	  <p class="tiret">_______</p>
	  <h2 id='carte'>54 Jeux Olympiques se sont d&eacute;roul&eacute;s depuis 1896 !</h2>
	  <br>
	  <div id="map"></div>
		  <script>
			let latView = <?php echo $_GET['lat'] != "" ? $_GET['lat'] : 22; ?>;
			let lonView = <?php echo $_GET['lon'] != "" ? $_GET['lon'] : 0; ?>;
			let paysORville = '<?php echo isset($_GET['view']) && $_GET['view'] != "" ? "p" : "v"; ?>';
			let zoomView = <?php echo ($_GET['lat'] != "" AND $_GET['lon'] != "") ? 5 : 2; ?>; 
			var map = L.map('map').setView([latView, lonView], zoomView);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

		// Récupération des données des olympiades depuis le serveur
		   fetch('Carte_des_editions_recuperer_olympiades.php')
		  .then(response => response.json())
		  .then(data => {
			const olympiades = data;
			
		// Ajout des marqueurs pour chaque olympiade
			let popupTextByCoordinates = {};
			
			if(paysORville == 'v') { // Vision par Villes organisatrices
				for (let i = 0; i < olympiades.length; i++) {
				  let lat = parseFloat(olympiades[i].latitude);
				  let lon = parseFloat(olympiades[i].longitude);
				  let saison = olympiades[i].saison == 'Summer' ? '&Eacutet&eacute;' : 'Hiver';

				  let popupText = "<a href='Edition_particuliere.php?id=" + olympiades[i].id_olympiade + "'>Olympiade d'" + saison + " " + olympiades[i].annee_o + "</a>";

				  let coordinates = lat + "," + lon;
				  if (coordinates in popupTextByCoordinates) {
					// Si les coordonnées existent déjà, ajouter le nouveau popupText à la suite
					popupTextByCoordinates[coordinates] += "<br>" + popupText;
				  } 
				  else { 
					// Sinon, ajouter un nouvel élément à l'objet
					popupTextByCoordinates[coordinates] = '<img src="' + olympiades[i].I_drapeau + '" alt="Drapeau ' + olympiades[i].pays_hote + '" class="img-thumbnail border-0" width="40px"><b>' + olympiades[i].nom + " (" + olympiades[i].pays_hote + ")</b><br>" + popupText;
				  }
				}
			}
			else { // Vision par Pays organisateurs
			let summer_indication = 'Olympiades d\'&Eacutet&eacute; :<br>';
			let pays = '';
				for (let i = 0; i < olympiades.length; i++) {
				  let lat = parseFloat(olympiades[i].latitude_pays);
				  let lon = parseFloat(olympiades[i].longitude_pays);
				  let saison = olympiades[i].saison == 'Summer' ? '&Eacutet&eacute;' : 'Hiver';

				  let popupText = "<a href='Edition_particuliere.php?id=" + olympiades[i].id_olympiade + "'>" + olympiades[i].nom + ' ' + olympiades[i].annee_o + "</a>";
				  
				  if (saison == 'Hiver') { summer_indication = 'Olympiades d\'Hiver :<br>'; }

				  let coordinates = lat + "," + lon;
				  if (coordinates in popupTextByCoordinates) {
				  // Si les coordonnées existent déjà, ajouter le nouveau popupText à la suite
					if (popupTextByCoordinates[coordinates].includes("Olympiades d'Hiver") || summer_indication == 'Olympiades d\'&Eacutet&eacute; :<br>') {
						popupTextByCoordinates[coordinates] += "<br>" +  popupText;
					} else {
						popupTextByCoordinates[coordinates] += "<br>" + summer_indication + popupText;
					}
				  } else { 
					// Sinon, ajouter un nouvel élément à l'objet
					popupTextByCoordinates[coordinates] = '<img src="' + olympiades[i].I_drapeau + '" alt="Drapeau ' + olympiades[i].pays_hote + '" class="img-thumbnail border-0" width="40px"><b>' + olympiades[i].pays_hote + "</b><br>" + summer_indication + popupText;
				  }
				  pays = olympiades[i].pays_hote;
				}
				
			}

			// Boucle à travers l'objet pour ajouter les marqueurs et regrouper les popups
			for (let coordinates in popupTextByCoordinates) {
				let popupText = popupTextByCoordinates[coordinates];
				let latlon = coordinates.split(",");
				let lat = parseFloat(latlon[0]);
				let lon = parseFloat(latlon[1]);
				
				let couleur = "";
				if (popupText.includes("Hiver") & popupText.includes("&Eacutet&eacute;")) {
				  couleur = "green";
				} else if (popupText.includes("Hiver")) {
				  couleur = "blue";
				} else { // Si saison = Eté
				  couleur = "red";
				}
				// Définition de l'icone
				let customIcon = L.icon({
				  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + couleur + '.png',
				  iconSize: [25, 41], // Taille de l'icône en pixels
				  iconAnchor: [12, 41] // Point d'ancrage de l'icône en pixels
				});

				// Création du marqueur
				  L.marker([lat, lon], { icon: customIcon }).addTo(map).bindPopup(popupText);
				}

			  });
		  </script>
	  <br>
		<p>
			<div class="d-flex justify-content-between">
					<p><img src='https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png' alt='Marqueur rouge' height='25px' class="mx-3">Olympiades d'&Eacutet&eacute;</p>
				<a href="Vision_par_editions.php#carte"><button class="btn btn-outline-info float-right">&#128269; Villes Organisatrices</button></a>
			</div>
			<div class="d-flex justify-content-between">
					<p><img src='https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png' alt='Marqueur bleu' height='25px' class="mx-3">Olympiades d'Hiver</p>
				<a href="Vision_par_editions.php?view=p#carte"><button class="btn btn-outline-dark float-right">&#128269; Pays Organisateurs&nbsp;&nbsp;</button></a>
			</div>
			<div class="d-flex justify-content-between">
					<p><img src='https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png' alt='Marqueur vert' height='25px' class="mx-3">Olympiades d'&Eacutet&eacute; et d'Hiver</p>
			</div>
		</p>
		

	</div>

	<!-- FRISE -->

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
		<?php
		echo '<h2 class="mt-5" id="frise">Les Jeux Olympiques sont r&eacute;apparus depuis ' . (date('Y') - 1896) . ' ann&eacute;es !</h2>';
		?>
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
	<iframe class="mt-5" src="Pied_de_page.php" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>

