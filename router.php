<?php
/**
 * PHP Development Server Router
 * Serves static files and routes dynamic requests through index.php
 */

$requested_file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// If it's a real file, serve it directly
if (is_file($requested_file)) {
    return false;
}

// If it's a real directory, look for index.php
if (is_dir($requested_file)) {
    if (is_file($requested_file . '/index.php')) {
        require $requested_file . '/index.php';
        return true;
    }
    return false;
}

// Default: route to index.php for application routing
require __DIR__ . '/index.php';