<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
  <title>Carte Olympiades</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="Styles/frise_chrnologique.css">
  <style>
    #map {
      width: 100%;
      height: 400px;
    }
  </style>
  <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">
</head>
<body>
<iframe src="Barre_de_navigation.html" width="100%" height="5%" frameborder="0"></iframe>
<div class="container">
  <h1>Comparons par <div class="edition">&nbsp; éditions</div></h1>
  <p class="tiret" id='ancre'>_______</p>
  <h2>54 &eacute;ditions de Jeux Olympiques depuis 1896 !</h2>
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
			<a href="Carte_des_editions.php#ancre"><button class="btn btn-outline-info float-right">&#128269; Villes Organisatrices</button></a>
		</div>
		<div class="d-flex justify-content-between">
				<p><img src='https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png' alt='Marqueur bleu' height='25px' class="mx-3">Olympiades d'Hiver</p>
			<a href="Carte_des_editions.php?view=p#ancre"><button class="btn btn-outline-dark float-right">&#128269; Pays Organisateurs&nbsp;&nbsp;</button></a>
		</div>
		<div class="d-flex justify-content-between">
				<p><img src='https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png' alt='Marqueur vert' height='25px' class="mx-3">Olympiades d'&Eacutet&eacute; et d'Hiver</p>
		</div>
	</p>
	

</div>
<iframe class="my-5" src="Pied_de_page.html" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>