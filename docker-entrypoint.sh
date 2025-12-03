#!/bin/bash
set -e

echo "🚀 TakeCare - Starting automatic deployment..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" --skip-ssl --silent 2>/dev/null; do
    sleep 2
done
echo "✅ MySQL is ready!"

# Check if database tables exist, if not create them
echo "📊 Checking database setup..."
TABLES_EXIST=$(mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" -e "SHOW TABLES LIKE 'users';" 2>/dev/null | grep -c "users" || echo "0")

if [ "$TABLES_EXIST" = "0" ]; then
    echo "🔧 Creating database tables..."
    mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" <<EOF
-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_name VARCHAR(100),
    content TEXT,
    user_id INT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    ai_sentiment VARCHAR(50) NULL,
    ai_score DECIMAL(3,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create gallery table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF
    echo "✅ Database tables created!"
fi

# Check if admin user exists, if not create one
echo "👤 Checking admin user..."
ADMIN_EXISTS=$(mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" -e "SELECT COUNT(*) FROM users WHERE is_admin=1;" -s -N 2>/dev/null || echo "0")

if [ "$ADMIN_EXISTS" = "0" ]; then
    echo "🔐 Creating admin user..."
    
    # Generate password hash using PHP
    ADMIN_PASS_HASH=$(php -r "echo password_hash('${ADMIN_PASSWORD:-admin123}', PASSWORD_BCRYPT);")
    
    mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" <<EOF
INSERT INTO users (name, email, password, is_admin)
VALUES ('${ADMIN_NAME:-Admin}', '${ADMIN_EMAIL:-admin@takecare.com}', '$ADMIN_PASS_HASH', 1)
ON DUPLICATE KEY UPDATE name=name;
EOF
    echo "✅ Admin user created!"
    echo "   Email: ${ADMIN_EMAIL:-admin@takecare.com}"
    echo "   Password: ${ADMIN_PASSWORD:-admin123}"
fi

# Add sample testimonials if none exist
TESTIMONIALS_EXIST=$(mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" -e "SELECT COUNT(*) FROM testimonials;" -s -N 2>/dev/null || echo "0")

if [ "$TESTIMONIALS_EXIST" = "0" ]; then
    echo "📝 Adding sample testimonials..."
    mysql --skip-ssl -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" <<EOF
INSERT INTO testimonials (parent_name, content, status, ai_sentiment, ai_score) VALUES
('Sarah Johnson', 'TakeCare has been amazing for our family! The staff is caring and professional, and my daughter loves going there every day.', 'approved', 'positive', 0.95),
('Michael Brown', 'We are so grateful for the excellent care our son receives. The educational activities are wonderful and he has learned so much.', 'approved', 'positive', 0.92),
('Emma Davis', 'Highly recommend TakeCare! The environment is safe, clean, and stimulating for children. Our kids are always happy here.', 'approved', 'positive', 0.88);
EOF
    echo "✅ Sample testimonials added!"
fi

# Set correct permissions
echo "📁 Setting file permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 777 /var/www/html/uploads
chmod -R 777 /var/www/html/logs 2>/dev/null || true

echo ""
echo "🎉 =================================="
echo "   TakeCare is ready!"
echo "==================================="
echo ""
echo "🌐 Website: http://localhost:${WEB_PORT:-8080}"
echo "📧 Admin Email: ${ADMIN_EMAIL:-admin@takecare.com}"
echo "🔑 Admin Password: ${ADMIN_PASSWORD:-admin123}"
echo ""

# Execute the main command (Apache)
exec "$@"
