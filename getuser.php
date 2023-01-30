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
	$q = intval($_GET['q']);
	$sql = "SELECT * FROM category where pr_id=$q";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$SendData = array();
	    while($row = $result->fetch_assoc()) {
	      $SendData[$row['id']] = $row["cat_name"];
	    } 
		print_r(json_encode($SendData));

	} else {
		print_r(json_encode(array()));
	}
}

$conn->close();
?>

