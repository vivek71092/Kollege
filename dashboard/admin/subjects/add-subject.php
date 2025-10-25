<?php
// /dashboard/admin/subjects/add-subject.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Add New Subject";

// --- Add Subject Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = filter_input(INPUT_POST, 'course_id', FILTER_SANITIZE_NUMBER_INT);
    $subject_name = sanitize_input($_POST['subject_name']);
    $subject_code = sanitize_input($_POST['subject_code']);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_SANITIZE_NUMBER_INT);
    $credits = filter_input(INPUT_POST, 'credits', FILTER_SANITIZE_NUMBER_INT);
    $status = sanitize_input($_POST['status']);

    if (empty($course_id) || empty($subject_name) || empty($subject_code) || empty($semester)) {
        $_SESSION['error_message'] = "Please fill out all required fields.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // $stmt = $pdo->prepare("INSERT INTO Subjects (course_id, subject_code, subject_name, semester, credits, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        // $stmt->execute([$course_id, $subject_code, $subject_name, $semester, $credits, $status]);
        
        $_SESSION['success_message'] = "Subject ($subject_name) created successfully! (Simulated)";
        redirect('dashboard/admin/subjects/list-subjects.php');
    }
    redirect('dashboard/admin/subjects/add-subject.php');
}
// --- End Processing ---

// --- Fetch Courses for dropdown ---
// $courses = $pdo->query("SELECT id, course_name FROM Courses WHERE status = 'active' ORDER BY course_name")->fetchAll();
$courses = [
    ['id' => 1, 'course_name' => 'Business Administration'],
    ['id' => 2, 'course_name' => 'Computer Science'],
];
// --- End Fetch ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add New Subject</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="add-subject.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course (Program)</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <option value="">Select a parent course...</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['id']; ?>">
                                    <?php echo htmlspecialchars($course['course_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a course.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="e.g., Web Development" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="subject_code" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="e.g., CS305" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" id="semester" name="semester" min="1" max="10" placeholder="e.g., 3" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="credits" class="form-label">Credits</label>
                            <input type="number" class="form-control" id="credits" name="credits" min="1" max="5" placeholder="e.g., 3">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Subject</button>
                    <a href="list-subjects.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>