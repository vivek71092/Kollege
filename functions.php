<?php
// /functions.php

// Note: This file is included by config.php, so $pdo and BASE_URL are available.

/**
 * Redirects to a specified URL.
 * @param string $url The *relative* path from the base URL (e.g., 'auth/login.php').
 */
function redirect($url) {
    header("Location: " . BASE_URL . ltrim($url, '/'));
    exit;
}

/**
 * Sanitizes user input to prevent XSS.
 * @param string $data The input data.
 * @return string The sanitized data.
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Checks if a user is logged in.
 * @return bool True if logged in, false otherwise.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Checks if the logged-in user has a specific role.
 * @param string $role The role to check (e.g., 'admin', 'teacher', 'student').
 * @return bool True if the user has the role, false otherwise.
 */
function check_role($role) {
    return is_logged_in() && isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Restricts access to a page based on role(s).
 * If the user is not logged in, redirects to login.
 * If the user doesn't have the required role, redirects to their dashboard.
 * @param array $roles An array of roles that are allowed access (e.g., ['admin', 'teacher']).
 */
function require_role($roles = []) {
    if (!is_logged_in()) {
        $_SESSION['error_message'] = "You must be logged in to view this page.";
        redirect('auth/login.php');
    }

    if (!empty($roles) && !in_array($_SESSION['role'], $roles)) {
        $_SESSION['error_message'] = "You do not have permission to access this page.";
        // Redirect to their own dashboard index
        redirect('dashboard/index.php');
    }
}

/**
 * Gets data for the currently logged-in user from the session.
 * @return array|null The user's session data, or null if not logged in.
 */
function get_session_user() {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'role' => $_SESSION['role'],
        'email' => $_SESSION['email'],
        'first_name' => $_SESSION['first_name']
    ];
}

/**
 * Truncates text to a specified length and adds an ellipsis.
 * @param string $text The text to truncate.
 * @param int $length The maximum length.
 * @return string The truncated text.
 */
function truncate_text($text, $length = 100) {
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...';
    }
    return $text;
}

/**
 * Formats a date/timestamp.
 * @param string $date The date string (e.g., from MySQL DATETIME).
 * @param string $format The desired output format (e.g., 'M d, Y').
 * @return string The formatted date.
 */
function format_date($date, $format = 'F j, Y, g:i a') {
    if (empty($date) || $date === '0000-00-00 00:00:00') {
        return 'N/A';
    }
    try {
        $timestamp = new DateTime($date);
        return $timestamp->format($format);
    } catch (Exception $e) {
        return 'Invalid Date';
    }
}

/**
 * Displays a session-based flash message (e.g., for success or error).
 * @param string $key The session key for the message (e.g., 'success_message').
 * @param string $class The CSS class for styling (e.g., 'alert-success', 'alert-danger').
 */
function display_flash_message($key, $class = 'alert-info') {
    if (isset($_SESSION[$key])) {
        echo '<div class="alert ' . $class . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION[$key]);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION[$key]);
    }
}
?>