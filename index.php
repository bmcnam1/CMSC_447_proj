<!-- index.php:
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
        $val = $row[$field];
        if($row[$field] == ""){
            $val = "None";
        }
        echo "<li><input onChange=\"sendUserInput()\" type=\"checkbox\" name =\"" . $field. "\" value=\"" . $row[$field] . "\">". $val . "</li>";
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
2        <div class="header" id="headDiv" align="left">
        
            <table id="headerTable" align="right">
                <tr >
                    <td>
                        <font color="#FFFFFF" size="+5" >Save Baltimore</font>
                    </td>
                    <td>
                      <dl class="dropdown"> 
  
                      <dt>
                      <a href="#" class="districtList">
                        <span class="hida">District</span>    
                        <p class="multiSel"></p>  
                      </a>
                      </dt>
                    
                      <dd>
                          <div class="mutliSelect">
                              <ul id="districtList">
                                <?php options("district"); ?>  

                              </ul>
                          </div>
                      </dd>
                 </td>
                 <td>
                      <dl class="dropdown"> 
  
                      <dt>
                      <a href="#" class="nerghborhoodList">
                        <span class="hida">Neighborhood</span>    
                        <p class="multiSel"></p>  
                      </a>
                      </dt>
                    
                      <dd>
                          <div class="mutliSelect">
                              <ul id="nerghborhoodList">
                                <?php options("neighborhood"); ?>  

                              </ul>
                          </div>
                      </dd>
                 </td><td>
                      <dl class="dropdown"> 
  
                      <dt>
                      <a href="#" class="streetNameLList">
                        <span class="hida">Street Name</span>    
                        <p class="multiSel"></p>  
                      </a>
                      </dt>
                    
                      <dd>
                          <div class="mutliSelect">
                              <ul id="streetNameLList">
                                <?php options("streetName"); ?>  

                              </ul>
                          </div>
                      </dd>
                 </td>
                 <td>
                      <dl class="dropdown"> 
  
                      <dt>
                      <a href="#" class="crimeList">
                        <span class="hida">Crime Type</span>    
                        <p class="multiSel"></p>  
                      </a>
                      </dt>
                    
                      <dd>
                          <div class="mutliSelect">
                              <ul id="crimeList">
                                <?php options("crimeType"); ?>  

                              </ul>
                          </div>
                      </dd>
                 </td>
                 <td>
                      <dl class="dropdown"> 
  
                      <dt>
                      <a href="#" class="weaponList">
                        <span class="hida">weapon</span>    
                        <p class="multiSel"></p>  
                      </a>
                      </dt>
                    
                      <dd>
                          <div class="mutliSelect">
                              <ul id="weaponList">
                                <?php options("weapon"); ?>  

                              </ul>
                          </div>
                      </dd>
                 </td>
            </table>
        </div>
    </head>
    
 <body onload="sendUserInput()" bgcolor="#4d4d4d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <br><br><br><br><br>
 <table id ="frames">
     <tr><td>
         <div id="tabs">
            <ul>
                <li><a href="#map">Map</a></li>
                <li><a href="#table">Table</a></li>
                <li><a href="#graph">Graph</a></li>
                 <!--Change or add more tabs here-->
              </ul>
               
                <div id="map" style="background-color:SlateGray;" >
                  <iframe id="mapFr" name="outputFrame" src="Map.php"  frameborder="0" width="1950" height="750" align="center"></iframe>
                </div>
                
                <div id="table" style="background-color:SlateGray;">
        			<iframe id="tableFr" name="outputFrame" src="Table.php"  frameborder="0" width="1950" height="750" align="center"></iframe>
        		</div>
                <div id="graph" style="background-color:SlateGray;">
        			<iframe id="graphFr" name="outputFrame" id="graphFrame" src="Graphs.php"  frameborder="0" width="1950" height="750" align="center"></iframe>
        		</div>
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
    		var district = document.getElementsByName("district");
    		var neighborhood = document.getElementsByName("neighborhood");
    		var streetName = document.getElementsByName("streetName");
        var crimeType = document.getElementsByName("crimeType");
        var weapon = document.getElementsByName("weapon");
    		var startTime = document.getElementsByName("startDate").value;
    		var endTime = document.getElementsByName("endDate").value;
    		
    		districts = pullSelect(district);
    		neighborhoods = pullSelect(neighborhood);
    		streetnames = pullSelect(streetName);
        crimeTypes = pullSelect(crimeType);
        weapons = pullSelect(weapon);
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
    function pullSelect(set){
        var vals = '';
        for(var i =0; i < set.length; i++){
            if(set[i].checked)
              vals += set[i].value + ',';
          }
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

<script type="text/javascript">
  
$(".dropdown dt a").on('click', function() {
  var cl = $(this).attr('class');
  $("#" + cl).slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$('.mutliSelect input[type="checkbox"]').on('click', function() {

  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = $(this).val() + ",";

  if ($(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel').append(html);
    $(".hida").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida");
    $('.dropdown dt a').append(ret);

  }
});
</script>
</html>