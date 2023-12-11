<?php
$host = "localhost:3306";
$user = "root";
$pw = "root";

// Create connection
$conn = new mysqli($host, $user, $pw);

// Check connection
if($conn->connect_error){
	die("Connection failed: " + $conn->connect_error);
}
?>

