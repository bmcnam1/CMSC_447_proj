<!-- index.php:
	This file a titleBar, Filter Panel, and Tab Panel
    Eachtab is an html iframe to another webpage: current example of 
    this is being done with the Map.php file (see below)
-->
<?php 
require("query.php");
ini_set('memory_limit', '-1'); //**use this if SQL queries are too big for default memory
define('DB_USER', 'root');
define('DB_PASSWORD', 'cmsc447');
define('DB_HOST', 'localhost');
define('DB_NAME', 'save_baltimore');
// function checks($field){
    
//     $sql = "SELECT DISTINCT `$field` FROM `baltimore_crime_data`";
//     $results = query($sql);
//     while ($row = mysqli_fetch_assoc($results) ) {
//         echo "<input type=\"checkbox\" value=\"" . $row[$field] . "\">" . $row[$field];
//     }
// }
function options($field){
    $sql = "SELECT DISTINCT `$field` FROM `baltimore_crime_data`";
    $results = query($sql);
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
  <script type="text/javascript" src="filters.js"></script>
  
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
                <h1> Filter </h1><br><br>
            _____________________________<br>
                     <p1>District</p1><br>
                     <!-- District -->
                     <select name="district" id = "district" onchange="sendUserInput();" multiple size="5">
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
                    <br>
            _____________________________
            <!-- user selects advising date using jquery widget -->
            
            
            <br>
            _____________________________
            <br>
            <!-- user selects time in drop down box -->
                
            <br><br><br><br><br>
            </font>
            </form>
    		</div>
         </td>
     </tr>
     
 </table>
 <p1 id="dataStaging" hidden> </p1>
 
 
 </body>

<script >
	/**
	  *Ajax--SendUserInput()
	  *Is called on html-element stateChange (see form elements above)
	  *Sends data to Data.php
	  *
	  */
	var isLoaded = false;
    function sendUserInput(){
		//alert("Got to send user input");
		var district = document.getElementById("district");
		var neighborhood = document.getElementById("neighborhood");
		var streetname = document.getElementById("streetname");
		
		
		districts = pullSelect('district');
		neighborhoods = pullSelect('neighborhood');
		streetnames = pullSelect('streetName');
        crimeTypes = pullSelect('crimeType');
        weapons = pullSelect('weapon');

        $("#dataStaging").load("Data.php",{
            "district": districts,
            "neighborhood":neighborhoods,
            "streetname":streetnames,
            "crimetype":crimeTypes,
            "weapon":weapons
        }, UpdateAll);
	}
    function pullSelect(id){
        var vals = '';
        $("#" + id + " :selected").each(function(){
            vals += $(this).val() + ',';
        });
        return vals.slice(0,-1);
    }

    function UpdateAll(){
         var data = document.getElementById("dataStaging").textContent;
         var ifrm = document.getElementById("graphFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        var chart;
        if (ifrm.document) chart = ifrm.document;
        chart.getElementById("dataDiv").textContent = data;
        ifrm.window.update();
        

        var ifrm = document.getElementById("tableFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        ifrm.window.table_data = data;
        ifrm.window.table();

        var ifrm = document.getElementById("mapFr");
         // reference to document in iframe
        var ifrm = ifrm.contentWindow || ifrm.contentDocument;
        var map;
        if (ifrm.document) map = ifrm.document;
        map.getElementById("dataDiv").textContent = data;
        ifrm.window.update();

    }
</script>
</html>