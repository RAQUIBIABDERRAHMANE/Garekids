<?php
// config/db.php
// Update the credentials as needed for your environment.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: 'care';
$user = getenv('DB_USER') ?: 'caredb';
$pass = getenv('DB_PASS') ?: '@@12raquibi';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Fallback: if there's a legacy mysqli config at db/db.php, include it so pages still load.
    if (file_exists(__DIR__ . '/../db/db.php')) {
        require_once __DIR__ . '/../db/db.php';
        // $conn (mysqli) will be available from that file.
    } else {
        // Show a friendly error for debugging; in production log this instead.
        die('Database connection failed: ' . $e->getMessage());
    }
}

?>