<!DOCTYPE html>
<html>
<!--File: Map.php
	Google Map API in a Div
	Lat, Long is pre-set for baltimore city
    
    
    A Heat map that displays color(heat) on lat,long points 
    has now been added
    Also contains a JQuery SLider bar for showing points on time intervals
    -(Slider just appears, and does nothing so far - more to come ..)
    
    -See JS section at bottom
	
    Currently querying the database from here as well...
 -->
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <head>
  	<link href="Map.css" rel="stylesheet" type="text/css">
  </head>
      <body>
          <div id=map style="padding:0; margin:0;"> </div>
          <div id="slider-range" style="height:20px; width:1000px; background:#000000"></div>
          <p id="dataDiv" hidden></p>
      </body>
         
    <script>
	  //JavaScript for the google heat map and JQuery slider bar	
	  var map, heatmap;

      function initMap() {
        $.ajax({
          url: "Data.php",
          contentType: "application/json",
          async: false,
          success: function(data){
            map = new google.maps.Map(document.getElementById('map'), {
              zoom: 13,
              center: {lat: 39.2833, lng: -76.6167},  //batimore coordinates
              mapTypeId: google.maps.MapTypeId.SATELLITE  //satelite view is default
            });
            var json = document.getElementById("dataDiv");
            json.innerHTML = data;
            
            heatmap = new google.maps.visualization.HeatmapLayer({
              data: getPoints(), //call getPoints() to get Lat,Longs
              map: map   //display on defined map
            });
          }
        });

      }

      function update(){
        heatmap.setData(getPoints());

      }
      function getPoints() {
		  //return an array of Point objs                     new google.maps.LatLng($latitudes[$i], $longitudes[$i]),
        var json = document.getElementById("dataDiv").innerHTML;
        var data = JSON.parse(json);
        var points = [];
        for(var i in data){
          var lat = data[i]['latitude'];
          var lon = data[i]['longitude'];
          points.push(new google.maps.LatLng(lat, lon));
        }
        return points;
      }
	  //create a slider bar with controlable range
	  $(function() {
      	$( "#slider-range" ).slider({
      		orientation: "horizontal",
      		range: true,
     	    values: [ 17, 67 ],
      		slide: function( event, ui ) {
        		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      		}
    	});
    	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      	" - $" + $( "#slider-range" ).slider( "values", 1 ) );
  	});
	//-----------------------------------------------------------------
			
			
        </script>
        
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9E6isql4BUI_q7EhH3YEPTogzKxNl0ls&libraries=visualization&callback=initMap">
    </script>
      
</html>