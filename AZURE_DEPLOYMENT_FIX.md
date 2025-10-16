# Azure Deployment Fix - Again&Co

## What Was Fixed

You were getting a **404 Not Found** error from nginx on Azure because your application wasn't properly configured for cloud deployment. Here's what was resolved:

## Files Created/Modified

### 1. **web.config** (NEW)
- Configures IIS/Azure App Service for PHP routing
- Redirects all requests to `index.php` for proper routing
- Implements HTTPS redirect
- Sets security headers
- Configured for Azure App Service on Windows

### 2. **.htaccess** (NEW)
- Provides Apache compatibility for development/alternate servers
- Enables URL rewriting
- Sets security headers
- Caches static assets
- Protects sensitive files

### 3. **config/config.php** (MODIFIED)
- **Before**: Hardcoded `SITE_URL` to `http://localhost/Again-C0.-E-Vinty-`
- **After**: Dynamically detects environment and sets correct URLs
  - Localhost development → `http://localhost/...`
  - Azure production → `https://your-app.azurewebsites.net`
- Uses environment variables for database credentials on Azure
- Proper error handling for production vs development

### 4. **logs/** (NEW DIRECTORY)
- Created for production error logging

## How It Works Now

### Local Development (No Changes Needed)
Your XAMPP setup continues to work as before at `http://localhost/Again-C0.-E-Vinty-`

### Azure Deployment (NEW)
The app now:
1. ✅ Routes requests properly to `index.php`
2. ✅ Detects Azure domain automatically
3. ✅ Uses environment variables for database connection
4. ✅ Handles HTTPS correctly
5. ✅ Logs errors properly in production

## To Complete Azure Setup

### Step 1: Set Environment Variables in Azure

Go to **Azure Portal** → Your App Service → **Settings** → **Configuration** → **Application settings**

Add these variables:
```
DB_HOST          : your-database-server-name
DB_USER          : your-database-user
DB_PASS          : your-database-password
DB_NAME          : evinty_ecommerce
SITE_EMAIL       : admin@again-co.com
```

### Step 2: Verify Deployment

1. Commit these files to your repository
2. Push to your `main` branch
3. Azure Pipeline will automatically deploy
4. Navigate to your app URL: `https://again-coe-vinty.azurewebsites.net`

### Step 3: Test the Application

- ✅ Check that pages load without 404 errors
- ✅ Test database connections
- ✅ Verify login/registration works

## Database Connection Note

The IP address `127.0.0.0` is **not valid** for Azure databases. You need:
- **Host**: Full server name (e.g., `mysql.database.azure.com` or `postgres.database.azure.com`)
- **User**: Full username (e.g., `admin@servername`)
- **Password**: Your database password
- **Database**: `evinty_ecommerce`

## Troubleshooting

If you still see 404 errors:

1. **Check web.config is deployed**
   - Azure Portal → App Service → Development Tools → Advanced Tools (Kudu)
   - Navigate to `/site/wwwroot/` and verify `web.config` exists

2. **Check environment variables**
   - Go to Azure Portal → Configuration
   - Verify all `DB_*` variables are set

3. **View application logs**
   - Azure Portal → App Service → Log Stream
   - Or check `/logs/error.log` in Kudu

4. **Restart the app**
   - Azure Portal → App Service → Click "Restart"

## Security Notes

✅ **Good practices implemented:**
- HTTPS redirect enabled
- Security headers set
- Error display disabled in production
- Sensitive files protected
- CORS headers configured

⚠️ **Still need to do:**
- Implement proper authentication (passwords should be hashed)
- Set up SQL injection prevention (parameterized queries)
- Add CSRF token validation
- Implement rate limiting for login attempts
