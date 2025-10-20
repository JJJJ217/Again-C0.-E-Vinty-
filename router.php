<?php
/**
 * PHP Router for Azure App Service
 * Routes all requests to the appropriate PHP files
 * Works with both IIS (web.config) and nginx (direct routing)
 */

// Get the requested URI path
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$request_path = parse_url($request_uri, PHP_URL_PATH);
$document_root = $_SERVER['DOCUMENT_ROOT'];

// Remove trailing slash for file comparison
$request_path = rtrim($request_path, '/');

// If it's the root or empty, serve index.php
if (empty($request_path) || $request_path === '' || $request_path === '/') {
    require $document_root . '/index.php';
    return true;
}

// Check if the requested file exists
$file_path = $document_root . $request_path;

// If it's a real file (CSS, JS, images, etc), serve it
if (is_file($file_path)) {
    return false; // Let the server serve the file
}

// If it's a real directory, look for index.php in it
if (is_dir($file_path)) {
    $index_file = $file_path . '/index.php';
    if (file_exists($index_file)) {
        require $index_file;
        return true;
    }
}

// Try to add .php extension if not already there
if (strpos($request_path, '.php') === false) {
    $php_file = $file_path . '.php';
    if (file_exists($php_file)) {
        $_SERVER['SCRIPT_FILENAME'] = $php_file;
        require $php_file;
        return true;
    }
}

// If it looks like a PHP file request
if (strpos($request_path, '.php') !== false) {
    // File path with .php
    if (file_exists($file_path)) {
        $_SERVER['SCRIPT_FILENAME'] = $file_path;
        require $file_path;
        return true;
    }
}

// Default fallback: serve homepage
require $document_root . '/index.php';
return true;
