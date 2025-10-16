# Azure App Service Configuration Checklist

## ✅ Files Already Added to Your Project

- [x] `web.config` - IIS/Azure routing configuration
- [x] `.htaccess` - Apache routing configuration  
- [x] `config/config.php` - Updated for environment detection
- [x] `logs/` - Directory for error logging
- [x] `.env.example` - Environment setup guide
- [x] `AZURE_DEPLOYMENT_FIX.md` - Complete documentation

## 📋 Next Steps in Azure Portal

### 1. Set Database Environment Variables
Location: **App Service → Settings → Configuration → Application settings**

| Name | Value |
|------|-------|
| `DB_HOST` | Your database hostname |
| `DB_USER` | Your database username |
| `DB_PASS` | Your database password |
| `DB_NAME` | `evinty_ecommerce` |
| `SITE_EMAIL` | `admin@again-co.com` |

### 2. Verify PHP Configuration
Location: **App Service → Settings → Configuration → General settings**

Ensure:
- ✅ PHP version: 8.0 or higher
- ✅ Stack: PHP
- ✅ Platform: 64-bit (if available)

### 3. Enable Application Insights (Optional but Recommended)
Location: **App Service → Settings → Application Insights**

This helps monitor errors and performance.

### 4. Deploy
Push your code to the `main` branch:
```bash
git add .
git commit -m "Fix Azure deployment configuration"
git push origin main
```

The Azure Pipeline will automatically deploy.

### 5. Test
- Navigate to: `https://again-coe-vinty.azurewebsites.net`
- Should see your homepage (not 404)
- Test login/products/cart functionality

## 🆘 If Still Getting 404 Error

1. **Check deployment succeeded**
   - Azure Portal → Deployment Center → Recent deployments
   - Should show "Success" (green checkmark)

2. **Verify web.config was deployed**
   - App Service → Advanced Tools (Kudu) → Console
   - Run: `dir D:\home\site\wwwroot\web.config`
   - Should show the file exists

3. **View live logs**
   - Azure Portal → Log stream
   - Try accessing a page and watch for errors

4. **Check database connectivity**
   - Is your database accessible from Azure?
   - Can you ping the database host from the app?

## Database Connection Troubleshooting

**Wrong format (DON'T USE):**
- `127.0.0.0` ❌ Not a valid IP
- `localhost` ❌ Won't work from Azure

**Correct formats:**
- PostgreSQL: `myserver.postgres.database.azure.com` ✅
- MySQL: `myserver.mysql.database.azure.com` ✅
- SQL Server: `myserver.database.windows.net` ✅
- On-premises: Use IP address like `192.168.1.100` ✅

## Questions?

For more details, read: `AZURE_DEPLOYMENT_FIX.md`
