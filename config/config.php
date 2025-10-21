<?php
/**
 * Application Configuration
 * Supports both local development and Azure cloud deployment
 */

// ENVIRONMENT DETECTION
$isAzure = (
    (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'azurewebsites.net')) ||
    getenv('WEBSITE_SITE_NAME') !== false
);

// DATABASE CONFIGURATION
// Uses environment variables on Azure, defaults to localhost for dev
$env = array_merge($_ENV ?? [], $_SERVER ?? []);

// Prefer DB_*; then AZURE_MYSQL_*; allow both DBNAME and DATABASE
$db_host = getenv('DB_HOST') ?: ($env['AZURE_MYSQL_HOST'] ?? '');
$db_name = getenv('DB_NAME') ?: ($env['AZURE_MYSQL_DBNAME'] ?? ($env['AZURE_MYSQL_DATABASE'] ?? ''));
$db_user = getenv('DB_USER') ?: ($env['AZURE_MYSQL_USERNAME'] ?? '');
$db_pass = getenv('DB_PASS') ?: ($env['AZURE_MYSQL_PASSWORD'] ?? '');
$db_port = (int) (getenv('DB_PORT') ?: ($env['AZURE_MYSQL_PORT'] ?? 0));

// Log what we're reading
error_log('=== CONFIG DEBUG ===');
error_log('Is Azure: ' . ($isAzure ? 'YES' : 'NO'));
error_log('DB_HOST from env: ' . ($db_host !== false ? $db_host : 'NOT SET'));
error_log('DB_NAME from env: ' . ($db_name !== false ? $db_name : 'NOT SET'));
error_log('DB_USER from env: ' . ($db_user !== false ? $db_user : 'NOT SET'));
error_log('DB_PASS from env: ' . ($db_pass !== '' ? '***' : 'NOT SET'));
error_log('DB_PORT from env: ' . ($db_port ? $db_port : 'NOT SET'));

// Fallback to defaults if env vars not set
// Use 127.0.0.1 to avoid Unix socket issues if it falls back
define('DB_HOST', $db_host ?: '127.0.0.1');
define('DB_NAME', $db_name ?: 'evinty_ecommerce');
define('DB_USER', $db_user ?: 'root');
define('DB_PASS', $db_pass ?: '');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', $db_port ?: 3306);

// For Azure Single Server, username is user@server; for Flexible Server it's just user.
// If AZURE_MYSQL_USERNAME was provided, assume Flexible Server and DO NOT append.
if ($isAzure && !str_contains(DB_USER, '@') && empty($env['AZURE_MYSQL_USERNAME'])) {
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
