<?php
/**
 * Database connection configuration.
 *
 * Establishes a PDO connection to the MySQL database.
 * If the connection fails, it displays a user-friendly error message and halts execution.
 */
// Database connection (PDO). Adjust these if your XAMPP MySQL setup differs.
$DB_HOST = 'localhost';
$DB_NAME = 'library_system';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('<div style="font-family:sans-serif;max-width:600px;margin:80px auto;padding:24px;
        background:#fff3f0;border:1px solid #8C3B2E;border-radius:8px;color:#1B2430;">
        <h2 style="color:#8C3B2E;margin-top:0;">Cannot reach the database</h2>
        <p>Make sure MySQL is running in XAMPP and that a database named
        <code>library_system</code> exists (run <code>database/schema.sql</code> first).</p>
        <p style="color:#666;font-size:14px;">Detail: ' . htmlspecialchars($e->getMessage()) . '</p>
        </div>');
}
