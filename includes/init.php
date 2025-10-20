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
    // In production, log this error and show a user-friendly message
    $errorMsg = "Database connection error: " . $e->getMessage();
    error_log($errorMsg);
    
    // Log environment info for debugging
    error_log("DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET (localhost fallback)'));
    error_log("DB_NAME: " . (getenv('DB_NAME') ?: 'NOT SET (evinty_ecommerce fallback)'));
    error_log("DB_USER: " . (getenv('DB_USER') ?: 'NOT SET (root fallback)'));
    error_log("Environment: " . ENVIRONMENT);
    
    // Only die if in development mode
    if (ENVIRONMENT === 'development') {
        die($errorMsg);
    } else {
        // In production, show generic error and log details
        error_log("CRITICAL: Database unavailable. Check App Service settings.");
        die('Service temporarily unavailable. Please try again later.');
    }
}
?>
