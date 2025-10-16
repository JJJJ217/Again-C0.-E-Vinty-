#!/bin/bash

# Again&Co Azure App Service Startup Script
# This script configures PHP-FPM and Nginx for proper routing

echo "Starting Again&Co application..."

# Update nginx configuration
echo "Configuring Nginx..."
cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default 2>/dev/null || true

# Ensure PHP-FPM is running
echo "Starting PHP-FPM..."
service php8.4-fpm start || service php-fpm start || true

# Start nginx
echo "Starting Nginx..."
nginx -g "daemon off;" &

# Wait for services
sleep 2

# Log startup completion
echo "Application startup completed at $(date)"
echo "Nginx configuration: $(cat /etc/nginx/sites-available/default | head -10)"
