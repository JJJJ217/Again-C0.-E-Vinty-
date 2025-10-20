<?php
/**
 * Application Bootstrap
 * Initialize the application and load required files
 */

// Start output buffering
ob_start();

// Include configuration
require_once __DIR__ . '/../config/config.php';

// Include database class
require_once __DIR__ . '/../config/database.php';

// Include utility functions
require_once __DIR__ . '/functions.php';

// Include session management
require_once __DIR__ . '/session.php';

// Check session timeout
checkSessionTimeout();

// Set timezone
date_default_timezone_set('Australia/Sydney');

// Initialize database connection
try {
    $db = new Database();
    // Test connection
    $db->connect();
} catch (Exception $e) {
    // Log the error with details
    error_log("Database connection error: " . $e->getMessage());
    error_log("DB Config - Host: " . DB_HOST . ", DB: " . DB_NAME . ", User: " . DB_USER);
    
    // Don't kill the app - let pages handle database unavailability gracefully
    // Pages that need DB will catch their own errors
    $db = null; // Set to null so pages can check if connection is available
    
    // Only die in development mode for debugging
    if (ENVIRONMENT === 'development') {
        die('<h1>Database Connection Failed</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>');
    }
}
?>
