<?php
// config/db.php - SQLite Configuration
// Perfect for Vercel and serverless deployments - no external database needed!

// Database path - using /tmp on Vercel for writable storage
$db_path = getenv('DB_PATH') ?: __DIR__ . '/../db/care.db';

// For Vercel serverless: use /tmp directory (ephemeral but writable)
// Database will be re-initialized on each cold start from db/init.sqlite.sql
if (getenv('VERCEL')) {
    $db_path = '/tmp/care.db';
    $schema_path = __DIR__ . '/../db/init.sqlite.sql';
    
    // Initialize database if it doesn't exist
    if (!file_exists($db_path)) {
        try {
            $init_pdo = new PDO("sqlite:$db_path");
            $init_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if (file_exists($schema_path)) {
                $schema = file_get_contents($schema_path);
                $init_pdo->exec($schema);
            }
        } catch (PDOException $e) {
            error_log("SQLite initialization failed: " . $e->getMessage());
        }
    }
}

$dsn = "sqlite:$db_path";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, null, null, $options);
    
    // Enable foreign key constraints for SQLite
    $pdo->exec('PRAGMA foreign_keys = ON;');
    
    // Performance optimizations for SQLite
    $pdo->exec('PRAGMA journal_mode = WAL;');
    $pdo->exec('PRAGMA synchronous = NORMAL;');
    
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