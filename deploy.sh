#!/bin/bash

# Azure App Service Linux deployment script
echo "Starting deployment for Linux App Service..."

# Copy custom nginx config if it exists
if [ -f "/home/site/wwwroot/default" ]; then
    echo "Copying custom nginx configuration..."
    cp /home/site/wwwroot/default /etc/nginx/sites-available/default
    nginx -t && nginx -s reload
    echo "Nginx configuration updated"
fi

# Set proper permissions
if [ -d "/home/site/wwwroot/logs" ]; then
    chmod -R 777 /home/site/wwwroot/logs
    echo "Logs directory permissions set"
fi

# Ensure composer dependencies are installed
if [ -f "/home/site/wwwroot/composer.json" ]; then
    cd /home/site/wwwroot
    if [ ! -d "vendor" ]; then
        echo "Installing composer dependencies..."
        composer install --no-dev --optimize-autoloader
    fi
fi

echo "Deployment complete!"
