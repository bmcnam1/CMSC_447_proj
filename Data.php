<?php 
	error_reporting(E_ALL);
	/*
		this page will fetch all fields with the filters specified by
		district, neighborhood, streetName, crimeType, weapon
	*/
	ini_set('memory_limit', '-1'); //**use this if SQL queries are too big for default memory
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'cmsc447');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'save_baltimore');
	
	$district="";
	$neighborhood="";
	$streetname="";
	$crimetype="";
	$weapon="";
	
	if(isset($_POST['neighborhood'])) {
		$neighborhood = ($_POST["neighborhood"]);
	}
	if(isset($_POST['district'])) {
		$district = ($_POST["district"]);
	}
	if(isset($_POST['streetname'])){
		$streetname = ($_POST["streetname"]);
	}
	if(isset($_POST['crimetype'])) {
		$crimetype = ($_POST["crimetype"]);
	}
	if(isset($_POST['weapon'])){
		$streetname = ($_POST["weapon"]);
	}
	
	$TABLE_NAME = "Baltimore_Crime_Data";
	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
	$query = "SELECT * FROM $TABLE_NAME WHERE 1";
	
	if($district != ""){
		$query .= " AND `district`='$district'";  
	}
	if($neighborhood != ""){
		$query .= " AND `neighborhood`='$neighborhood'";  
	}
	if($streetname != ""){
		$query .= " AND `streetName`='$streetname'";  
	}
	if($crimetype != ""){
		$query .= " AND `crimeType`='$crimetype'";  
	}
	if($weapon != ""){
		$query .= " AND `weapon`='$weapon'";  
	}
	$query .= " limit 1000";  //**optional** only query the first 1000 rows of table 
	
	$results = $sql->query($query);
	$data = array();
	$latitudes = array(); //use these arrays for Google heat map api
	$longitudes = array();
		
	$counter = 0;
	while($row = mysqli_fetch_assoc($results)){
		$data[] = $row;
		$counter++;	
	}
	
	
 	$json = json_encode($data);
	
	
	echo $json;
	
	include('Map.php');
	//include('PieChart.php');

?>
