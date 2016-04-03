<?php 
	error_reporting(E_ALL);
	require("query.php");
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

	$results = query($sql);
	$data = array();
	while($row = mysqli_fetch_assoc($results)){
		$data[] = $row;
	}

 	$json = json_encode($data);
	echo($json)
?>
