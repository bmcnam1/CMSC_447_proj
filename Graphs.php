<!-- <html> -->
  <head>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
    <script type="text/javascript">

    	var month = new Array();
		month[0] = "January";
		month[1] = "February";
		month[2] = "March";
		month[3] = "April";
		month[4] = "May";
		month[5] = "June";
		month[6] = "July";
		month[7] = "August";
		month[8] = "September";
		month[9] = "October";
		month[10] = "November";
		month[11] = "December";
	  if(!canAccessGoogleVisualization()){
		 google.charts.load('current', {'packages':['corechart']});
		 google.charts.setOnLoadCallback(init); 
	  }
      
	function canAccessGoogleVisualization() {
	    if ((typeof google === 'undefined') || (typeof google.visualization === 'undefined')) {
	       return false;
	    }
	    else{
	     return true;
	   }
	}
	/*
		init pull unfiltered data and put it on the charts 
	*/
	function init(){
		$.ajax({
			url: "Data.php",
			contentType: "application/json",
	        async: false,
			success: function(data){
            	drawLineGraph(data, 'district');
				drawPieChart(data, 'district');
				drawLineGraph(data, 'crimeType');
				drawPieChart(data, 'crimeType');
				drawLineGraph(data, 'weapon');
				drawPieChart(data, 'weapon');
		  	}
        });
	}
	//update changes charts to go off of the filtered data
    function update() {
		var data = document.getElementById("dataDiv").innerHTML;
		drawLineGraph(data, 'district');
		drawPieChart(data, 'district');
		drawLineGraph(data, 'crimeType');
		drawPieChart(data, 'crimeType');
		drawLineGraph(data, 'weapon');
		drawPieChart(data, 'weapon');
	}		
	//drawLineGraph  calculates the number of each type during each month and puts a line per month
	function drawLineGraph(graph_data, field){
		var JsonArray = JSON.parse(graph_data);
		var data = [];
		var types = []
		//collect all crime types
		for(var i in JsonArray){
			var type = JsonArray[i][field];
			if(types.indexOf(type) == -1){
				types.push(type);
			}
		}
		//count the number of crimes of each type per month
		for(var i in JsonArray){
			var type = JsonArray[i][field];
			var dateStr = JsonArray[i]['crimeDateTime'];
			var date = new Date(dateStr);
			var monthYear = month[date.getMonth()] + ' ' + dateStr.substring(0,4);
			if(!data.hasOwnProperty(monthYear)){
				data[monthYear] = [];
				for(var typ in types){
					data[monthYear][types[typ]] = 0;
				}
			}
			data[monthYear][type]++;
		}
		//put the collected info into a google table
		var table  = new google.visualization.DataTable();
		table.addColumn('string','Day');
		for(var i in types){
			var val = types[i];
			if(types[i] == null)
				val = "None";
			table.addColumn('number', val );
		}
		for(var date in data){
			var row = [date];
			for (var count in data[date]){
				row.push(data[date][count]);
			}
			table.addRow(row);
		}
		//show graph
		var options = {'width':1000,
    					'height':900};
    	var chart = new google.visualization.LineChart(document.getElementById(field + "linechart"));
    	chart.draw(table, options);
	}
	// drawPieChart:  display a breakdown of crimes by type 
	function drawPieChart(graph_data, field){
		var JsonArray = JSON.parse(graph_data);
		var counts = {};
		//count the number of crimes per type
		for(var i in JsonArray){
			var nam = JsonArray[i][field];
			if(counts.hasOwnProperty(nam)){
				counts[nam] ++;
			}else{
				counts[nam] = 1;
			}
		}
		//translate data to google table
		var data = new google.visualization.DataTable();
		data.addColumn('string', field);
    	data.addColumn('number', 'count');
    	for(var prop in counts){
    		var val = prop;
    		if(val === 'null')
    			val = "None";
    		data.addRow([val,counts[prop]]);
    	}
    	//display pie chart
    	var options = {'width':800,
    					'height':700};
    	var chart = new google.visualization.PieChart(document.getElementById(field + 'piechart'));
		//alert("drawing the chart");
    	chart.draw(data, options);
    }	  
    </script>
  </head>
  <body>

  	<div id="tabs">
	  	<ul>
			<li><a href="#districtpiechart">District Pie Chart</a></li>
			<li><a href="#districtlinechart">District line graph</a></li>
			<li><a href="#crimeTypepiechart">Crime Type Pie Chart</a></li>
			<li><a href="#crimeTypelinechart">Crime Type line graph</a></li>
			<li><a href="#weaponpiechart">Weapon Pie Chart</a></li>
			<li><a href="#weaponlinechart">Weapon line graph</a></li>
		</ul>	
		<div id="districtpiechart" style="width: 1000px; height: 1000px;"></div>
    	<div id="districtlinechart" style="width: 1000px; height: 1000px;"></div> 
    	<div id="crimeTypepiechart" style="width: 1000px; height: 1000px;"></div>
    	<div id="crimeTypelinechart" style="width: 1000px; height: 1000px;"></div>
		<div id="weaponpiechart" style="width: 1000px; height: 1000px;"></div>
    	<div id="weaponlinechart" style="width: 1000px; height: 1000px;"></div>
  	
  	</div>
	<div id="dataDiv" hidden></div>
    
  </body>
</html>
