<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      function drawChart(newData) {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
		
      }
    </script>
	<script>
	function getData(){
		alert("Data1 = ");
		
		var json = <?php echo $json;?>;
		var array = JSON.parse(json);
			
		var counts = {};
		for(var i in array){
			var nam = array[i]['crimeType'];
			if(counts.hasOwnProperty(nam)){
				counts[nam] ++;
			}else{
				counts[nam] = 1;
			}
		}
		var data1 = new google.visualization.DataTable();
		data1.addColumn('string', 'Crime type');
       	data1.addColumn('number', 'count');
		//drawChart(data1);
		
	}	
	</script>
	
  </head>
  <body>Is loaded
    <div id="piechart" onClick="getData()" style="width: 900px; height: 500px;"></div>
  </body>
</html>