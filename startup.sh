#!/bin/bash

# Startup script for Azure App Service - Linux with nginx
# This script ensures proper nginx configuration for PHP routing

echo "=========================================="
echo "Azure App Service Startup Script"
echo "=========================================="
echo "Starting at: $(date)"
echo ""

# Determine the home directory
SITE_HOME="/home/site/wwwroot"

echo "📁 Site home: $SITE_HOME"

# Check if nginx config exists in the site
if [ -f "$SITE_HOME/nginx.conf" ]; then
    echo "✓ Found custom nginx.conf in application"
    
    # Azure App Service locations for nginx configuration
    # Option 1: App Service nginx.conf location
    if [ -d "/etc/nginx/sites-enabled" ]; then
        echo "📝 Copying nginx.conf to /etc/nginx/sites-enabled/"
        sudo cp "$SITE_HOME/nginx.conf" /etc/nginx/sites-enabled/default || true
    fi
    
    # Option 2: App Service nginx default location
    if [ -d "/etc/nginx/conf.d" ]; then
        echo "📝 Copying nginx.conf to /etc/nginx/conf.d/"
        sudo cp "$SITE_HOME/nginx.conf" /etc/nginx/conf.d/default.conf || true
    fi
    
    # Create symlink to main nginx.conf if it exists
    if [ -f "/etc/nginx/nginx.conf" ]; then
        echo "📝 Updating /etc/nginx/nginx.conf to use custom config"
        # Only update if we have write permissions
        if [ -w "/etc/nginx/nginx.conf" ]; then
            sudo sed -i 's|include /etc/nginx/conf.d/\*.conf;|include '"$SITE_HOME"'/nginx.conf;|g' /etc/nginx/nginx.conf || true
        fi
    fi
else
    echo "⚠ Custom nginx.conf not found in application"
fi

# Ensure proper permissions
if [ -d "$SITE_HOME" ]; then
    echo "🔐 Setting permissions for site directory..."
    chmod -R 755 "$SITE_HOME" 2>/dev/null || true
    chmod -R 644 "$SITE_HOME"/*.* 2>/dev/null || true
fi

# Test nginx configuration
echo ""
echo "🔍 Testing nginx configuration..."
nginx -t 2>&1

# Reload nginx
echo ""
echo "🔄 Reloading nginx..."
sudo nginx -s reload 2>&1 || sudo systemctl reload nginx 2>&1 || true

echo ""
echo "✅ Startup script completed at: $(date)"
echo "=========================================="
