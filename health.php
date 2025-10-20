<?php
/**
 * Health Check Endpoint
 * Diagnostic tool to verify app and database status
 * Access via: https://your-app.azurewebsites.net/health.php
 */

// Don't use init.php to avoid fatal errors blocking health check
$isAzure = str_contains($_SERVER['HTTP_HOST'] ?? '', 'azurewebsites.net');

// Get configuration
$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

// Fallback to defaults
$db_host = $db_host ?: 'localhost';
$db_name = $db_name ?: 'evinty_ecommerce';
$db_user = $db_user ?: 'root';
$db_pass = $db_pass ?: '';

$health = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'environment' => $isAzure ? 'production' : 'development',
    'php_version' => phpversion(),
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'database' => [
        'configured' => true,
        'host' => $db_host,
        'name' => $db_name,
        'user' => $db_user,
        'env_vars_set' => [
            'DB_HOST' => !empty(getenv('DB_HOST')),
            'DB_NAME' => !empty(getenv('DB_NAME')),
            'DB_USER' => !empty(getenv('DB_USER')),
            'DB_PASS' => !empty(getenv('DB_PASS')),
        ]
    ],
    'extensions' => [
        'pdo_mysql' => extension_loaded('pdo_mysql'),
        'mysql' => extension_loaded('mysql'),
        'mysqli' => extension_loaded('mysqli'),
    ],
    'files' => [
        'index.php' => file_exists(__DIR__ . '/index.php'),
        'router.php' => file_exists(__DIR__ . '/router.php'),
        'web.config' => file_exists(__DIR__ . '/web.config'),
        'config/config.php' => file_exists(__DIR__ . '/config/config.php'),
        'config/database.php' => file_exists(__DIR__ . '/config/database.php'),
    ]
];

// Test database connection
try {
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4;ssl_mode=REQUIRED";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => true,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]);
    $health['database']['connection'] = 'connected';
    
    // Test query
    $result = $pdo->query('SELECT 1');
    $health['database']['query_test'] = 'passed';
} catch (Exception $e) {
    $health['status'] = 'error';
    $health['database']['connection'] = 'failed';
    $health['database']['error'] = $e->getMessage();
}

header('Content-Type: application/json');
http_response_code($health['status'] === 'ok' ? 200 : 503);
echo json_encode($health, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
