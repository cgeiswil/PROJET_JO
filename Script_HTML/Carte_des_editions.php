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
  <h1>Comparons par <strong class="edition">&eacute;ditions</strong></h1>
  <p class="tiret" id='ancre'>_______</p>
  <h2>Carte montrant toutes les &eacute;ditions de Jeux Olympiques</h2>
  <br>
  <div id="map"></div>
  <script>
    let latView = <?php echo $_GET['lat'] != "" ? $_GET['lat'] : 22; ?>;
    let lonView = <?php echo $_GET['lon'] != "" ? $_GET['lon'] : 0; ?>;
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
// Créer un objet pour stocker les popupText avec les mêmes coordonnées
let popupTextByCoordinates = {};

for (let i = 0; i < olympiades.length; i++) {
  let lat = parseFloat(olympiades[i].latitude);
  let lon = parseFloat(olympiades[i].longitude);
  let nom = olympiades[i].nom;
  let annee = olympiades[i].annee_o;
  let saison = olympiades[i].saison == 'Summer' ? '&Eacutet&eacute;' : 'Hiver';

  let popupText = "<b>" + nom + ' ' + annee + ' (' + saison + ")</b><br>";
  popupText += "<a href='Edition_particuliere.php?id=" + olympiades[i].id_olympiade + "'>Voir la page de l'édition.</a>";

  let coordinates = lat + "," + lon;
  if (coordinates in popupTextByCoordinates) {
    // Si les coordonnées existent déjà, ajouter le nouveau popupText à la suite
    popupTextByCoordinates[coordinates] += "<br>" + popupText;
  } else {
    // Sinon, ajouter un nouvel élément à l'objet
    popupTextByCoordinates[coordinates] = popupText;
  }
}

// Boucler à travers l'objet pour ajouter les marqueurs et regrouper les popups
for (let coordinates in popupTextByCoordinates) {
	let popupText = popupTextByCoordinates[coordinates];
	let latlon = coordinates.split(",");
	let lat = parseFloat(latlon[0]);
	let lon = parseFloat(latlon[1]);
	
	let couleur = "";
	if (popupText.includes("Hiver")) {
	  // Faire quelque chose si popupText se termine par "Hiver))</b><br>"
	  couleur = "blue";
	} else {
	  // Faire autre chose si popupText ne se termine pas par "Hiver))</b><br>"
	  couleur = "red";
	}
	// Créer une icône personnalisée avec l'URL de l'image
	let customIcon = L.icon({
	  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + couleur + '.png',
	  iconSize: [25, 41], // Taille de l'icône en pixels
	  iconAnchor: [12, 41] // Point d'ancrage de l'icône en pixels
	});

	// Créer un marqueur
	  L.marker([lat, lon], { icon: customIcon }).addTo(map).bindPopup(popupText);
	}

  });
  </script>
  
  <br>
  <br>
  <br>
</div>
<iframe src="Pied_de_page.html" width="100%" height="50%" frameborder="0"></iframe>
</body>
</html>