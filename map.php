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

    /* Background map */
    #map {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    /* Overlay circle map */
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

    /* UI layer to ensure button stays above maps */
    #ui-layer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      pointer-events: none; /* allow clicks to pass through unless overridden */
    }

    #logoutBtn {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      background-image: url("Visuals/visual_menu_btn.png");
      background-size: cover;         /* Cover the whole div */
      background-position: center;    /* Center the image */
      background-repeat: no-repeat;
      z-index: 10000;
      pointer-events: auto; /* make the button clickable */
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      cursor: pointer
    }
  </style>
</head>
<body>
  <!-- Background map -->
  <div id="map"></div>

  <!-- Overlay traffic map in circular container -->
  <div class="circle-wrapper">
    <div id="traffic-map"></div>
  </div>

  <!-- UI Layer on top of all maps -->
  <div id="ui-layer">
    <div id="logoutBtn"></div>
  </div>

  <!-- JS logic for menu or interactivity -->
  <script src = "logout.js"></script>

  <script>
    let map, trafficMap;
    let syncing = false;

    function initMap() {
      const centerCoords = { lat: 14.8370, lng: 120.8856 };

      // Background map
      map = new google.maps.Map(document.getElementById("map"), {
        center: centerCoords,
        zoom: 12,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
      });

      new google.maps.Marker({
        position: centerCoords,
        map: map,
        title: "Plain Map",
      });

      // Circular traffic map
      trafficMap = new google.maps.Map(document.getElementById("traffic-map"), {
        center: centerCoords,
        zoom: 12,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
      });

      const trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(trafficMap);

      // Sync movement between maps
      syncMaps(map, trafficMap);
      syncMaps(trafficMap, map);
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

  <!-- Load Google Maps API -->
  <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp1VnY9DWXcVL1xfkiN7PYzzRh0zgQETU&callback=initMap" 
    async 
    defer>
  </script>
</body>
</html>
