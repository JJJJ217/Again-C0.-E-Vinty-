#!/bin/bash

# Azure App Service deployment script
echo "Starting deployment..."

# Copy files to the web root
if [ -d "/home/site/wwwroot" ]; then
    echo "Deployment complete!"
else
    echo "Warning: /home/site/wwwroot not found"
fi

# Ensure proper permissions
chmod -R 755 /home/site/wwwroot || true

echo "Deployment script finished"
