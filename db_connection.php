<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Change this to your MySQL server's address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "tutorconnect_db"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example data for the STUDENT table
$studentId = "AIU21102378";
$studentName = "John Doe";
$studentEmail = "john.doe@email.com";
$studentUsername = "johndoe123";
$studentPassword = "SecurePwd123";
$studentPhone = "60127769370";
$studentAddress = "123 Main Street, Cityville";

// Remove non-numeric characters from the phone number
$studentPhone = preg_replace('/[^0-9]/', '', $studentPhone);

// SQL query for inserting data into the STUDENT table
$sql = "INSERT INTO STUDENT (STUDENT_ID, STUDENT_NAME, STUDENT_EMAIL, STUDENT_USERNAME, STUDENT_PASSWORD, STUDENT_PHONE, STUDENT_ADDRESS) VALUES ('$studentId', '$studentName', '$studentEmail', '$studentUsername', '$studentPassword', '$studentPhone', '$studentAddress')";

// Perform the SQL query
if ($conn->query($sql) === TRUE) {
    echo "Data inserted into STUDENT table successfully<br>";
} else {
    echo "Error inserting data into STUDENT table: " . $conn->error . "<br>";
}

// ... (repeat similar blocks for other tables)

// Close the connection when you are done
$conn->close();
?>
