#!/bin/bash

# Script to update admin credentials in the database

# Configuration
DB_CONTAINER="takecare_db"
DB_NAME="care"
DB_USER="caredb"
DB_PASSWORD="@@12raquibi"

# Get admin credentials from environment or use defaults
ADMIN_NAME="${ADMIN_NAME:-Admin}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@takecare.com}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-admin123}"

echo "🔐 Updating admin credentials..."
echo "Name: $ADMIN_NAME"
echo "Email: $ADMIN_EMAIL"

# Generate password hash
HASHED_PASSWORD=$(php -r "echo password_hash('$ADMIN_PASSWORD', PASSWORD_BCRYPT);")

# Update or insert admin user
docker exec -i $DB_CONTAINER mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME <<EOF
INSERT INTO users (name, email, password, is_admin, created_at)
VALUES ('$ADMIN_NAME', '$ADMIN_EMAIL', '$HASHED_PASSWORD', 1, NOW())
ON DUPLICATE KEY UPDATE 
    name = '$ADMIN_NAME',
    password = '$HASHED_PASSWORD';
EOF

if [ $? -eq 0 ]; then
    echo "✅ Admin credentials updated successfully!"
    echo ""
    echo "📧 Email: $ADMIN_EMAIL"
    echo "🔑 Password: $ADMIN_PASSWORD"
else
    echo "❌ Failed to update admin credentials"
    exit 1
fi
