# TakeCare Childcare Website

Professional childcare website with AI-powered features, multi-language support, and admin panel.

## 🚀 Quick Start

### Local Development

#### Windows
```bash
# Initialize SQLite database
init-sqlite.bat

# Start PHP server
php -S localhost:8000
```

#### Linux/Mac
```bash
# Initialize SQLite database
chmod +x init-sqlite.sh
./init-sqlite.sh

# Start PHP server
php -S localhost:8000
```

### Deployment
For deployment instructions, see [QUICKSTART_VERCEL.md](QUICKSTART_VERCEL.md)

**✨ Now using SQLite** - No external database needed! Perfect for Vercel.

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
- **Database:** SQLite (perfect for Vercel!)
- **Frontend:** HTML5, CSS3, Tailwind CSS, JavaScript
- **AI:** Groq API (llama-3.3-70b-versatile)

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
├── vercel.json         # Vercel configuration
└── VERCEL_DEPLOYMENT.md # Deployment guide
```

## 🔧 Configuration

### Database
SQLite is used by default - **no configuration needed!**

Database file: `db/care.db` (auto-created)

Optional: Set custom path via environment variable:
```env
DB_PATH=/custom/path/database.db
```

### Groq AI
Set your API key as environment variable:
```env
GROQ_API_KEY=your_api_key_here
```

See [SQLITE_GUIDE.md](SQLITE_GUIDE.md) for database management details.

## 📊 Database Tables

- **users** - User accounts and admin roles
- **testimonials** - User testimonials with AI analysis
- *

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

### Super Simple with SQLite!

No external database needed! SQLite is perfect for Vercel.

#### Vercel (Recommended)
```bash
npm install -g vercel
vercel login
vercel
```

That's it! The database is auto-initialized. ✨

#### Railway (Alternative)
```bash
npm install -g @railway/cli
railway login
railway init
railway up
```

#### Render (Alternative)
1. Connect your GitHub repository
2. Select "Web Service"
3. Deploy

### Environment Variables

Only one variable needed:
```env
GROQ_API_KEY=your_groq_api_key
```

Optional:
```env
DB_PATH=/custom/path/database.db
```

### Production Checklist

1. ✅ Configure GROQ_API_KEY environment variable
2. ✅ Change admin password (default: admin@gardekids.com / admin123)
3. ✅ Set up cloud storage for uploads (Cloudinary recommended)
4. ✅ Configure error logging
5. ✅ Remove test files from production
6. ⚠️ **Important:** SQLite on Vercel uses `/tmp` (ephemeral storage)
   - Data resets after ~15 minutes of inactivity
   - Perfect for demos and prototypes
   - For production persistence, see [SQLITE_GUIDE.md](SQLITE_GUIDE.md)

See [QUICKSTART_VERCEL.md](QUICKSTART_VERCEL.md) for detailed deployment guide.

---

**Made with ❤️ for TakeCare Childcare Services**
