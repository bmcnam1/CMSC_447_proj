<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
	  if(!canAccessGoogleVisualization()){
		 google.charts.load('current', {'packages':['corechart']});
		 google.charts.setOnLoadCallback(drawChart); 
	  }
      
	function canAccessGoogleVisualization() 
{
    if ((typeof google === 'undefined') || (typeof google.visualization === 'undefined')) {
       return false;
    }
    else{
     return true;
   }
}
	//get initial data
    function drawChart() {
		var url = window.location.href;
		var params = url.substring(url.indexOf("?"));
		var jsonData = $.ajax({
          url: "data.php",
		  contentType: "application/json",
         
          async: false,
		  success: function(data){
            drawPieChart(data);
            drawLineGraph(data);
		  }
        });
	}		

	function drawLineGraph(graph_data){
		graph_data = graph_data.replace("In data.php", "");
		graph_data = graph_data.substring(0, graph_data.indexOf(']')+1);
		var JsonArray = JSON.parse(graph_data);
		var data = [];
		var types = []
		for(var i in JsonArray){
			var type = JsonArray[i]['crimeType'];
			if(types.indexOf(type) == -1){
				types.push(type);
			}

			
		}
		//make sure each date has every type
		for(var i in JsonArray){
			var type = JsonArray[i]['crimeType'];
			var dateStr = JsonArray[i]['crimeDateTime'];
			var day = dateStr.substring(0,dateStr.indexOf(" "));
			if(!data.hasOwnProperty(day)){
				data[day] = [];
				for(var typ in types){
					data[day][types[typ]] = 0;
				}
			}
			data[day][type]++;
		}

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

		var options = {'title':'line Chart of Baltimoere Crimes',
    					'width':1000,
    					'height':900};
    	var chart = new google.visualization.LineChart(document.getElementById("linechart"));
    	chart.draw(table, options);
	}
	//for intital chart setup
	function drawPieChart(graph_data){
		///Clean up the JSON string from Data.php
		graph_data = graph_data.replace("In data.php", "");
		graph_data = graph_data.substring(0, graph_data.indexOf(']')+1);
		var JsonArray = JSON.parse(graph_data);
		var counts = {};
		for(var i in JsonArray){
			var nam = JsonArray[i]['crimeType'];
			if(counts.hasOwnProperty(nam)){
				counts[nam] ++;
			}else{
				counts[nam] = 1;
			}
		}
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Crime type');
    	data.addColumn('number', 'count');
    	for(var prop in counts){
    		data.addRow([prop,counts[prop]]);
    	}
    	var options = {'title':'Pie Chart of Baltimoere Crimes',
    					'width':800,
    					'height':700};
    	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		//alert("drawing the chart");
    	chart.draw(data, options);

    }
	
	//redraw the chart with updated data - triggered by onClick() event
	function redraw(){
	// 	//Get the inner.HTML of the hidden 'div' and split on ','
	// 	var newData = document.getElementById('dataDiv').innerHTML.split(",");
	// 	//
	// 	for(i = 0; i < newData.length; i++){
	// 		//try to clean up data if null
	// 		if (typeof newData[i] == 'undefined'){
	// 			//alert("It was undefined"+newData[i]);
	// 			newData[i] = "";
	// 		}
	// 	}
	// 	//TODO: newData[2] or 'streetname' is always undefined -use nothing for now.
	// 	var jsonData = $.ajax({
 //          url: "Data.php",
 //          data: {district:newData[0], 
	// 	         neighborhood:newData[1],
	// 			 streetname:"" //newData[2]
	// 			},
	// 	  type: "POST",
 //          async: false
		  
 //        }).responseText;
	// 	//alert("new JsonData = "+jsonData);
	// 	graph_data = jsonData;
		
	// 	graph_data = graph_data.substring(0, graph_data.indexOf(']')+1);
		
	
	// 	 var JSONObject = JSON.parse(graph_data);
	// 	 console.log(JSONObject);
		 
	// 	    var array = JSONObject;
	// 		var counts = {};
	// 		for(var i in array){
	// 			var nam = array[i]['crimeType'];
	// 			if(counts.hasOwnProperty(nam)){
	// 				counts[nam] ++;
	// 			}else{
	// 				counts[nam] = 1;
	// 			}
	// 		}
	// 		data = new google.visualization.DataTable();
	// 		data.addColumn('string', 'Crime type');
 //        	data.addColumn('number', 'count');
 //        	for(var prop in counts){
 //        		data.addRow([prop,counts[prop]]);
 //        	}
	// 		options = {'title':'Pie Chart of Baltimoere Crimes',
 //        					'width':800,
 //        					'height':700};
        	
	// 		//alert("drawing the chart");
 //        	chart.draw(data, options);
		
	}
	  
	  
    </script>
  </head>
  <body>
	<div id="dataDiv" onclick='redraw();' hidden></div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div id="linechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>