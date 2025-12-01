<?php
// Quick test to create a test user
require_once __DIR__ . '/config/db.php';

echo "<h1>Test User Creation</h1>";

$testName = "Test User";
$testEmail = "test@takecare.com";
$testPassword = "test123";

try {
    // Check if user exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$testEmail]);
    
    if ($stmt->fetch()) {
        echo "❌ Test user already exists. Deleting...<br>";
        $stmt = $pdo->prepare('DELETE FROM users WHERE email = ?');
        $stmt->execute([$testEmail]);
        echo "✅ Deleted existing test user<br>";
    }
    
    // Create test user
    $hash = password_hash($testPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)');
    $stmt->execute([$testName, $testEmail, $hash, 0]);
    
    echo "✅ Test user created successfully!<br>";
    echo "<p><strong>Login credentials:</strong></p>";
    echo "<ul>";
    echo "<li>Email: <strong>$testEmail</strong></li>";
    echo "<li>Password: <strong>$testPassword</strong></li>";
    echo "</ul>";
    
    // Verify password
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$testEmail]);
    $user = $stmt->fetch();
    
    if (password_verify($testPassword, $user['password'])) {
        echo "✅ Password verification successful!<br>";
    } else {
        echo "❌ Password verification failed!<br>";
    }
    
    echo "<hr>";
    echo "<p><a href='signin.php'>Try logging in with test@takecare.com / test123</a></p>";
    echo "<p><a href='test_db.php'>Run Database Tests</a></p>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>

<style>
body {
    font-family: 'Arial', sans-serif;
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    background: #f5f5f5;
}
h1 {
    color: #2C3E50;
}
</style>
