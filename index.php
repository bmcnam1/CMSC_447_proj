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
        <div class="header" id="headDiv" align="left">
        
            <table id="headerTable" align="right">
                <tr >
                    <td>
                        <font color="#FFFFFF" size="+3" >Save Baltimore</font>
                    </td>
                    <!-- create filter menus for each type in data -->
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
                        <span class="hida">Weapon</span>    
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
				<td>
				 <dl class="dropdown">
				 <dt>
				 <button type="button" onclick="clearSelected()" id="clearbutton">Clear all</button>
				 </dt>
				 
				 </td>
				 </tr>
            </table>
        </div>
    </head>
    <!--get initial data on page load, by calling sendUserInput()- this will query without filters set-->
 <body onload="sendUserInput();" bgcolor="#4d4d4d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
               <!--Display Map, Graphs and tables in iFrames (within tabs) from included webpages -->
                <div id="map" style="background-color:SlateGray;">
                  <iframe id="mapFr" name="outputFrame" src="Map.php"  frameborder="0" width="1910" height="650" align="center"></iframe>
                </div>
                
                <div id="table" style="background-color:SlateGray;">
        			<iframe id="tableFr" name="outputFrame" src="Table.php"  frameborder="0" width="1910" height="620" align="center"></iframe>
        		</div>
                <div id="graph" style="background-color:SlateGray;">
        			<iframe id="graphFr" name="outputFrame" id="graphFrame" src="Graphs.php"  frameborder="0" width="1910" height="620" align="center"></iframe>
        		</div>
            </div>
         </td>
         
     </tr>
     
 </table>
<font color="white">
 Start Date <input onChange="sendUserInput()" style="width:100px; text-align:center" type="text" id="startDate" readonly> -
 <input onChange="sendUserInput()" style="width:100px; text-align:center" type="text" id="endDate" readonly> End Date
</font>
 <div id="slider"></div>	
 
 <p1 id="dataStaging" hidden> </p1>
 <p1 id="timeStaging" hidden> </p1>
 
 </body>

<script>
	//Button-Click event =resets all input
  function clearSelected(){		
  	  $('input:checkbox').removeAttr('checked');
  		chart.zoomOut(); //this will call sendUserInput()
      sendUserInput();
	}
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
    		var startTime = document.getElementById("startDate").value;
		    var endTime = document.getElementById("endDate").value;
    		
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
<!-- amcharts api include-->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
<script>
<!-- Create Histogram slider bar (using AMchart api) with a line graph and time slider -->
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
          "color":"#ffffff",
          "cornerRadius": 10,
          "pointerOrientation": "up"
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
        "balloonText": "<span style='font-size:13px;'>[[value]]</span>"
    }],
    "chartScrollbar": { 
        "oppositeAxis":false,
        "selectedBackgroundColor": "#888888",
        "color":"#AAAAAA",
	"updateOnReleaseOnly": true
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
//Displays updated line chart on load and when the user changes the slider bar
chart.addListener("rendered", zoomChart);
chart.addListener("zoomed", handleZoom);

/*getTimeData() - counts crime number per day
* get DB data from data.php and count number of ocurences crimes per day
*
*/
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
    //get data
	var json = document.getElementById("timeStaging").innerHTML;
	// convert to JSON 
	var data = JSON.parse(json);
	
	var prevDateTime = data[0]['crimeDateTime'].toString();
	var prevDate = prevDateTime.substring(0, 10);
		
	var dateTime = data[0]['crimeDateTime'].toString();
    var date = dateTime.substring(0, 10); //get just date rom DateTime 
	var count = 0;
	var points =[];
	//count crimes per day
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
    //return the array in reverse so data goes from oldest-newest
	return points.reverse(); 
}

/*
  zoomChart - zooms chart when user lets up on click of endpoints
*/
function zoomChart() {
    
  chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
  clearSelected(); //make sure the slider bar is cleared out on first render.
}

/*
  handleZoom - when the grsaph is zoomed in/out by user, this puts new dates to start and end
  this, in turn, triggers update of all views
*/
function handleZoom(event) {
  var startDate = event.startDate;
  var endDate = event.endDate;
  
  document.getElementById("startDate").value = AmCharts.formatDate(startDate, "YYYY-MM-DD");
  document.getElementById("endDate").value = AmCharts.formatDate(endDate, "YYYY-MM-DD");
  //force an onChange event to occur for the textBox
  document.getElementById("startDate").onchange();
 
}

</script>

<!-- this jquery deals with the drop down check boxes for the filters  -->
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
</script>
</html>