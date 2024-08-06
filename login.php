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
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate and sanitize user input
    $username = mysqli_real_escape_string($conn, $username);

    // Prepare SQL statement to fetch user from database
    $sql = "SELECT * FROM STUDENT WHERE STUDENT_USERNAME = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Check if user exists
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Verify password
                if (password_verify($password, $user['STUDENT_PASSWORD'])) {
                    // Password is correct, login successful
                    echo json_encode(['success' => true, 'message' => 'Login successful']);
                } else {
                    // Password is incorrect
                    echo json_encode(['success' => false, 'message' => 'Incorrect password']);
                }
            } else {
                // User not found
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
        } else {
            // Error executing the query
            echo json_encode(['success' => false, 'message' => 'Error executing the query']);
        }

        // Close prepared statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo json_encode(['success' => false, 'message' => 'Error preparing the statement']);
    }
}

// Close database connection
$conn->close();
?>
