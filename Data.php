<?php 
	error_reporting(E_ALL);
	/*
		this page will fetch all fields with the filters specified by
		district, neighborhood, streetName, crimeType, weapon
	*/
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'cmsc447');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'save_baltimore');

	$dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysql_error());

	$sql = "SELECT * FROM `Baltimore_Crime_Data` WHERE 1";
	if(array_key_exists("district", $_GET))
		$sql .= " AND `district` = \"" . $_GET['district'] . '"';
	if(array_key_exists("neighborhood", $_GET))
		$sql .= " AND `neighborhood` = \"" . $_GET['neighborhood'] . '"';
	if(array_key_exists("streetName", $_GET))
		$sql .= " AND `streetName` = \"" . $_GET['streetName'] . '"';
	if(array_key_exists("crimeType", $_GET))
		$sql .= " AND `crimeType` = \"" . $_GET['crimeType'] . '"';
	if(array_key_exists("weapon", $_GET))
		$sql .= " AND `weapon` = \"" . $_GET['weapon'] . '"';

	$results = mysqli_query($dbc, $sql);
	$data = array();
	while($row = mysqli_fetch_assoc($results)){
		$data[] = $row;
	}

 	$json = json_encode($data);
	echo($json)
?>
