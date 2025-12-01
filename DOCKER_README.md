# TakeCare Website - Docker Configuration

This directory contains Docker configuration files to run the TakeCare childcare website.

## Prerequisites

- Docker installed ([Install Docker](https://docs.docker.com/get-docker/))
- Docker Compose installed ([Install Docker Compose](https://docs.docker.com/compose/install/))

## Quick Start

### 1. Clone or navigate to the project directory
```bash
cd /var/www/html/takecare
```

### 2. Start the containers
```bash
docker-compose up -d
```

This will start:
- **MySQL 8.0** database on port `3306`
- **PHP 8.2 + Apache** web server on port `8080`
- **phpMyAdmin** on port `8081`

### 3. Access the website
- Website: http://localhost:8080
- phpMyAdmin: http://localhost:8081
  - Username: `caredb`
  - Password: `@@12raquibi`

## Database Configuration

The database connection is configured in `config/db.php`. For Docker, update the host to `db`:

```php
$servername = "db";  // Changed from "localhost"
$username = "caredb";
$password = "@@12raquibi";
$dbname = "care";
```

## Initial Database Setup

Create `db/init.sql` with your database schema:

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_name VARCHAR(100),
    content TEXT,
    user_id INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    ai_sentiment VARCHAR(50),
    ai_score DECIMAL(3,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Docker Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f web
docker-compose logs -f db
```

### Restart containers
```bash
docker-compose restart
```

### Stop and remove all data (including database)
```bash
docker-compose down -v
```

### Access container shell
```bash
# Web container
docker exec -it takecare_web bash

# Database container
docker exec -it takecare_db bash
```

### Import database
```bash
docker exec -i takecare_db mysql -u caredb -p@@12raquibi care < backup.sql
```

### Export database
```bash
docker exec takecare_db mysqldump -u caredb -p@@12raquibi care > backup.sql
```

## Services

### Web Server (PHP + Apache)
- **Container name:** takecare_web
- **Port:** 8080
- **Technology:** PHP 8.2, Apache 2.4
- **Extensions:** PDO, MySQLi, GD, cURL

### Database (MySQL)
- **Container name:** takecare_db
- **Port:** 3306
- **Version:** MySQL 8.0
- **Database:** care
- **User:** caredb
- **Password:** @@12raquibi

### phpMyAdmin
- **Container name:** takecare_phpmyadmin
- **Port:** 8081
- **Access:** http://localhost:8081

## File Permissions

The uploads directory is automatically created with write permissions:
```bash
uploads/
└── gallery/
```

## Environment Variables

You can customize environment variables in `docker-compose.yml`:

```yaml
environment:
  - DB_HOST=db
  - DB_NAME=care
  - DB_USER=caredb
  - DB_PASSWORD=@@12raquibi
```

## Production Deployment

For production, consider:

1. **Use environment variables file** (`.env`)
2. **Enable HTTPS** with SSL certificates
3. **Change default passwords**
4. **Remove phpMyAdmin** service
5. **Set up backups** for database volumes
6. **Use Docker secrets** for sensitive data

Example production `.env` file:
```env
DB_ROOT_PASSWORD=your_secure_root_password
DB_PASSWORD=your_secure_password
GROQ_API_KEY=your_groq_api_key
```

## Troubleshooting

### Database connection failed
Check if database is ready:
```bash
docker-compose logs db
```

### Permission denied on uploads
Fix permissions:
```bash
docker exec takecare_web chown -R www-data:www-data /var/www/html/uploads
docker exec takecare_web chmod -R 777 /var/www/html/uploads
```

### Port already in use
Change ports in `docker-compose.yml`:
```yaml
ports:
  - "8080:80"  # Change 8080 to another port
```

## Volumes

### Persistent Data
- **db_data:** MySQL database files (persistent)
- **./uploads:** User uploaded files (mounted from host)

### Backup volumes
```bash
docker run --rm -v takecare_db_data:/data -v $(pwd):/backup ubuntu tar czf /backup/db_backup.tar.gz /data
```

## Network

All services run on the `takecare_network` bridge network, allowing internal communication.

## Support

For issues or questions, check:
- Docker logs: `docker-compose logs`
- Container status: `docker-compose ps`
- Network: `docker network inspect takecare_takecare_network`

---

**Ready to deploy!** 🚀
