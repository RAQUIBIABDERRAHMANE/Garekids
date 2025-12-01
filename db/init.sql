-- TakeCare Database Initialization Script

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create gallery table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
-- IMPORTANT: Change the password hash before deploying to production!
-- To generate a new hash, run: php -r "echo password_hash('your_password', PASSWORD_BCRYPT);"
-- Or use: ./generate-admin-password.sh "your_password"
-- Default password is: admin123
INSERT INTO users (name, email, password, is_admin) 
VALUES (
    COALESCE(NULLIF(@ADMIN_NAME, ''), 'Admin'),
    COALESCE(NULLIF(@ADMIN_EMAIL, ''), 'admin@takecare.com'),
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1
)
ON DUPLICATE KEY UPDATE id=id;