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
    error_log("✓ Application initialized successfully");
} catch (Exception $e) {
    // In production, log this error and show a user-friendly message
    $error_msg = "Database connection error: " . $e->getMessage();
    error_log("✗ " . $error_msg);
    
    // Don't die - allow page to load with database error message
    http_response_code(503);
    echo "<!DOCTYPE html><html><head><title>Service Unavailable</title></head>";
    echo "<body><h1>Service Unavailable</h1>";
    echo "<p>Database connection failed. Please try again later.</p>";
    echo "<pre>" . htmlspecialchars($error_msg) . "</pre>";
    echo "</body></html>";
    exit;
}
?>
