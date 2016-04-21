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

	
	$TABLE_NAME = "Baltimore_Crime_Data";
	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
	$query = "SELECT * FROM $TABLE_NAME WHERE 1";
	
	if(isset($_POST['neighborhood'])) {
		$neighborhood = dataToSql($_POST['neighborhood'],'neighborhood');
	}
	if(isset($_POST['district'])) {
		$district = dataToSql($_POST["district"],'district');
	}
	if(isset($_POST['streetname'])){
		$streetname = dataToSql($_POST["streetname"],'streetName');
	}
	if(isset($_POST['crimetype'])) {
		$crimetype = dataToSql($_POST["crimetype"],'crimeType');
	}
	if(isset($_POST['weapon'])){
		$weapon = dataToSql($_POST["weapon"],'weapon');
	}
	if(isset($_POST['streetname'])){
		$streetname = dataToSql($_POST["streetname"],'streetName');
	}


	if($district != ""){
		$query .= " AND `district`='$district";  
	}
	if($neighborhood != ""){
		$query .= " AND `neighborhood`='$neighborhood";  
	}
	if($streetname != ""){
		$query .= " AND `streetName`='$streetname";  
	}
	if($crimetype != ""){
		$query .= " AND `crimeType`='$crimetype";  
	}
	if($weapon != ""){
		$query .= " AND `weapon`='$weapon";  
	}
	$query .= " limit 1000";  //**optional** only query the first 1000 rows of table 
	$results = $sql->query($query);
	$data = array();
	$counter = 0;
	while($row = mysqli_fetch_assoc($results)){
		$data[] = $row;
		$counter++;	
	}
	
 	$json = json_encode($data);
	
	
	echo $json;
	
	function dataToSql($params, $field){
		if($params != ''){
			$list = explode(',', $params);
			$sql = $list[0] ."'";
			for($i = 1; $i < count($list); $i++){
				$sql .= "AND `$field` = '" . $list[$i] . "'";
			}
			return $sql;
		}
		return '';
	}
?>
