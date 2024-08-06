<?php
$servername = "localhost"; // Adjust if necessary
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "tutorconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>