<?php
$connection = new mysqli('localhost', 'root', '','websitedata') or die("Can't connect to server. Please check credentials and try again");
    if ($connection->connect_errno) {
        echo "Failed to connect to MySQL: " . $connection->connect_error;
        die();
    }
?>