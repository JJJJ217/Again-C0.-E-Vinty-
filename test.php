<!DOCTYPE html>
<html>
<head>
    <title>Azure Diagnostic Test</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .ok { color: green; } .error { color: red; }
        pre { background: #fff; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1 class="ok">✅ PHP is Working!</h1>
    <p><strong>Server time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
    <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
    <p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
    <p><strong>OS:</strong> <?php echo PHP_OS; ?></p>
    
    <h2>Environment Variables:</h2>
    <pre>
DB_HOST: <?php echo getenv('DB_HOST') ?: 'NOT SET'; ?>
DB_NAME: <?php echo getenv('DB_NAME') ?: 'NOT SET'; ?>
DB_USER: <?php echo getenv('DB_USER') ?: 'NOT SET'; ?>
DB_PASS: <?php echo getenv('DB_PASS') ? '***SET***' : 'NOT SET'; ?>
    </pre>
    
    <h2>PHP Extensions (MySQL):</h2>
    <ul>
        <li>PDO: <?php echo extension_loaded('pdo') ? '✅ YES' : '❌ NO'; ?></li>
        <li>pdo_mysql: <?php echo extension_loaded('pdo_mysql') ? '✅ YES' : '❌ NO'; ?></li>
        <li>mysqli: <?php echo extension_loaded('mysqli') ? '✅ YES' : '❌ NO'; ?></li>
    </ul>
    
    <h2>Files Check:</h2>
    <ul>
        <li>index.php: <?php echo file_exists(__DIR__ . '/index.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>web.config: <?php echo file_exists(__DIR__ . '/web.config') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>config/config.php: <?php echo file_exists(__DIR__ . '/config/config.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>config/database.php: <?php echo file_exists(__DIR__ . '/config/database.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>includes/init.php: <?php echo file_exists(__DIR__ . '/includes/init.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
    </ul>
    
    <h2>Document Root:</h2>
    <p><?php echo __DIR__; ?></p>
    
    <h2>Database Connection Test:</h2>
    <?php
    try {
        $db_host = getenv('DB_HOST') ?: 'localhost';
        $db_name = getenv('DB_NAME') ?: 'evinty_ecommerce';
        $db_user = getenv('DB_USER') ?: 'root';
        $db_pass = getenv('DB_PASS') ?: '';
        
        $dsn = "mysql:host={$db_host};dbname={$db_name}";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        
        if (strpos($db_host, 'azure.com') !== false) {
            $options[PDO::MYSQL_ATTR_SSL_CA] = true;
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }
        
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        echo '<p class="ok">✅ Database connection successful!</p>';
    } catch (Exception $e) {
        echo '<p class="error">❌ Database connection failed: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    ?>
    
    <hr>
    <p><small>Test page - Delete after verification</small></p>
</body>
</html>
