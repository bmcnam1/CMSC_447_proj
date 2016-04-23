<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
            	drawPieChart(data);
            	drawLineGraph(data);
		  	}
        });
	}

	//update changes charts to go off of the filtered data
    function update() {
		var jsonData = document.getElementById("dataDiv").innerHTML;
		drawLineGraph(jsonData);
		drawPieChart(jsonData);
	}		

	//drawLineGraph  calculates the number of each type during each month and puts a line per month
	function drawLineGraph(graph_data){
		var JsonArray = JSON.parse(graph_data);
		var data = [];
		var types = []

		//collect all crime types
		for(var i in JsonArray){
			var type = JsonArray[i]['crimeType'];
			if(types.indexOf(type) == -1){
				types.push(type);
			}
		}

		//count the number of crimes of each type per month
		for(var i in JsonArray){
			var type = JsonArray[i]['crimeType'];
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
			table.addColumn('number', types[i]);
		}

		for(var date in data){
			var row = [date];
			for (var count in data[date]){
				row.push(data[date][count]);
			}
			table.addRow(row);
		}

		//show graph
		var options = {'title':'line Chart of Baltimoere Crimes',
    					'width':1000,
    					'height':900};
    	var chart = new google.visualization.LineChart(document.getElementById("linechart"));
    	chart.draw(table, options);
	}

	// drawPieChart:  display a breakdown of crimes by type 
	function drawPieChart(graph_data){
		var JsonArray = JSON.parse(graph_data);
		var counts = {};

		//count the number of crimes per type
		for(var i in JsonArray){
			var nam = JsonArray[i]['crimeType'];
			if(counts.hasOwnProperty(nam)){
				counts[nam] ++;
			}else{
				counts[nam] = 1;
			}
		}

		//translate data to google table
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Crime type');
    	data.addColumn('number', 'count');
    	for(var prop in counts){
    		data.addRow([prop,counts[prop]]);
    	}

    	//display pie chart
    	var options = {'title':'Pie Chart of Baltimoere Crimes',
    					'width':800,
    					'height':700};
    	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		//alert("drawing the chart");
    	chart.draw(data, options);

    }	  
    </script>
  </head>
  <body>
	<div id="dataDiv" hidden></div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div id="linechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>