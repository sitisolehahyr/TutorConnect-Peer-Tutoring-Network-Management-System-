<?php

declare(strict_types=1);

require_once __DIR__ . '/../../public/api/database.php';

try {
    $connection = get_database_connection();

    $statement = $connection->prepare(
        'INSERT INTO STUDENT (STUDENT_ID, STUDENT_NAME, STUDENT_EMAIL, STUDENT_USERNAME, STUDENT_PASSWORD, STUDENT_PHONE, STUDENT_ADDRESS) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );

    if (! $statement) {
        throw new RuntimeException('Failed to prepare statement: ' . $connection->error);
    }

    $hashedPassword = password_hash('SecurePwd123', PASSWORD_BCRYPT);

    $statement->bind_param(
        'sssssss',
        $id = 'AIU21102378',
        $name = 'John Doe',
        $email = 'john.doe@email.com',
        $username = 'johndoe123',
        $hashedPassword,
        $phone = '60127769370',
        $address = '123 Main Street, Cityville'
    );

    if (! $statement->execute()) {
        throw new RuntimeException('Unable to insert sample student: ' . $statement->error);
    }

    echo "Sample student inserted successfully\n";
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n");
    exit(1);
}
