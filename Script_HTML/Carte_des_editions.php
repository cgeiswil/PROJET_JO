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
  <p class="tiret">_______</p>
  <h2>Carte montrant toutes les éditions de Jeux Olympiques</h2>
  <br>
  <p>Description <strong>Paris en 1924.</strong></p>
  <br>
  <div id="map"></div>
  <script>
    var map = L.map('map').setView([0, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Récupération des données des olympiades depuis le serveur
   fetch('recuperer_olympiades.php')
  .then(response => response.json())
  .then(data => {
    const olympiades = data;
    // Ajout des marqueurs pour chaque olympiade
    for (let i = 0; i < olympiades.length; i++) {
      let lat = parseFloat(olympiades[i].latitude);
      let lon = parseFloat(olympiades[i].longitude);
      let nom = olympiades[i].ville_hote;
      let annee = olympiades[i].annee_o;

      let popupText = "<b>" + nom + " " + annee + "</b><br>";
      popupText += "<a href='Edition_particuliere.php?id=" + olympiades[i].id_olympiade + "'>Voir la page de l'édition.</a>";

      L.marker([lat, lon]).addTo(map).bindPopup(popupText);
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