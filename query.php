<?php

function query($query){
	
 	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
 	return $sql->query($query);
}
?>