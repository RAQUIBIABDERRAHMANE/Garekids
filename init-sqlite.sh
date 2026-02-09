#!/bin/bash
# Script to initialize SQLite database for TakeCare
# This creates the care.db file with the schema and default admin user

echo "========================================"
echo "TakeCare - SQLite Database Setup"
echo "========================================"
echo ""

cd "$(dirname "$0")"

# Check if SQLite is available
if ! command -v sqlite3 &> /dev/null; then
    echo "SQLite3 not found. Using PHP to create database..."
    echo ""
    php -r "
    try {
        \$pdo = new PDO('sqlite:db/care.db');
        \$schema = file_get_contents('db/init.sqlite.sql');
        \$pdo->exec(\$schema);
        echo 'Database created successfully!' . PHP_EOL;
    } catch (Exception \$e) {
        echo 'Error: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }"
    exit $?
fi

# Delete existing database if it exists
if [ -f "db/care.db" ]; then
    echo "Removing existing database..."
    rm -f "db/care.db"
fi

echo "Creating new SQLite database..."
sqlite3 db/care.db ".read db/init.sqlite.sql"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ [SUCCESS] Database created: db/care.db"
    echo ""
    echo "Default admin credentials:"
    echo "  Email: admin@gardekids.com"
    echo "  Password: admin123"
    echo ""
    echo "⚠️  [IMPORTANT] Change the admin password before deployment!"
    echo ""
else
    echo ""
    echo "❌ [ERROR] Failed to create database"
    echo ""
    exit 1
fi

echo "========================================"
