#!/bin/bash

# ===========================================
# TakeCare Docker Auto-Deploy Script
# ===========================================

set -e

echo ""
echo "🚀 =================================="
echo "   TakeCare Auto-Deploy"
echo "==================================="
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    echo "   Visit: https://docs.docker.com/get-docker/"
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    echo "   Visit: https://docs.docker.com/compose/install/"
    exit 1
fi

# Determine docker compose command
if docker compose version &> /dev/null 2>&1; then
    COMPOSE_CMD="docker compose"
else
    COMPOSE_CMD="docker-compose"
fi

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ .env file created. You can customize it later."
    else
        echo "⚠️  .env.example not found. Using default values."
    fi
fi

# Create necessary directories
echo "📁 Creating necessary directories..."
mkdir -p uploads/gallery
mkdir -p logs
chmod -R 777 uploads logs

# Stop any running containers
echo "🛑 Stopping existing containers..."
$COMPOSE_CMD down 2>/dev/null || true

# Build and start containers
echo "🔨 Building and starting containers..."
$COMPOSE_CMD up -d --build

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 5

# Check container status
echo ""
echo "📊 Container Status:"
$COMPOSE_CMD ps

# Get the port from .env or use default
WEB_PORT=$(grep -E "^WEB_PORT=" .env 2>/dev/null | cut -d '=' -f2 || echo "8080")
PHPMYADMIN_PORT=$(grep -E "^PHPMYADMIN_PORT=" .env 2>/dev/null | cut -d '=' -f2 || echo "8081")
ADMIN_EMAIL=$(grep -E "^ADMIN_EMAIL=" .env 2>/dev/null | cut -d '=' -f2 || echo "admin@takecare.com")

echo ""
echo "🎉 =================================="
echo "   TakeCare is now running!"
echo "==================================="
echo ""
echo "📍 Access Points:"
echo "   🌐 Website:     http://localhost:${WEB_PORT}"
echo "   🔧 phpMyAdmin:  http://localhost:${PHPMYADMIN_PORT}"
echo ""
echo "🔐 Admin Credentials:"
echo "   📧 Email:    ${ADMIN_EMAIL}"
echo "   🔑 Password: (check your .env file)"
echo ""
echo "📊 Useful Commands:"
echo "   View logs:     $COMPOSE_CMD logs -f"
echo "   Stop:          $COMPOSE_CMD down"
echo "   Restart:       $COMPOSE_CMD restart"
echo "   Rebuild:       $COMPOSE_CMD up -d --build"
echo ""
echo "✨ Enjoy TakeCare!"
echo ""
