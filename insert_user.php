<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $student_id = $_POST['student_id'] ?? '';
    $tutor_id = $_POST['tutor_id'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $message = $_POST['message'] ?? '';

    // Prepare and execute SQL statement to insert data into your database
    $sql = "INSERT INTO appointments (student_id, tutor_id, subject_id, date, time, additional_notes) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiiiss', $student_id, $tutor_id, $subject_id, $date, $time, $message);

    try {
        if ($stmt->execute()) {
            // Successful insertion
            echo json_encode(['success' => true, 'message' => 'Appointment successfully booked']);
        } else {
            // Error executing the query
            echo json_encode(['success' => false, 'message' => 'Error booking appointment: ' . $stmt->error]);
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
    }

    // Close prepared statement
    $stmt->close();
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close database connection
$conn->close();
?>
