<?php
// /auth/logout.php

// Start the session just to access it
require_once '../config.php';
require_once '../functions.php';

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// To be extra sure, delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the login page
redirect('auth/login.php');
exit;
?>