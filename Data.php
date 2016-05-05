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
	
	$startTime="";
	$endTime="";
	
	// assemble query
	$TABLE_NAME = "Baltimore_Crime_Data";
	$sql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("No connection");
	$query = "SELECT * FROM $TABLE_NAME WHERE 1";
	
	// add all selected values from filters tto the sql
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
	if(isset($_POST['startTime'])){
		$startTime = $_POST['startTime'];
	}
	if(isset($_POST['endTime'])){
		$endTime = $_POST['endTime'];
	}

	// piece together all search criteria into a single formated query
	if($district != ""){
		$query .= " AND (`district`='$district)";  
	}
	if($neighborhood != ""){
		$query .= " AND (`neighborhood`='$neighborhood)";  
	}
	if($streetname != ""){
		$query .= " AND (`streetName`='$streetname)";  
	}
	if($crimetype != ""){
		$query .= " AND (`crimeType`='$crimetype)";  
	}
	if($weapon != ""){
		$query .= " AND (`weapon`='$weapon)";  
	}
	if($startTime != ""){
		$query .= " AND `crimeDateTime` >= '$startTime' AND `crimeDateTime` < '$endTime'";
	}

	// add desired load and ordering parameters
	$query .= " order by crimeDateTime desc";
	$query .= " limit 15000";  //**optional** only query the first 15000 rows of table for speed

	// retrieve data
	$results = $sql->query($query);
	$data = array();
	$counter = 0;
	while($row = mysqli_fetch_assoc($results)){
		$data[] = $row;
		$counter++;	
	}
	
	// print out json data to be read by other files
 	$json = json_encode($data);
	echo $json;
	
	/*
		dataToSql - takes all selected choice for a filter type and creates a ORed collection of search parameters
		returns this string
	*/
	function dataToSql($params, $field){
		if($params != ''){
			$list = explode(',', $params);
			$sql = $list[0] ."'";
			for($i = 1; $i < count($list); $i++){
				$sql .= "or `$field` = '" . $list[$i] . "'";
			}
			return $sql;
		}
		return '';
	}
?>