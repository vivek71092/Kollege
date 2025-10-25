<?php
// /dashboard/index.php

// Load core files
require_once '../config.php';
require_once '../functions.php';

// Check if the user is logged in.
// This auth check is crucial for the redirector.
require_once '../auth/check_auth.php';

// Get the user's role from the session
$role = $_SESSION['role'] ?? 'guest';

// Redirect based on role
switch ($role) {
    case 'admin':
        redirect('dashboard/admin/dashboard.php');
        break;
    case 'teacher':
        redirect('dashboard/teacher/dashboard.php');
        break;
    case 'student':
        redirect('dashboard/student/dashboard.php');
        break;
    default:
        // If role is unknown or guest, log them out and send to login
        redirect('auth/logout.php');
        break;
}

// No HTML is ever rendered by this file.
exit;
?>