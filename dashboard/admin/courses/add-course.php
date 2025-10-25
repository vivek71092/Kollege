<?php
// /dashboard/admin/courses/add-course.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Add New Course";

// --- Add Course Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = sanitize_input($_POST['course_name']);
    $course_code = sanitize_input($_POST['course_code']);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_SANITIZE_NUMBER_INT);
    $description = sanitize_input($_POST['description']);
    $status = sanitize_input($_POST['status']);

    if (empty($course_name) || empty($course_code) || empty($semester)) {
        $_SESSION['error_message'] = "Please fill out all required fields.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // $stmt = $pdo->prepare("INSERT INTO Courses (course_code, course_name, description, semester, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        // $stmt->execute([$course_code, $course_name, $description, $semester, $status]);
        
        $_SESSION['success_message'] = "Course ($course_name) created successfully! (Simulated)";
        redirect('dashboard/admin/courses/list-courses.php');
    }
    redirect('dashboard/admin/courses/add-course.php');
}
// --- End Processing ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add New Course/Program</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="add-course.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" placeholder="e.g., Computer Science" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" placeholder="e.g., CS" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label">Total Semesters</label>
                            <input type="number" class="form-control" id="semester" name="semester" min="1" max="10" placeholder="e.g., 8" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Course</button>
                    <a href="list-courses.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>