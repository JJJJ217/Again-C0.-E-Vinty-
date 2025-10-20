<!DOCTYPE html>
<html>
<head>
    <title>Azure Test Page</title>
</head>
<body>
    <h1>✅ PHP is Working!</h1>
    <p>Server time: <?php echo date('Y-m-d H:i:s'); ?></p>
    <p>PHP Version: <?php echo phpversion(); ?></p>
    <p>Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></p>
    
    <h2>Environment Variables:</h2>
    <pre>
DB_HOST: <?php echo getenv('DB_HOST') ?: 'NOT SET'; ?>
DB_NAME: <?php echo getenv('DB_NAME') ?: 'NOT SET'; ?>
DB_USER: <?php echo getenv('DB_USER') ?: 'NOT SET'; ?>
DB_PASS: <?php echo getenv('DB_PASS') ? '***SET***' : 'NOT SET'; ?>
    </pre>
    
    <h2>Files Check:</h2>
    <ul>
        <li>index.php: <?php echo file_exists(__DIR__ . '/index.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>config/config.php: <?php echo file_exists(__DIR__ . '/config/config.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>config/database.php: <?php echo file_exists(__DIR__ . '/config/database.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
        <li>includes/init.php: <?php echo file_exists(__DIR__ . '/includes/init.php') ? '✅ EXISTS' : '❌ MISSING'; ?></li>
    </ul>
    
    <h2>Document Root:</h2>
    <p><?php echo __DIR__; ?></p>
</body>
</html>
