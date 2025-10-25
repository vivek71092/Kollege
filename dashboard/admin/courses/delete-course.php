<?php
// /dashboard/admin/courses/delete-course.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

// Get course ID from URL
$course_id_to_delete = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// --- Deletion Logic ---
if (!$course_id_to_delete) {
    $_SESSION['error_message'] = "Invalid course ID.";
    redirect('dashboard/admin/courses/list-courses.php');
}

// --- PLACEHOLDER LOGIC ---
// In a real app, you MUST use cascading deletes or manually delete:
// 1. Enrollments
// 2. Submissions
// 3. Assignments
// 4. Notes
// 5. Subjects
// 6. Finally, the Course
// This is a very destructive action!
//
// $pdo->prepare("DELETE FROM Courses WHERE id = ?")->execute([$course_id_to_delete]);

$_SESSION['success_message'] = "Course (ID: $course_id_to_delete) and all related subjects/data deleted. (Simulated)";
redirect('dashboard/admin/courses/list-courses.php');
?>