<?php
	$servername = "localhost";
	$username = "opendocman";
	$password = "ideavate123";
	$dbname = "OpenDocMan";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
	$q = $_GET['q'];
	$sql = "SELECT * FROM odm_data where keyword LIKE '%$q%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$SendData = array();
	    while($row = $result->fetch_assoc()) {
	      $SendData[$row['id']] = $row["keyword"];
	    } 
		print_r(json_encode($SendData));

	} else {
	  echo json_encode(0);
	}
}

$conn->close();
?>
