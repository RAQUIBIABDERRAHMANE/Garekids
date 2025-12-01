.PHONY: help build up down restart logs shell db-shell clean deploy

# Default target
help:
	@echo ""
	@echo "🚀 TakeCare Docker Commands"
	@echo "==========================="
	@echo ""
	@echo "  make deploy    - Full auto-deploy (build + start + setup)"
	@echo "  make up        - Start containers"
	@echo "  make down      - Stop containers"
	@echo "  make restart   - Restart containers"
	@echo "  make build     - Rebuild containers"
	@echo "  make logs      - View logs (follow mode)"
	@echo "  make shell     - Access web container shell"
	@echo "  make db-shell  - Access database shell"
	@echo "  make clean     - Stop and remove all data"
	@echo "  make backup    - Backup database"
	@echo "  make status    - Show container status"
	@echo ""

# Full deployment
deploy:
	@chmod +x start-docker.sh
	@./start-docker.sh

# Build containers
build:
	docker-compose build --no-cache

# Start containers
up:
	docker-compose up -d

# Stop containers
down:
	docker-compose down

# Restart containers
restart:
	docker-compose restart

# View logs
logs:
	docker-compose logs -f

# Web container logs only
logs-web:
	docker-compose logs -f web

# Database logs only
logs-db:
	docker-compose logs -f db

# Access web container shell
shell:
	docker exec -it takecare_web bash

# Access database shell
db-shell:
	docker exec -it takecare_db mysql -u caredb -p care

# Show container status
status:
	docker-compose ps

# Clean everything (including database)
clean:
	docker-compose down -v --rmi local
	rm -rf logs/*

# Backup database
backup:
	@mkdir -p backups
	@docker exec takecare_db mysqldump -u caredb -p'@@12raquibi' care > backups/backup_$$(date +%Y%m%d_%H%M%S).sql
	@echo "✅ Backup created in backups/ folder"

# Restore database (usage: make restore FILE=backups/backup_xxx.sql)
restore:
	@docker exec -i takecare_db mysql -u caredb -p'@@12raquibi' care < $(FILE)
	@echo "✅ Database restored from $(FILE)"

# Update and restart
update:
	git pull
	docker-compose up -d --build
