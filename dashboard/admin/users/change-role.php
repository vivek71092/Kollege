<?php
// /dashboard/admin/users/change-role.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);
$admin_user = get_session_user();

// Get data from POST (assuming a form submission)
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$new_role = sanitize_input($_POST['new_role']);
$allowed_roles = ['student', 'teacher', 'admin'];

// --- Logic ---
if (empty($user_id) || empty($new_role) || !in_array($new_role, $allowed_roles)) {
    $_SESSION['error_message'] = "Invalid user ID or role.";
    redirect('dashboard/admin/users/list-users.php');
}

if ($user_id == $admin_user['id']) {
    $_SESSION['error_message'] = "You cannot change your own role.";
    redirect('dashboard/admin/users/list-users.php');
}

// --- PLACEHOLDER LOGIC ---
// $stmt = $pdo->prepare("UPDATE Users SET role = ? WHERE id = ?");
// $stmt->execute([$new_role, $user_id]);

$_SESSION['success_message'] = "User's role updated to '$new_role'. (Simulated)";
redirect('dashboard/admin/users/list-users.php');
?>