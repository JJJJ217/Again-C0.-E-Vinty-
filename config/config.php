<?php
/**
 * Application Configuration
 * Supports both local development and Azure cloud deployment
 */

// ENVIRONMENT DETECTION
$isAzure = (
    (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'azurewebsites.net')) ||
    getenv('WEBSITE_SITE_NAME') !== false // Reliable signal on Azure App Service
);

// Helper: parse Azure "Connection strings" env vars if present (MYSQLCONNSTR_*)
$azureConn = [
    'host' => null,
    'db'   => null,
    'user' => null,
    'pass' => null,
];

foreach (array_merge($_SERVER ?? [], $_ENV ?? []) as $key => $value) {
    if (strpos($key, 'MYSQLCONNSTR_') === 0 && is_string($value)) {
        // Example: "Database=mydb;Data Source=servername.mysql.database.azure.com;User Id=user@servername;Password=secret"
        $parts = array_filter(array_map('trim', explode(';', $value)));
        $kv = [];
        foreach ($parts as $p) {
            $eqPos = strpos($p, '=');
            if ($eqPos !== false) {
                $k = trim(substr($p, 0, $eqPos));
                $v = trim(substr($p, $eqPos + 1));
                $kv[$k] = $v;
            }
        }
        $azureConn['host'] = $kv['Data Source'] ?? $azureConn['host'];
        $azureConn['db']   = $kv['Database'] ?? $azureConn['db'];
        $azureConn['user'] = $kv['User Id'] ?? $azureConn['user'];
        $azureConn['pass'] = $kv['Password'] ?? $azureConn['pass'];
        // Use the first MYSQLCONNSTR_* we find
        break;
    }
}

// DATABASE CONFIGURATION
// Prefer explicit DB_* env vars. If missing and on Azure, fall back to AZURE_MYSQL_* and then MYSQLCONNSTR_* parsing.
$envAll = array_merge($_ENV ?? [], $_SERVER ?? []);

$db_host = getenv('DB_HOST')
    ?: ($envAll['AZURE_MYSQL_HOST'] ?? '')
    ?: ($isAzure ? ($azureConn['host'] ?? '') : '');
$db_name = getenv('DB_NAME')
    ?: ($envAll['AZURE_MYSQL_DATABASE'] ?? '')
    ?: ($isAzure ? ($azureConn['db'] ?? '') : '');
$db_user = getenv('DB_USER')
    ?: ($envAll['AZURE_MYSQL_USERNAME'] ?? '')
    ?: ($isAzure ? ($azureConn['user'] ?? '') : '');
$db_pass = getenv('DB_PASS')
    ?: ($envAll['AZURE_MYSQL_PASSWORD'] ?? '')
    ?: ($isAzure ? ($azureConn['pass'] ?? '') : '');
$db_port = (int) (
    getenv('DB_PORT') ?: ($envAll['AZURE_MYSQL_PORT'] ?? 0)
);

// Log what we're reading (safe)
error_log('=== CONFIG DEBUG ===');
error_log('Is Azure: ' . ($isAzure ? 'YES' : 'NO'));
error_log('DB_HOST from env/connstr: ' . ($db_host !== '' ? $db_host : 'NOT SET'));
error_log('DB_NAME from env/connstr: ' . ($db_name !== '' ? $db_name : 'NOT SET'));
error_log('DB_USER from env/connstr: ' . ($db_user !== '' ? $db_user : 'NOT SET'));
error_log('DB_PASS from env/connstr: ' . ($db_pass !== '' ? '***' : 'NOT SET'));
error_log('DB_PORT from env/connstr: ' . ($db_port ? $db_port : 'NOT SET'));

// Fallback to sane defaults if env vars not set
// Use 127.0.0.1 instead of 'localhost' to force TCP (avoid Unix socket issues like SQLSTATE[HY000] [2002])
define('DB_HOST', $db_host !== '' ? $db_host : '127.0.0.1');
define('DB_NAME', $db_name !== '' ? $db_name : 'evinty_ecommerce');
define('DB_USER', $db_user !== '' ? $db_user : 'root');
define('DB_PASS', $db_pass !== '' ? $db_pass : '');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', $db_port ?: 3306);

// For Azure MySQL, format username as user@server if needed
if ($isAzure && !str_contains(DB_USER, '@') && str_contains(DB_HOST, 'mysql.database.azure.com')) {
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
