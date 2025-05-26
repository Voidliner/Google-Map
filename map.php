<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Local Highways</title>
  <link rel="icon" href="Visuals/visual_logo.png" type="image/png">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
    }

    #map {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .circle-wrapper {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 60vmin;
      height: 60vmin;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0,0,0,0.4);
      z-index: 10;
      pointer-events: none;
    }

    #traffic-map {
      width: 100%;
      height: 100%;
      pointer-events: auto;
    }

    #ui-layer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      pointer-events: none;
    }

    #logoutBtn {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      background-image: url("Visuals/visual_menu_btn.png");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      z-index: 10000;
      pointer-events: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    #pac-input {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 300px;
      padding: 8px 12px;
      font-size: 16px;
      z-index: 10000;
      pointer-events: auto;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <input id="pac-input" type="text" placeholder="Search for places" />

  <div id="map"></div>

  <div class="circle-wrapper">
    <div id="traffic-map"></div>
  </div>

  <div id="ui-layer">
    <div id="logoutBtn"></div>
  </div>

  <script src="logout.js"></script>

  <script>
    let map, trafficMap, marker;
    let syncing = false;

    function initMap() {
      const centerCoords = { lat: 14.8370, lng: 120.8856 };

      map = new google.maps.Map(document.getElementById("map"), {
        center: centerCoords,
        zoom: 12,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
      });

      trafficMap = new google.maps.Map(document.getElementById("traffic-map"), {
        center: centerCoords,
        zoom: 12,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
      });

      const trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(trafficMap);

      marker = new google.maps.Marker({
        map: map,
      });

      // Sync both maps
      syncMaps(map, trafficMap);
      syncMaps(trafficMap, map);

      // Initialize Autocomplete
      const input = document.getElementById("pac-input");
      const autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo("bounds", map);

      autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
          alert("No details available for input: '" + place.name + "'");
          return;
        }

        const location = place.geometry.location;

        map.setCenter(location);
        map.setZoom(15);
        trafficMap.setCenter(location);
        trafficMap.setZoom(15);

        marker.setPosition(location);
        marker.setVisible(true);
      });
    }

    function syncMaps(source, target) {
      source.addListener("center_changed", () => {
        if (syncing) return;
        syncing = true;
        target.setCenter(source.getCenter());
        target.setZoom(source.getZoom());
        syncing = false;
      });
    }
  </script>

  <!-- Load Google Maps API with Places library -->
  <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp1VnY9DWXcVL1xfkiN7PYzzRh0zgQETU&libraries=places&callback=initMap" 
    async 
    defer>
  </script>
</body>
</html>
