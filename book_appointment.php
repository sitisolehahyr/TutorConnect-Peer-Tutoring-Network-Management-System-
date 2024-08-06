<?php
include 'db.php'; // Include connection script

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $tutor_id = $_POST['tutor_id'];
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $additional_notes = $_POST['additional_notes'];

    $sql = "INSERT INTO STUDENT (student_id, tutor_id, subject_id, date, time, message)
    VALUES ('$student_id', '$tutor_id', '$subject_id', '$date', '$time', '$additional_notes')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'additional_notes' => 'Error: ' . $sql . "<br>" . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'additional_notes' => 'Invalid request']);
}

$conn->close();
?>