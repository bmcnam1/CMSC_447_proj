<?php
/*
	FilterFunctions.php:
    This file contains useful functions for generating the filters.
*/

    // This function gets the filter options from the db and generates
    // the html to display the filters
    function genFilters($filterName, $conn){
    	$tableName = "Baltimore_Crime_Data";
    	$query = "SELECT DISTINCT ".$filterName." FROM ".$tableName." ORDER BY ".$filterName." asc;";
    	$result = $conn->query($query);
    	//make the select and options
    	echo "<select name=".$filterName." id=".$filterName.">\n";
    	echo "<option value='blank' name'blank' id='blank'></option>\n"
    	while($row = $result->fetch_assoc()){
    		echo "<option value=".$result[$filterName]">".$result[$filterName]."</option>\n";
    	}
    }
    //this function will generate the slide bar for date input
    function genTimeFilter($conn){

    }
?> 