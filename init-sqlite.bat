@echo off
REM Script to initialize SQLite database for TakeCare
REM This creates the care.db file with the schema and default admin user

echo ========================================
echo TakeCare - SQLite Database Setup
echo ========================================
echo.

cd /d "%~dp0"

REM Check if SQLite is available
where sqlite3 >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo SQLite3 not found in PATH. Using PHP to create database...
    echo.
    php -r "try { $pdo = new PDO('sqlite:db/care.db'); $schema = file_get_contents('db/init.sqlite.sql'); $pdo->exec($schema); echo 'Database created successfully!'; } catch (Exception $e) { echo 'Error: ' . $e->getMessage(); exit(1); }"
    goto :end
)

REM Delete existing database if it exists
if exist "db\care.db" (
    echo Removing existing database...
    del /F "db\care.db"
)

echo Creating new SQLite database...
sqlite3 db\care.db ".read db\init.sqlite.sql"

if %ERRORLEVEL% EQU 0 (
    echo.
    echo [SUCCESS] Database created: db\care.db
    echo.
    echo Default admin credentials:
    echo   Email: admin@gardekids.com
    echo   Password: admin123
    echo.
    echo [IMPORTANT] Change the admin password before deployment!
    echo.
) else (
    echo.
    echo [ERROR] Failed to create database
    echo.
    exit /b 1
)

:end
echo ========================================
pause
