<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json([
        'success' => false,
        'message' => 'Invalid request method. Use POST.',
    ], 405);
}

$requiredFields = [
    'full_name',
    'username',
    'email',
    'phone',
    'address',
    'password',
];

$data = [];

foreach ($requiredFields as $field) {
    $value = trim((string)($_POST[$field] ?? ''));
    if ($value === '') {
        respond_json([
            'success' => false,
            'message' => sprintf('Missing required field: %s', $field),
        ], 422);
    }
    $data[$field] = $value;
}

$data['interests'] = trim((string)($_POST['interests'] ?? ''));
$data['student_id'] = strtoupper((string)($_POST['student_id'] ?? ''));

if ($data['student_id'] === '') {
    $data['student_id'] = 'STU' . str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
}

try {
    $connection = get_database_connection();

    $statement = $connection->prepare(
        'INSERT INTO STUDENT (STUDENT_ID, STUDENT_NAME, STUDENT_EMAIL, STUDENT_USERNAME, STUDENT_PASSWORD, STUDENT_PHONE, STUDENT_ADDRESS) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );

    if (! $statement) {
        throw new RuntimeException('Failed to prepare registration statement: ' . $connection->error);
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

    $statement->bind_param(
        'sssssss',
        $data['student_id'],
        $data['full_name'],
        $data['email'],
        $data['username'],
        $hashedPassword,
        preg_replace('/[^0-9+]/', '', $data['phone']),
        $data['address']
    );

    if (! $statement->execute()) {
        throw new RuntimeException('Failed to register student: ' . $statement->error);
    }

    respond_json([
        'success' => true,
        'message' => 'Account created successfully.',
        'student_id' => $data['student_id'],
    ]);
} catch (Throwable $exception) {
    respond_json([
        'success' => false,
        'message' => $exception->getMessage(),
    ], 500);
}
