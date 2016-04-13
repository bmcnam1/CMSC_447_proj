<!-- index.php:
	This file a titleBar, Filter Panel, and Tab Panel
    Eachtab is an html iframe to another webpage: current example of 
    this is being done with the Map.php file (see below
	
-->

<html>
<link href="generalDesign.css" rel="stylesheet" type="text/css">
 <link href="Data.php"> 
<title>Indigo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  
  <!-- create tabPanel -->
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
  
  <!-- Header with title and company name----------------------------->
	<head>
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
    <!--------------------------onload="sendUserInput()"--------------------------------------------->
    
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
               
                <div id="map" style="background-color:SlateGray; height: 780px; width:1500px; padding:0; margin:0;">
                  <iframe name="mapFrame" id="frame1" src="Map.php"  frameborder="0" width="1480" height="780" align="center"></iframe> 
                </div>
                
                <div id="table" style="background-color:SlateGray;">
        			iframe goes here1
        		</div>
                <div id="graph" style="background-color:SlateGray;">
        			<iframe name="outputFrame" id="graphFrame" src="PieChart.php"  frameborder="0" width="1450" height="750" align="center"></iframe>

        		</div>
            </div>
         </td>
         <!---------------------------------->
         
         <!--Filter Panel goes here-->
         <td>
           <div id="filterDiv" style="background-color:SlateGray; text-align:center; padding:15px; align="center"">
           <form>

            <!-- user selects filter -->
            <font color="#FFFFFF">
                <h1> Filter </h1><br><br>
            _____________________________<br>
                     <p1>District</p1><br>
                     <select name="district" id="district" onchange="sendUserInput();">
                            <option value=""></option>
                            <option value="NORTHEASTERN">NORTHEASTERN</option>
                            <option value="SOUTHERN">SOUTHERN</option>
                            <option value=3>XXXXX</option>
                            <option value=4>XXXXX</option>
                            <option value=5>XXXXX</option> 
                     </select>
                     <br><br><br>
                         <p3 id="neighborhood_p3">Neighborhood</p3><br>
                         <select name="Neighborhood" id="neighborhood" onchange="sendUserInput();" >
                       		<option value=""></option>
                            <option value="Hawkins Point">Hawkins Point</option>
                            <option value="Idlewood">Idlewood</option>
                            <option value="Hamilton Hills">Hamilton Hills</option>
                            <option value="Lake Walker">Lake Walker</option>
                            <option value="North Harford Road">North Harford Road</option>
                       </select>
                       <br><br><br>
                         <p3 id="streetname_p3">Street Name</p3><br>
                         <select id="streetname">
                         	<option value="" ></option>
                            <option value=10>Shooting</option>
                            <option value=9>Knife Attack</option>
                            <option value=8>Domestic</option>
                            <option value=7>Drug related</option>
                            <option value=6>Theft</option>
                       </select><br>
            			______________________________
            		   <br><br><br>                      
            <!-- user selects crime type  -->
            
                <p3 id="neighborhood">Crime Type</p3><br>
                         <select id="crimetype">
                       		<option value=""></option>
                            <option value=10>Shooting</option>
                            <option value=9>Knife Attack</option>
                            <option value=8>Domestic</option>
                            <option value=7>Drug related</option>
                            <option value=6>Theft</option>
                       </select>
                       <br><br><br>
             	<p3 id="groupNumber">Weapon </p3><br>
                         <select id="weapon">
                            <option id=""></option>
                            <option value="KNIFE">Knife</option>
                            <option value="HANDS">Hands</option>
                            <option value="OTHER">Other</option>
                            <option value=6>asdfjkl;</option>
                            <option value=5>asdfjkl;</option>
                         </select><br>
            _____________________________
            <!-- user selects advising date using jquery widget -->
            <br><p1>Neighborhood<br> <input type="text" name='date' id="datepicker" ></p1><br>
            
            <br>
            _____________________________
            <br>
            <!-- user selects time in drop down box -->
                
            <br><br><br><br><br>
            
            <button type="button" name="submit" id="formButton">Submit</button>
            </font>
            </form>
    		</div>
         </td>
     </tr>
     
 </table>
 <p1 id="dummyElement" hidden> </p1>
 
 
 </body>

<script >

	/**
	  *Ajax--SendUserInput()
	  *Is called on html-element stateChange (see form elements above)
	  *Sends data to Data.php
	  *
	  */
    function sendUserInput(){
		var district = document.getElementById("district");
		var neighborhood = document.getElementById("neighborhood");
		var streetname = document.getElementById("streetname");
		
		district_val = district.options[district.selectedIndex].value;
		neighborhood_val = neighborhood.options[neighborhood.selectedIndex].value;
		streetname_val = streetname.options[streetname.selectedIndex].value;
		
		
		$("#dummyElement").load('Data.php', {
			"district": district_val, 
			"neighborhood": neighborhood_val,
			"streetname": streetname_val
		} );
		
	
	}
	/*
	 *Call-back function from ajax 
	 *Excecute immidiatly after ajax completes
	 */
	$(document).ajaxComplete(function() {
		alert("complete");
		document.getElementById('graphFrame').contentWindow.document.getElementById('piechart').click();
	});

</script>

</html>