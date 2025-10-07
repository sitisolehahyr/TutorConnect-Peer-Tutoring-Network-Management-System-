<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json([
        'success' => false,
        'message' => 'Invalid request method. Use POST.',
    ], 405);
}

$requiredFields = ['student_id', 'tutor_id', 'subject_id', 'date', 'time'];
$payload = [];

foreach ($requiredFields as $field) {
    $value = trim((string)($_POST[$field] ?? ''));
    if ($value === '') {
        respond_json([
            'success' => false,
            'message' => sprintf('Missing required field: %s', $field),
        ], 422);
    }
    $payload[$field] = $value;
}

$payload['message'] = trim((string)($_POST['message'] ?? ''));

try {
    $connection = get_database_connection();

    $statement = $connection->prepare(
        'INSERT INTO appointments (student_id, tutor_id, subject_id, date, time, additional_notes) VALUES (?, ?, ?, ?, ?, ?)'
    );

    if (! $statement) {
        throw new RuntimeException('Failed to prepare statement: ' . $connection->error);
    }

    $statement->bind_param(
        'ssssss',
        $payload['student_id'],
        $payload['tutor_id'],
        $payload['subject_id'],
        $payload['date'],
        $payload['time'],
        $payload['message']
    );

    if (! $statement->execute()) {
        throw new RuntimeException('Could not save appointment: ' . $statement->error);
    }

    respond_json([
        'success' => true,
        'message' => 'Appointment created successfully.',
        'appointment_id' => $connection->insert_id,
    ]);
} catch (Throwable $exception) {
    respond_json([
        'success' => false,
        'message' => $exception->getMessage(),
    ], 500);
}
