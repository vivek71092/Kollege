<?php
// /dashboard/admin/subjects/delete-subject.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

// Get subject ID from URL
$subject_id_to_delete = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// --- Deletion Logic ---
if (!$subject_id_to_delete) {
    $_SESSION['error_message'] = "Invalid subject ID.";
    redirect('dashboard/admin/subjects/list-subjects.php');
}

// --- PLACEHOLDER LOGIC ---
// In a real app, you MUST use cascading deletes or manually delete
// all related records from: Enrollments, Attendance, Marks, Notes,
// Assignments, Submissions, ClassSchedule, etc.
//
// $pdo->prepare("DELETE FROM Subjects WHERE id = ?")->execute([$subject_id_to_delete]);

$_SESSION['success_message'] = "Subject (ID: $subject_id_to_delete) and all related data deleted. (Simulated)";
redirect('dashboard/admin/subjects/list-subjects.php');
?>