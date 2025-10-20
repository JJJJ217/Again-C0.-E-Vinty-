#!/bin/sh

# Azure App Service Linux startup script
echo "Starting Again&Co application..."

# Copy custom nginx configuration if exists
if [ -f "/home/site/wwwroot/default" ]; then
    echo "Applying custom nginx configuration..."
    cp /home/site/wwwroot/default /etc/nginx/sites-available/default
    cp /home/site/wwwroot/default /etc/nginx/sites-enabled/default
    nginx -t && service nginx reload
fi

# Set proper permissions
chmod -R 755 /home/site/wwwroot
[ -d "/home/site/wwwroot/logs" ] && chmod -R 777 /home/site/wwwroot/logs

echo "Application started successfully!"
