<!-- <!-- index.php:
	This file a titleBar, Filter Panel, and Tab Panel
    Eachtab is an html iframe to another webpage: current example of 
    this is being done with the Map.php file (see below)
-->
<?php 
ini_set('memory_limit', '-1'); //**use this if SQL queries are too big for default memory
  define('DB_USER', 'root');
  define('DB_PASSWORD', 'cmsc447');
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'save_baltimore');
/*
    options echo all filter options into a select tag
*/
function options($field){
    $sql = "SELECT DISTINCT `$field` FROM `Baltimore_Crime_Data`";
    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
     $results = $dbc->query($sql);
    while ($row = mysqli_fetch_assoc($results) ) {
        if($row[$field] == ""){
            $row[$field] = "None";
        }
        echo "<option value=\"" . $row[$field] . "\">". $row[$field] . "</option>";
    }
}
?>
<html>
    <link href="generalDesign.css" rel="stylesheet" type="text/css">
      
    <title>Indigo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 
  
  <!-- create tabPanel -->
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
  
  <!-- Header with title and company name-->
	<head >
        <div class="header" id="headDiv" align="left">
        
            <table id="headerTable" align="right">
                <tr >
                    <td>
                        <font color="#FFFFFF" size="+5" >Save Baltimore</font>
                    </td><td></td>
                    <td>
                        <font color="#8364EC" size="+4">Indigo</font>
                        <font color="#8364EC" size="+2"> Inc.</font>	
                    </td>
                </tr>
            </table>
        </div>
    </head>
    
 <body onload="sendUserInput()" bgcolor="#4d4d4d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <br><br><br><br><br>
 <table>
     <tr><td>
         <div id="tabs">
            <ul>
                <li><a href="#map">Map</a></li>
                <li><a href="#table">Table</a></li>
                <li><a href="#graph">Graph</a></li>
                 <!--Change or add more tabs here-->
              </ul>
               
                <div id="map" style="background-color:SlateGray;" >
                  <iframe id="mapFr" name="outputFrame" src="Map.php"  frameborder="0" width="1450" height="750" align="center"></iframe>
                </div>
                
                <div id="table" style="background-color:SlateGray;">
        			<iframe id="tableFr" name="outputFrame" src="Table.php"  frameborder="0" width="1450" height="750" align="center"></iframe>
        		</div>
                <div id="graph" style="background-color:SlateGray;">
        			<iframe id="graphFr" name="outputFrame" id="graphFrame" src="PieChart.php"  frameborder="0" width="1450" height="750" align="center"></iframe>
        		</div>
            </div>
         </td>
         
         <!--Filter Panel goes here-->
         <td>
           <div id="filterDiv" style="background-color:SlateGray; text-align:center; padding:15px; align="center"">
           <form action="" method="POST">

            <!-- user selects filter -->
            <font color="#FFFFFF">
                <h1> Filter </h1>
            _____________________________<br>
                     <p1>District</p1><br>
                     <!-- District -->
                     <select name="district" id = "district" onchange="sendUserInput();" multiple>
                         <?php options("district");?>
                    </select>
                     <br><br><br>
                     <p2>Nieghborhood</p2><br>
                     <select name="neighborhood" id = "neighborhood" onchange="sendUserInput();" multiple size="5">
                         <?php options("neighborhood");?>
                    </select>
                       <br><br><br>
                         <p3 id="streetname">Street Name</p3><br>
                         <select name="streetName" id = "streetName" onchange="sendUserInput();" multiple size="5">
                         <?php options("streetName");?>
                    </select><br>
            			______________________________
            		   <br><br><br>                      
            <!-- user selects crime type  -->
            
                    <p3>Crime Type</p3><br>
                    <select name="crimeType" id = "crimeType" onchange="sendUserInput();" multiple size="5">
                         <?php options("crimeType");?>
                    </select>
                       <br><br><br>
             	    <p3 id="groupNumber">Weapon </p3><br>
                    <select name="weapon" id = "weapon" onchange="sendUserInput();" multiple size="5">
                         <?php options("weapon");?>
                    </select>
                <br><br><br><br><br>
            </font>
            </form>
    		</div>
         </td>
     </tr>
     
 </table>
 <input onChange="sendUserInput()" style="width:100px; text-align:center" type="text" id="startDate">-
 <input onChange="sendUserInput()" style="width:100px; text-align:center" type="text" id="endDate">
 <div id="slider"></div>	
 
 <p1 id="dataStaging" hidden> </p1>
 <p1 id="timeStaging" hidden> </p1>
 
 </body>

<script>

	/**
	  *Ajax--SendUserInput()
	  *Is called on html-element stateChange (see form elements above)
	  *Sends data to Data.php
	  * then iserts filtered data into each iframe to update the views
	  */
    function sendUserInput(){
        //pulls out the selected filter options
    		var district = document.getElementById("district");
    		var neighborhood = document.getElementById("neighborhood");
    		var streetname = document.getElementById("streetname");
    		var startTime = document.getElementById("startDate").value;
    		var endTime = document.getElementById("endDate").value;
    		
    		districts = pullSelect('district');
    		neighborhoods = pullSelect('neighborhood');
    		streetnames = pullSelect('streetName');
        crimeTypes = pullSelect('crimeType');
        weapons = pullSelect('weapon');
		
        //sends data to backend to apply filters and put data into hidden div then, updates all frames
        $("#dataStaging").load("Data.php",{
            "district": districts,
            "neighborhood":neighborhoods,
            "streetname":streetnames,
            "crimetype":crimeTypes,
            "weapon":weapons,
      			"startTime": startTime,
      			"endTime": endTime
        }, UpdateAll);
	}
    /*
        pullSelect: get all selected values from given id and creates acomma seperated list
    */
    function pullSelect(id){
        var vals = '';
        $("#" + id + " :selected").each(function(){
            vals += $(this).val() + ',';
        });
        return vals.slice(0,-1);
    }
    //  UpdateAll:  takes the data from the staging div and passes it to all of the frames
    //              call updater for each tab to change views to requested filters
    function UpdateAll(){
        var data = document.getElementById("dataStaging").textContent;
        var ifrm = document.getElementById("graphFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        var chart;
        if (ifrm.document) chart = ifrm.document;
        //put data into frame and update view
        chart.getElementById("dataDiv").textContent = data;
        ifrm.window.update();
        
        var ifrm = document.getElementById("tableFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        //put data into frame and update view
        ifrm.window.table_data = data;
        ifrm.window.table();
        var ifrm = document.getElementById("mapFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        var map;
        if (ifrm.document) map = ifrm.document;
        //put data into frame and update view
        map.getElementById("dataDiv").textContent = data;
        ifrm.window.update();
    }
</script>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
<script>
var chart = AmCharts.makeChart("slider", {
    "type": "serial",
    "theme": "dark",
    "marginRight": 40,
    "marginLeft": 40,
    "autoMarginOffset": 20,
    "mouseWheelZoomEnabled":true,
    "dataDateFormat": "YYYY-MM-DD",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "ignoreAxisWidth":true
    }],
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "balloon":{
          "drop":true,
          "adjustBorderColor":false,
          "color":"#ffffff"
        },
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
    },
    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha":1,
        "cursorColor":"#258cbb",
        "limitToGraph":"g1",
        "valueLineAlpha":0.2
    },
    "valueScrollbar":{
      "oppositeAxis":false,
      "offset":50,
      "scrollbarHeight":10
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true
    },
    "export": {
        "enabled": true
    },
    "dataProvider": getTimeData()
 
});

chart.addListener("rendered", zoomChart);
chart.addListener("zoomed", handleZoom);
zoomChart();

function getTimeData(){
	$.ajax({
          url: "Data.php",
          contentType: "application/json",
          async: false,
		  success: function(data){
            
			var json = document.getElementById("timeStaging");
			json.innerHTML = data;
		  }
    });
	var json = document.getElementById("timeStaging").innerHTML;
	var data = JSON.parse(json);
	
	var prevDateTime = data[0]['crimeDateTime'].toString();
	var prevDate = prevDateTime.substring(0, 10);
		
	var dateTime = data[0]['crimeDateTime'].toString();
    var date = dateTime.substring(0, 10);
	var count = 0;
	var points =[];
	
	for(var i in data){
          dateTime = data[i]['crimeDateTime'].toString();
		  date = dateTime.substring(0, 10);
		  
		  if(date == prevDate){
			count++; 
			
		  }else{
			
			points.push({
				"date": prevDate,
				"value": count
			});
			
			prevDate = data[i]['crimeDateTime'].toString(); 
			prevDate = prevDate.substring(0, 10);
			count = 0;
		  }   
    }
	return points.reverse(); 
}

function zoomChart() {
    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
}

function handleZoom(event) {
  var startDate = event.startDate;
  var endDate = event.endDate;
  
  document.getElementById("startDate").value = AmCharts.formatDate(startDate, "YYYY-MM-DD");
  document.getElementById("endDate").value = AmCharts.formatDate(endDate, "YYYY-MM-DD");
  document.getElementById("startDate").onchange()
 
}

</script>
</html> -->