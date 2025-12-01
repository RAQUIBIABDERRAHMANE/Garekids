#!/bin/bash

# Script to generate password hash and update init.sql
# Usage: ./generate-admin-password.sh "your_password"

if [ -z "$1" ]; then
    echo "Usage: ./generate-admin-password.sh 'your_password'"
    exit 1
fi

PASSWORD="$1"
HASH=$(php -r "echo password_hash('$PASSWORD', PASSWORD_BCRYPT);")

echo "🔐 Generated password hash:"
echo "$HASH"
echo ""
echo "📝 Update db/init.sql with this hash"
echo ""

# Update init.sql automatically
sed -i "s|\$2y\$10\$[a-zA-Z0-9./]*|$HASH|g" db/init.sql

echo "✅ db/init.sql has been updated!"
echo "Password: $PASSWORD"
