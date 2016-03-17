<!DOCTYPE html>
<html>
<!--File: Map.php
	Google Map API in a Div
	Lat, Long is pre-set for baltimore city
 -->
  <head>
  	<link href="Map.css" rel="stylesheet" type="text/css">
  </head>
      <body>
          <div id=map>
          </div>
        <script>
          function initMap() {
            var mapDiv = document.getElementById('map');
            var map = new google.maps.Map(mapDiv, {
              center: {lat: 39.2833, lng: -76.6167},
              zoom: 13
            });
          }
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
      </body>
</html>