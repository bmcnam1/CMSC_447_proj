<!-- index.php:
	This file a titleBar, Filter Panel, and Tab Panel
    Eachtab is an html iframe to another webpage: current example of 
    this is being done with the Map.php file (see below)
-->

<html>
<link href="generalDesign.css" rel="stylesheet" type="text/css">
  
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
  
  <!-- Header with title and company name-->
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
    
 <body bgcolor="#4d4d4d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
               
                <div id="map" style="background-color:SlateGray;">
                  <iframe name="outputFrame" src="Map.php"  frameborder="0" width="1450" height="750" align="center"></iframe>
                </div>
                
                <div id="table" style="background-color:SlateGray;">
        			iframe goes here1
        		</div>
                <div id="graph" style="background-color:SlateGray;">
        			<iframe name="outputFrame" src="PieChart.php"  frameborder="0" width="1450" height="750" align="center"></iframe>
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
                     <select name="district" id="district">
                            <option value="blank" name"blank" id="blank"></option>
                            <option value=1>XXXXX</option>
                            <option value=2>XXXXX</option>
                            <option value=3>XXXXX</option>
                            <option value=4>XXXXX</option>
                            <option value=5>XXXXX</option> 
                     </select>
                     <br><br><br>
                         <p3 id="neighborhood">Neighborhood</p3><br>
                         <select name="groupSize">
                       		<option value="blank" name"blank" id="blank"></option>
                            <option value=10>Shooting</option>
                            <option value=9>Knife Attack</option>
                            <option value=8>Domestic</option>
                            <option value=7>Drug related</option>
                            <option value=6>Theft</option>
                       </select>
                       <br><br><br>
                         <p3 id="streetname">Street Name</p3><br>
                         <select name="groupSize">
                         	<option value="blank" name"blank" id="blank"></option>
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
                         <select name="groupSize">
                       		<option value="blank" name"blank" id="blank"></option>
                            <option value=10>Shooting</option>
                            <option value=9>Knife Attack</option>
                            <option value=8>Domestic</option>
                            <option value=7>Drug related</option>
                            <option value=6>Theft</option>
                       </select>
                       <br><br><br>
             	<p3 id="groupNumber">Weapon </p3><br>
                         <select name="groupSize">
                            <option value="blank" name"blank" id="blank"></option>
                            <option value=9>asdfjkl;</option>
                            <option value=8>adsfjkl;</option>
                            <option value=7>adjfkl;</option>
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
 
 
 
 </body>


</html>