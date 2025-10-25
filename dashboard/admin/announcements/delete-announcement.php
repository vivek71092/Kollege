<?php
// /dashboard/admin/announcements/delete-announcement.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

// Get announcement ID from URL
$announcement_id_to_delete = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// --- Deletion Logic ---
if (!$announcement_id_to_delete) {
    $_SESSION['error_message'] = "Invalid announcement ID.";
    redirect('dashboard/admin/announcements/list-announcements.php');
}

// --- PLACEHOLDER LOGIC ---
// $stmt = $pdo->prepare("DELETE FROM Announcements WHERE id = ?");
// $stmt->execute([$announcement_id_to_delete]);

$_SESSION['success_message'] = "Announcement (ID: $announcement_id_to_delete) deleted successfully. (Simulated)";
redirect('dashboard/admin/announcements/list-announcements.php');
?>