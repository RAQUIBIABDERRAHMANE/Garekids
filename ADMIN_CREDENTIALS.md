# How to Change Admin Credentials

## 🔐 Method 1: Using the generate-admin-password.sh script (Easiest)

```bash
# Make script executable
chmod +x generate-admin-password.sh

# Generate new password hash and update init.sql
./generate-admin-password.sh "your_secure_password"

# Then rebuild the database
docker-compose down -v
docker-compose up -d
```

## 🔐 Method 2: Manual password generation

### Step 1: Generate password hash
```bash
php -r "echo password_hash('your_password', PASSWORD_BCRYPT);"
```

Example output:
```
$2y$10$E9H8gXyPF5wpBITam197UeCbImHktd/qq3tKmVd6/6G1ie1tIxoAm
```

### Step 2: Update db/init.sql
Open `db/init.sql` and replace the hash in this line:
```sql
INSERT INTO users (name, email, password, is_admin) 
VALUES (
    'Your Name',                    -- Change this
    'your.email@example.com',       -- Change this
    '$2y$10$YOUR_NEW_HASH_HERE',    -- Paste your hash here
    1
);
```

### Step 3: Recreate the database
```bash
docker-compose down -v
docker-compose up -d
```

## 🔐 Method 3: Using docker-compose environment variables

### Step 1: Edit docker-compose.yml
```yaml
db:
  environment:
    ADMIN_NAME: "Your Name"
    ADMIN_EMAIL: "your.email@example.com"
    ADMIN_PASSWORD: "your_secure_password"
```

### Step 2: Update db/init.sql to use environment variables
The script will automatically hash the password from environment variables.

## 🔐 Method 4: Update via update-admin.sh script (For running containers)

```bash
# Make script executable
chmod +x update-admin.sh

# Update admin in running database
ADMIN_NAME="Your Name" \
ADMIN_EMAIL="your.email@example.com" \
ADMIN_PASSWORD="your_secure_password" \
./update-admin.sh
```

## 📝 Important Notes

- **Default credentials:** admin@takecare.com / admin123
- Always change default credentials before production deployment
- Use strong passwords (minimum 12 characters, mix of letters, numbers, symbols)
- Keep your credentials secure and never commit them to version control

## ⚠️ Security Best Practices

1. **Change immediately after first deployment**
2. **Use environment variables** for sensitive data
3. **Create .env file** (not committed to git)
4. **Use strong passwords** (use a password manager)
5. **Limit admin access** to trusted users only

## 🔄 To reset admin password later

If you forget your password:

```bash
# Generate new hash
NEW_HASH=$(php -r "echo password_hash('new_password', PASSWORD_BCRYPT);")

# Update in database
docker exec -i takecare_db mysql -u caredb -p'@@12raquibi' care <<EOF
UPDATE users SET password='$NEW_HASH' WHERE email='admin@takecare.com';
EOF
```

Or use the update-admin.sh script as shown in Method 4 above.
