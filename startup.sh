#!/bin/bash

# Startup script for Azure App Service - Linux with nginx and PHP
# This script configures nginx for PHP routing

echo "=========================================="
echo "Azure App Service Startup Script"
echo "=========================================="
echo "Starting at: $(date)"
echo ""

# Set the site root
SITE_HOME="/home/site/wwwroot"
echo "📁 Site home: $SITE_HOME"

# Copy nginx configuration to the correct location
if [ -f "$SITE_HOME/nginx.conf" ]; then
    echo "✓ Found custom nginx.conf in application"
    
    # Azure App Service uses /etc/nginx/sites-enabled/
    if [ -d "/etc/nginx/sites-enabled" ]; then
        echo "📝 Copying nginx.conf to /etc/nginx/sites-enabled/default"
        cp "$SITE_HOME/nginx.conf" /etc/nginx/sites-enabled/default 2>/dev/null || true
    fi
    
    # Also try /etc/nginx/conf.d/
    if [ -d "/etc/nginx/conf.d" ]; then
        echo "📝 Copying nginx.conf to /etc/nginx/conf.d/default.conf"
        cp "$SITE_HOME/nginx.conf" /etc/nginx/conf.d/default.conf 2>/dev/null || true
    fi
else
    echo "⚠ Custom nginx.conf not found in application"
fi

# Create necessary directories for PHP
mkdir -p /var/log/nginx 2>/dev/null || true
mkdir -p /var/run/php 2>/dev/null || true

# Set proper permissions
if [ -d "$SITE_HOME" ]; then
    echo "🔐 Setting permissions for site directory..."
    chmod -R 755 "$SITE_HOME" 2>/dev/null || true
    find "$SITE_HOME" -type f -exec chmod 644 {} \; 2>/dev/null || true
fi

# Test nginx configuration
echo ""
echo "🔍 Testing nginx configuration..."
nginx -t 2>&1 || echo "Warning: nginx test had an issue"

# Reload or restart nginx
echo ""
echo "🔄 Reloading nginx..."
nginx -s reload 2>&1 || true

# Display nginx status
echo ""
echo "📊 Nginx status:"
ps aux | grep nginx | grep -v grep || echo "nginx not running yet"

echo ""
echo "✅ Startup script completed at: $(date)"
echo "=========================================="
