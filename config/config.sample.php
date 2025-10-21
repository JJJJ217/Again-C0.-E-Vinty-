<?php
/**
 * Sample Configuration File (Environment-aware)
 * Copied to config.php in CI/CD. In production, relies on Azure App Settings (DB_* or AZURE_MYSQL_*).
 */

// ENVIRONMENT DETECTION
$isAzure = (
	(isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'azurewebsites.net')) ||
	getenv('WEBSITE_SITE_NAME') !== false
);

// Parse Azure MYSQLCONNSTR_* if provided
$azureConn = ['host' => null, 'db' => null, 'user' => null, 'pass' => null];
foreach (array_merge($_SERVER ?? [], $_ENV ?? []) as $key => $value) {
	if (strpos($key, 'MYSQLCONNSTR_') === 0 && is_string($value)) {
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
		$azureConn['host'] = $kv['Data Source'] ?? null;
		$azureConn['db']   = $kv['Database'] ?? null;
		$azureConn['user'] = $kv['User Id'] ?? null;
		$azureConn['pass'] = $kv['Password'] ?? null;
		break;
	}
}

// Prefer DB_* then AZURE_MYSQL_* then MYSQLCONNSTR_*; fallback to local dev defaults
$db_host = getenv('DB_HOST') ?: (getenv('AZURE_MYSQL_HOST') ?: ($azureConn['host'] ?? ''));
$db_name = getenv('DB_NAME') ?: (getenv('AZURE_MYSQL_DBNAME') ?: (getenv('AZURE_MYSQL_DATABASE') ?: ($azureConn['db'] ?? '')));
$db_user = getenv('DB_USER') ?: (getenv('AZURE_MYSQL_USERNAME') ?: ($azureConn['user'] ?? ''));
$db_pass = getenv('DB_PASS') ?: (getenv('AZURE_MYSQL_PASSWORD') ?: ($azureConn['pass'] ?? ''));
$db_port = (int) (getenv('DB_PORT') ?: (getenv('AZURE_MYSQL_PORT') ?: 3306));

define('DB_HOST', $db_host ?: '127.0.0.1');
define('DB_NAME', $db_name ?: 'evinty_ecommerce');
define('DB_USER', $db_user ?: 'root');
define('DB_PASS', $db_pass ?: '');
define('DB_CHARSET', 'utf8mb4');
define('DB_PORT', $db_port ?: 3306);

// Optional: append @server to username only when explicitly requested
if ($isAzure && !str_contains(DB_USER, '@') && filter_var(getenv('AZURE_APPEND_SERVER_TO_USERNAME') ?: 'false', FILTER_VALIDATE_BOOLEAN)) {
	$azure_username = DB_USER . '@' . str_replace('.mysql.database.azure.com', '', DB_HOST);
	define('DB_USER_AZURE', $azure_username);
}

// SITE CONFIGURATION
$xfp = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) : null;
$is_https_proto = (
	(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
	($xfp === 'https')
);
$forwardedHost = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? null;
$hostHeader = $_SERVER['HTTP_HOST'] ?? 'localhost';
$host = $forwardedHost ?: $hostHeader;
$protocol = ($is_https_proto || $isAzure) ? 'https' : 'http';
if ($protocol === 'https' && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
	$_SERVER['HTTPS'] = 'on';
}
$forwardedPort = $_SERVER['HTTP_X_FORWARDED_PORT'] ?? null;
if ($forwardedPort && !str_contains($host, ':') && !in_array((int)$forwardedPort, [80, 443], true)) {
	$host .= ':' . $forwardedPort;
}
define('SITE_URL', $protocol . '://' . $host);
define('SITE_NAME', 'Again&Co');
define('SITE_EMAIL', getenv('SITE_EMAIL') ?: 'admin@evinty.com');

// ENVIRONMENT
define('ENVIRONMENT', $isAzure ? 'production' : 'development');

// SECURITY
define('SESSION_LIFETIME', 3600);
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);

// File Uploads
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024);
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Pagination
define('PRODUCTS_PER_PAGE', 12);
define('ORDERS_PER_PAGE', 20);

// Error reporting
if (ENVIRONMENT === 'production') {
	ini_set('display_errors', 0);
	ini_set('log_errors', 1);
} else {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}
?>
