<?php
	function DBConn($user, $password, $host, $db);
	define('DB_USER', $user);
	define('DB_PASSWORD', $password);
	define('DB_HOST', $host);
	define('DB_NAME', $db);
	
	//connect to the database 
 	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
 	return $sql;
?>