<?php

class Common
{
  var $conn;
  var $debug;

  function Common($debug)
  {
    $this->debug = $debug;
    $rs = $this->connect("cmsc_447"); // db name really here
    return $rs;
  }

  // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

  function connect($db)// connect to MySQL
  {
	$test = new mysqli("localhost", "root", "bmcnam1", $db) or die("Could not connect to the DB");
    //$conn = @mysql_connect("localhost", "root", "bmcnam1") or die("Could not connect to MySQL"); 
    //$rs = @mysql_select_db($db, $conn) or die("Could not connect select $db database"); 
    $this->conn = $test;
  }

  // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

  function executeQuery($sql, $filename) // execute query
  {
    if($this->debug == true) {  }
    $rs = mysqli_query($sql, $this->conn) or die("Could not execute query '$sql' in $filename");
    return $rs;
  }

} // ends class, NEEDED!!

?>