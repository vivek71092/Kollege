<?php
// /config.php

// --- Database Connection Details ---
// WARNING: Storing credentials in code is insecure. Use environment variables (.env file) in a real project.
define('DB_HOST', 'sql308.infinityfree.com');
define('DB_USERNAME', 'if0_40212246');
define('DB_PASSWORD', 'Vivek2025'); 
define('DB_NAME', 'if0_40212246_kollege');

// --- System Configuration ---
define('BASE_URL', 'https://kollege.ct.ws/'); // Base URL of the site
define('SITE_NAME', 'Kollege LMS');
define('ADMIN_EMAIL', 'admin@kollege.ct.ws');

// --- Error Handling ---
// Set to 'development' to see errors, 'production' to hide and log them.
define('ENVIRONMENT', 'development'); 

// Include the custom error handler
require_once 'error_handler.php';

// --- Session Management ---
// Set session cookie parameters for security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- PDO Database Connection ---
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                    // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
} catch (PDOException $e) {
    // Use our custom error handler to log this
    log_error($e->getMessage(), __FILE__, __LINE__);
    // Display a user-friendly message
    die("Database connection failed. Please check your configuration or try again later.");
}

?>