<?php
//SQL Injection!
$connection = new mysqli('localhost', 'admin', 'aIqFYYGV32fK','websitedata') or die("Can't connect to server. Please check credentials and try again");
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: " . $connection->connect_error;
	die();
}
echo "<br>" . $_GET['username'];
//SQL Injection: 1' OR 1=1 UNION ALL SELECT * FROM users WHERE '1'='1
$sql = $connection->query("SELECT * FROM users WHERE username = '". $_GET['username'] . "'");
//printf("Error message: %s\n", $connection->error);
$fullarray = $sql->fetch_all(MYSQLI_ASSOC);
echo json_encode($fullarray);
?>