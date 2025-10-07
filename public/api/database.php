<?php

declare(strict_types=1);

/**
 * Returns a shared mysqli connection using environment variables when available.
 */
function get_database_connection(): mysqli
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $host = getenv('DB_HOST') ?: 'localhost';
    $user = getenv('DB_USERNAME') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    $database = getenv('DB_DATABASE') ?: 'tutorconnect_db';

    $connection = @new mysqli($host, $user, $password, $database);

    if ($connection->connect_errno) {
        http_response_code(500);
        throw new RuntimeException('Database connection failed: ' . $connection->connect_error);
    }

    $connection->set_charset('utf8mb4');

    return $connection;
}

/**
 * Sends a JSON response and terminates execution.
 */
function respond_json(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}
