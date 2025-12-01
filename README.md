# TakeCare Childcare Website

Professional childcare website with AI-powered features, multi-language support, and admin panel.

## 🚀 Quick Start with Docker

### Prerequisites
- Docker & Docker Compose installed

### Start the application
```bash
# Make the script executable
chmod +x start-docker.sh

# Run the script
./start-docker.sh
```

Or manually:
```bash
docker-compose up -d
```

### Access the website
- **Website:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081
- **Admin Login:** admin@takecare.com / admin123

## 📋 Features

✅ **User Management**
- Signup/Signin with password hashing
- User profiles
- Admin panel with role-based access

✅ **AI-Powered Testimonials**
- Automatic sentiment analysis with Groq AI
- Smart filtering (only positive testimonials displayed)
- Admin moderation dashboard

✅ **Multi-Language Support**
- English & French
- Session-based language switching
- Complete translations

✅ **AI Chatbot**
- Groq AI integration
- Contextual responses about childcare services
- Markdown formatting support
- Floating widget with pastel design

✅ **Admin Dashboard**
- User management
- Testimonial moderation with AI insights
- Gallery management
- Statistics overview

✅ **Responsive Design**
- Pastel color scheme
- Mobile-friendly navigation
- Modern UI with Tailwind CSS

## 🏗️ Tech Stack

- **Backend:** PHP 8.2
- **Database:** MySQL 8.0
- **Frontend:** HTML5, CSS3, Tailwind CSS, JavaScript
- **AI:** Groq API (llama-3.3-70b-versatile)
- **Containerization:** Docker & Docker Compose

## 📁 Project Structure

```
takecare/
├── admin/              # Admin panel pages
├── api/                # API endpoints (chatbot, testimonials)
├── assets/             # CSS, JS, images
├── config/             # Configuration files
├── db/                 # Database scripts
├── includes/           # Header, footer components
├── lang/               # Language files (EN, FR)
├── uploads/            # User uploads (gallery)
├── docker-compose.yml  # Docker services configuration
├── Dockerfile          # Web container configuration
└── start-docker.sh     # Quick start script
```

## 🔧 Configuration

### Database
Update `config/db.php` or use environment variables:
```php
DB_HOST=db
DB_NAME=care
DB_USER=caredb
DB_PASSWORD=@@12raquibi
```

### Groq AI
Set your API key in `config/groq.php`:
```php
define('GROQ_API_KEY', 'your_api_key_here');
```

## 📊 Database Tables

- **users** - User accounts and admin roles
- **testimonials** - User testimonials with AI analysis
- **gallery** - Image gallery with captions

## 🐳 Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f web

# Access web container
docker exec -it takecare_web bash

# Database backup
docker exec takecare_db mysqldump -u caredb -p@@12raquibi care > backup.sql
```

## 🌐 Pages

### Public Pages
- `/` - Home
- `/about.php` - About Us
- `/services.php` - Services
- `/gallery.php` - Photo Gallery
- `/testimonials.php` - Client Testimonials
- `/faq.php` - FAQ
- `/contact.php` - Contact Form
- `/submit_testimonial.php` - Submit Testimonial

### User Pages
- `/signup.php` - User Registration
- `/signin.php` - User Login
- `/profile.php` - User Profile

### Admin Pages
- `/admin/` - Dashboard
- `/admin/users.php` - User Management
- `/admin/testimonials.php` - Testimonial Moderation
- `/admin/gallery.php` - Gallery Management

## 🤖 AI Features

### Chatbot
- Context-aware responses about childcare services
- Filters non-childcare questions
- Markdown formatting (bold, lists, links)
- Session-based conversation history

### Testimonial Analysis
- Automatic sentiment detection
- Confidence scoring (0-1)
- Only positive testimonials displayed publicly
- Full transparency for admins

## 🎨 Design System

**Pastel Color Palette:**
- Blue: `#A8D8EA`
- Pink: `#FFB6C1`
- Mint: `#B5EAD7`
- Lavender: `#C7CEEA`
- Dark: `#2C3E50`

## 🔐 Security

- Password hashing with bcrypt
- Prepared statements (SQL injection prevention)
- Session-based authentication
- CSRF protection
- Input validation and sanitization

## 📱 Responsive Design

- Mobile-first approach
- Hamburger menu for mobile
- Touch-friendly buttons
- Optimized images

## 🌍 Multi-Language

Switch between English and French:
- `?lang=en` - English
- `?lang=fr` - French

Translations stored in:
- `lang/en.php`
- `lang/fr.php`

## 🚀 Deployment

### Production Checklist
1. Change database passwords
2. Update Groq API key
3. Enable HTTPS
4. Remove phpMyAdmin service
5. Set up automated backups
6. Configure firewall rules
7. Enable error logging

### Environment Variables
Create `.env` file:
```env
DB_HOST=your_db_host
DB_NAME=your_db_name
DB_USER=your_db_user
DB_PASSWORD=your_secure_password
GROQ_API_KEY=your_groq_api_key
```

## 📝 License

This project is private and proprietary.

## 🤝 Support

For issues or questions, contact the development team.

---

**Made with ❤️ for TakeCare Childcare Services**
