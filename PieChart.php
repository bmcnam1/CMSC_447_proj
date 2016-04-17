<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
	  if(!canAccessGoogleVisualization()){
		 google.charts.load('current', {'packages':['corechart']});
		 google.charts.setOnLoadCallback(drawChart); 
	  }
      
	var graph_data;  
	var data;
	var chart;
	var options;
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
		  
		var jsonData = $.ajax({
          url: "Data.php",
		  contentType: "application/json",
         
          async: false,
		  success: function(data){
            
                graph_data = data;
                computeChart(graph_data);
		    
		  }
        });
	}		
	//for intital chart setup
	function computeChart(graph_data){
		alert(graph_data);
		///Clean up the JSON string from Data.php
		graph_data = graph_data.replace("In data.php", "");
		graph_data = graph_data.substring(0, graph_data.indexOf(']')+1);
		
	
		 var JSONObject = JSON.parse(graph_data);
		 console.log(JSONObject);
		 
		    var array = JSONObject;
			var counts = {};
			for(var i in array){
				var nam = array[i]['crimeType'];
				if(counts.hasOwnProperty(nam)){
					counts[nam] ++;
				}else{
					counts[nam] = 1;
				}
			}
			data = new google.visualization.DataTable();
			data.addColumn('string', 'Crime type');
        	data.addColumn('number', 'count');
        	for(var prop in counts){
        		data.addRow([prop,counts[prop]]);
        	}
        	options = {'title':'Pie Chart of Baltimoere Crimes',
        					'width':800,
        					'height':700};
        	chart = new google.visualization.PieChart(document.getElementById('piechart'));
			//alert("drawing the chart");
        	chart.draw(data, options);

    }
	
	//redraw the chart with updated data - triggered by onClick() event
	function redraw(){
		//Get the inner.HTML of the hidden 'div' and split on ','
		var newData = document.getElementById('dataDiv').innerHTML.split(",");
		//
		for(i = 0; i < newData.length; i++){
			//try to clean up data if null
			if (typeof newData[i] == 'undefined'){
				//alert("It was undefined"+newData[i]);
				newData[i] = "";
			}
		}
		//TODO: newData[2] or 'streetname' is always undefined -use nothing for now.
		var jsonData = $.ajax({
          url: "Data.php",
          data: {district:newData[0], 
		         neighborhood:newData[1],
				 streetname:"" //newData[2]
				},
		  type: "POST",
          async: false
		  
        }).responseText;
		//alert("new JsonData = "+jsonData);
		graph_data = jsonData;
		
		graph_data = graph_data.substring(0, graph_data.indexOf(']')+1);
		
	
		 var JSONObject = JSON.parse(graph_data);
		 console.log(JSONObject);
		 
		    var array = JSONObject;
			var counts = {};
			for(var i in array){
				var nam = array[i]['crimeType'];
				if(counts.hasOwnProperty(nam)){
					counts[nam] ++;
				}else{
					counts[nam] = 1;
				}
			}
			data = new google.visualization.DataTable();
			data.addColumn('string', 'Crime type');
        	data.addColumn('number', 'count');
        	for(var prop in counts){
        		data.addRow([prop,counts[prop]]);
        	}
			options = {'title':'Pie Chart of Baltimoere Crimes',
        					'width':800,
        					'height':700};
        	
			//alert("drawing the chart");
        	chart.draw(data, options);
		
	}
	  
	  
    </script>
  </head>
  <body>
	<div id="dataDiv" onclick='redraw();' hidden></div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>