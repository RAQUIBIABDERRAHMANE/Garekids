<?php
// Test database connection and signup/signin functionality
require_once __DIR__ . '/config/db.php';

echo "<h1>TakeCare Database Test</h1>";

// Test 1: Check connection
echo "<h2>Test 1: Database Connection</h2>";
if (isset($pdo)) {
    echo "✅ PDO connection successful!<br>";
    try {
        $stmt = $pdo->query("SELECT DATABASE()");
        $dbname = $stmt->fetchColumn();
        echo "✅ Connected to database: <strong>$dbname</strong><br>";
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ PDO connection failed<br>";
}

// Test 2: Check tables
echo "<h2>Test 2: Tables Check</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Tables found: " . implode(", ", $tables) . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 3: Check users table structure
echo "<h2>Test 3: Users Table Structure</h2>";
try {
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Columns: " . implode(", ", $columns) . "<br>";
    
    if (in_array('is_admin', $columns)) {
        echo "✅ is_admin column exists<br>";
    } else {
        echo "❌ is_admin column missing<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 4: Check admin user
echo "<h2>Test 4: Admin User Check</h2>";
try {
    $stmt = $pdo->prepare("SELECT id, name, email, is_admin FROM users WHERE email = ?");
    $stmt->execute(['admin@gardekids.com']);
    $admin = $stmt->fetch();
    if ($admin) {
        echo "✅ Admin user exists:<br>";
        echo "- ID: {$admin['id']}<br>";
        echo "- Name: {$admin['name']}<br>";
        echo "- Email: {$admin['email']}<br>";
        echo "- Is Admin: " . ($admin['is_admin'] ? 'Yes' : 'No') . "<br>";
    } else {
        echo "❌ Admin user not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 5: Test password verification
echo "<h2>Test 5: Password Verification Test</h2>";
try {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->execute(['admin@gardekids.com']);
    $user = $stmt->fetch();
    if ($user) {
        $testPassword = 'admin123';
        if (password_verify($testPassword, $user['password'])) {
            echo "✅ Password verification works! (admin123)<br>";
        } else {
            echo "❌ Password verification failed<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 6: Count users
echo "<h2>Test 6: User Count</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch();
    echo "✅ Total users in database: {$count['count']}<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>All tests completed!</strong></p>";
echo "<p><a href='signup.php'>Go to Sign Up</a> | <a href='signin.php'>Go to Sign In</a> | <a href='index.php'>Go to Home</a></p>";
?>

<style>
body {
    font-family: 'Arial', sans-serif;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: #f5f5f5;
}
h1 {
    color: #2C3E50;
    border-bottom: 3px solid #A8D8EA;
    padding-bottom: 10px;
}
h2 {
    color: #5DADE2;
    margin-top: 30px;
    background: linear-gradient(135deg, rgba(168, 216, 234, 0.1), rgba(181, 234, 215, 0.1));
    padding: 10px;
    border-left: 4px solid #A8D8EA;
}
</style>
