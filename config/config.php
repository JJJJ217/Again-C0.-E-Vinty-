<?php
/**
 * Application Configuration
 * Supports both local development and Azure cloud deployment
 */

// ENVIRONMENT DETECTION
$isAzure = str_contains($_SERVER['HTTP_HOST'] ?? '', 'azurewebsites.net');

// DATABASE CONFIGURATION
// Uses environment variables on Azure, defaults to localhost for dev
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

// Log what we're reading
error_log('=== CONFIG DEBUG ===');
error_log('Is Azure: ' . ($isAzure ? 'YES' : 'NO'));
error_log('DB_HOST from env: ' . ($db_host !== false ? $db_host : 'NOT SET'));
error_log('DB_NAME from env: ' . ($db_name !== false ? $db_name : 'NOT SET'));
error_log('DB_USER from env: ' . ($db_user !== false ? $db_user : 'NOT SET'));
error_log('DB_PASS from env: ' . ($db_pass !== false ? '***' : 'NOT SET'));

// Fallback to defaults if env vars not set
define('DB_HOST', $db_host ?: 'localhost');
define('DB_NAME', $db_name ?: 'evinty_ecommerce');
define('DB_USER', $db_user ?: 'root');
define('DB_PASS', $db_pass ?: '');
define('DB_CHARSET', 'utf8mb4');

// For Azure MySQL, format username as user@server
if ($isAzure && !str_contains(DB_USER, '@')) {
    $azure_username = DB_USER . '@' . str_replace('.mysql.database.azure.com', '', DB_HOST);
    define('DB_USER_AZURE', $azure_username);
    error_log('Azure MySQL username formatted as: ' . $azure_username);
}

// Debug: Log configuration for Azure troubleshooting
if ($isAzure) {
    error_log('✓ Using Azure configuration');
    error_log('Azure DB Config - Host: ' . DB_HOST . ', DB: ' . DB_NAME . ', User: ' . DB_USER);
} else {
    error_log('✓ Using Local development configuration');
}

// SITE CONFIGURATION
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('SITE_URL', $protocol . '://' . $host);
define('SITE_NAME', 'Again&Co');
define('SITE_EMAIL', getenv('SITE_EMAIL') ?: 'admin@evinty.com');

// ENVIRONMENT
define('ENVIRONMENT', $isAzure ? 'production' : 'development');

// SECURITY SETTINGS
define('SESSION_LIFETIME', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);

// FILE UPLOAD SETTINGS
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// PAGINATION SETTINGS
define('PRODUCTS_PER_PAGE', 12);
define('ORDERS_PER_PAGE', 10);

// ERROR REPORTING
if (ENVIRONMENT === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>
