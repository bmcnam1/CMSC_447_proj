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
 
 
 <?php
 
    ini_set('memory_limit', '-1'); //**use this if SQL queries are too big for default memory
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'bmcnam1');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'cmsc_447');
	
	$TABLE_NAME = "baltimore_crime_data";
	//connect to the database 
 	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
	
	//query string - **only fetch the first 400 rows
	$query = "SELECT * FROM $TABLE_NAME limit 400";
	//exceute query
	$results = $sql->query($query);

	//$data = array();
	
	$latitudes = array(); //use these arrays for Google heat map api
	$longitudes = array(); 
	
	while($row = mysqli_fetch_assoc($results)){ //loop through queryed items
		//$data[] = $row;
		$latitudes[$counter] = $row['latitude'];    //store latitudes 
		$longitudes[$counter] = $row['longitude'];  //store longitues
		
		
	}
	
	//$json = json_encode($data);
	
 ?>
 
  <head>
  	<link href="Map.css" rel="stylesheet" type="text/css">
  </head>
      <body>
          <div id=map style="padding:0; margin:0;"> </div>
          <div id="slider-range" style="height:20px; width:1000px; background:#000000"></div>
      </body>
         
    <script>
	  //JavaScript for the google heat map and JQuery slider bar	
	  var map, heatmap;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 39.2833, lng: -76.6167},  //batimore coordinates
          mapTypeId: google.maps.MapTypeId.SATELLITE  //satelite view is default
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(), //call getPoints() to get Lat,Longs
          map: map			 //display on defined map
        });
      }
      function getPoints() {
		  //return an array of Point objs 
		  return [
		  <?php
		  	//only testing the first 400 rows of the DB
  			for($i=0; $i<399; $i++){
				echo("new google.maps.LatLng($latitudes[$i], $longitudes[$i]),");	
			}
			echo("new google.maps.LatLng($latitudes[399], $longitudes[399]),");
		  ?>
		];
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