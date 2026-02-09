# 🔐 TakeCare - Sign Up & Sign In Testing Guide

## ✅ Database Setup Complete!

The database has been configured and is ready for testing.

### 📊 Database Information
- **Database**: `care`
- **Tables Created**:
  - ✅ `users` (with is_admin column)
  - ✅ `testimonials`
  - ✅ `gallery`

### 👤 Pre-configured Accounts

#### Admin Account
- **Email**: `admin@gardekids.com`
- **Password**: `admin123`
- **Role**: Administrator (can access admin panel)

## 🧪 How to Test

### 1. Test Database Connection
Visit: `http://your-domain/takecare/test_db.php`

This will show:
- ✅ Database connection status
- ✅ Tables verification
- ✅ Admin user verification
- ✅ Password verification test

### 2. Create Test User
Visit: `http://your-domain/takecare/create_test_user.php`

This will create a test user:
- **Email**: `test@takecare.com`
- **Password**: `test123`
- **Role**: Regular user

### 3. Test Sign Up (New User Registration)
Visit: `http://your-domain/takecare/signup.php`

**Steps**:
1. Fill in the form:
   - Full Name: `Your Name`
   - Email: `your-email@example.com`
   - Password: `yourpassword` (minimum 6 characters)
2. Click "Create My Account"
3. You should be redirected to the sign-in page with a success message

**What to Check**:
- ✅ Form validation works (empty fields, invalid email, short password)
- ✅ Error messages appear in nice pastel design
- ✅ User is created in database
- ✅ Redirect to signin.php after successful registration

### 4. Test Sign In (Login)
Visit: `http://your-domain/takecare/signin.php`

**Test with Admin**:
- Email: `admin@gardekids.com`
- Password: `admin123`
- Expected: Redirect to admin panel

**Test with Test User**:
- Email: `test@takecare.com`
- Password: `test123`
- Expected: Redirect to profile page

**Test with New User**:
- Use the email/password you created in step 3
- Expected: Redirect to profile page

**What to Check**:
- ✅ Form validation works
- ✅ Invalid credentials show error message
- ✅ Successful login redirects properly
- ✅ Admin users go to admin panel
- ✅ Regular users go to profile page

### 5. Test Profile Page
Visit: `http://your-domain/takecare/profile.php`

**Must be logged in first!**

**What to Check**:
- ✅ User information displays correctly
- ✅ Name, email, and member date shown
- ✅ Quick action links work
- ✅ Admin link appears only for admin users
- ✅ Sign out button works

### 6. Test Logout
Click the "Sign Out" button on profile page

**What to Check**:
- ✅ Session is destroyed
- ✅ Redirected to signin page
- ✅ Cannot access profile page without logging in again

## 🎨 Design Features

### Sign Up Page
- 🎯 Blue pastel hero icon (user-plus)
- 📝 Three color-coded input fields:
  - Blue for name
  - Pink for email
  - Lavender for password
- ✨ Smooth animations and transitions
- 🛡️ Security badges at bottom

### Sign In Page
- 💜 Lavender hero icon (sign-in-alt)
- 📧 Two color-coded inputs
- ☑️ Remember me checkbox
- 🔗 Forgot password link
- 🔒 Trust badges at bottom

### Profile Page
- 👤 User info in colored cards
- ⚡ Quick action links
- 💝 Welcome message
- 🚪 Sign out button

## 🐛 Troubleshooting

### Can't Connect to Database?
Run: `mysql -u caredb -p@@12raquibi care -e "SHOW TABLES;"`
Should show: users, testimonials, gallery

### Password Not Working?
The default admin password is hashed. Test with:
- Email: `admin@gardekids.com`
- Password: `admin123`

### Error Messages?
Check PHP error logs or enable error display in config/db.php

### Session Issues?
Make sure sessions are enabled in PHP and session directory is writable.

## 📝 Notes

1. All passwords are hashed using PHP's `password_hash()` function
2. Prepared statements are used to prevent SQL injection
3. Email validation is performed
4. Minimum password length is 6 characters
5. Session management is secure with proper checks

## 🚀 Ready to Test!

Everything is set up and ready to go. Start with the test_db.php page to verify everything is working!
