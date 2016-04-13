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
  <link rel="stylesheet" href="/resources/demos/style.css">
 
  <head>
  	<link href="Map.css" rel="stylesheet" type="text/css">
  </head>
		<body>
          <div id=map>
          </div>
		  
      </body>
         
    <script>
	  
	  //JavaScript for the google heat map and JQuery slider bar	
	  var map, heatmap;
	  var pointArray;
	 
	  var json = <?php echo $json;?>;
	  //alert("json.length = "+json.length);
      function initMap() {
			
			//alert("Calling initMap");
			//alert("Trying to create the map");
			pointArray =  new google.maps.MVCArray(getPoints());
			map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 13,
			  center: {lat: 39.2833, lng: -76.6167},  //batimore coordinates
			  mapTypeId: google.maps.MapTypeId.SATELLITE  //satelite view is default
			});

			heatmap = new google.maps.visualization.HeatmapLayer({
			  data: pointArray, //call getPoints() to get Lat,Longs
			  map: map		    //display on defined map
			});
      }
	  
	  function refreshMap(){
		var json = <?php echo $json;?>;  
		//alert("Calling refreshMap size = "+json.length);
		
		pointArray.clear();
		
		for(var i = 0; i < json.length; i++){
			  var obj = json[i];
			  pointArray.push(new google.maps.LatLng(obj.latitude, obj.longitude));
			 
		  }  
		
	  }
	  
	  
      function getPoints() {
		  //return an array of Point objs 
		  var points = [];
		  for(var i = 0; i < json.length; i++){
			  var obj = json[i];
			  points.push(new google.maps.LatLng(obj.latitude, obj.longitude));
			 
		  }
		  
		  return points;
	
		
      }
/*
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
			*/
			
        </script>
        
    <script async defer
	
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9E6isql4BUI_q7EhH3YEPTogzKxNl0ls&libraries=visualization&callback=initMap">

        
    </script>
    
   
    
      
</html>

 