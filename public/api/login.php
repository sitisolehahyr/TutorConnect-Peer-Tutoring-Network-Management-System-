<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json([
        'success' => false,
        'message' => 'Invalid request method. Use POST.',
    ], 405);
}

$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    respond_json([
        'success' => false,
        'message' => 'Username and password are required.',
    ], 422);
}

try {
    $connection = get_database_connection();
    $statement = $connection->prepare('SELECT STUDENT_PASSWORD FROM STUDENT WHERE STUDENT_USERNAME = ? LIMIT 1');

    if (! $statement) {
        throw new RuntimeException('Failed to prepare login query: ' . $connection->error);
    }

    $statement->bind_param('s', $username);

    if (! $statement->execute()) {
        throw new RuntimeException('Failed to execute login query: ' . $statement->error);
    }

    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        respond_json([
            'success' => false,
            'message' => 'Account not found.',
        ], 404);
    }

    $user = $result->fetch_assoc();

    if (! isset($user['STUDENT_PASSWORD']) || ! password_verify($password, $user['STUDENT_PASSWORD'])) {
        respond_json([
            'success' => false,
            'message' => 'Incorrect credentials.',
        ], 401);
    }

    respond_json([
        'success' => true,
        'message' => 'Login successful.',
    ]);
} catch (Throwable $exception) {
    respond_json([
        'success' => false,
        'message' => $exception->getMessage(),
    ], 500);
}
