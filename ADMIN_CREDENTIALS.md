# How to Change Admin Credentials

## 🔐 Method 1: Using the generate-admin-password.sh script (Easiest)

```bash
# Make script executable
chmod +x generate-admin-password.sh

# Generate new password hash and update init.sql
./generate-admin-password.sh "your_secure_password"

# Then update your database (local or cloud)
# Import the updated init.sql to your database
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

### Step 3: Update your database
Re-import the updated `init.sql` into your database.

## 📝 Important Notes

- **Default credentials:** admin@gardekids.com / admin123
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

# Update in database (adjust connection details)
mysql -h your_db_host -u your_user -p your_database <<EOF
UPDATE users SET password='$NEW_HASH' WHERE email='admin@gardekids.com';
EOF
```

Or use your database management tool (phpMyAdmin, PlanetScale Console, etc.) to run:
```sql
UPDATE users SET password='$2y$10$YOUR_NEW_HASH_HERE' WHERE email='admin@gardekids.com';
```

Or use the update-admin.sh script as shown in Method 4 above.
