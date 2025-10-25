<?php
// /dashboard/admin/users/delete-user.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);
$admin_user = get_session_user();

// Get user ID from URL
$user_id_to_delete = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// --- Deletion Logic ---
if (!$user_id_to_delete) {
    $_SESSION['error_message'] = "Invalid user ID.";
    redirect('dashboard/admin/users/list-users.php');
}

// Prevent admin from deleting themselves
if ($user_id_to_delete == $admin_user['id']) {
    $_SESSION['error_message'] = "You cannot delete your own account.";
    redirect('dashboard/admin/users/list-users.php');
}

// --- PLACEHOLDER LOGIC ---
// In a real app, you would:
// 1. Check for related records (e.g., is this a teacher assigned to courses?)
//    You might need to "soft delete" or reassign content first.
// 2. Perform the deletion
// $stmt = $pdo->prepare("DELETE FROM Users WHERE id = ?");
// $stmt->execute([$user_id_to_delete]);

// if ($stmt->rowCount() > 0) {
//    $_SESSION['success_message'] = "User deleted successfully. (Simulated)";
// } else {
//    $_SESSION['error_message'] = "User not found or already deleted.";
// }

$_SESSION['success_message'] = "User (ID: $user_id_to_delete) deleted successfully. (Simulated)";
redirect('dashboard/admin/users/list-users.php');
?>