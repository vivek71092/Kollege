<?php
// /dashboard/admin/courses/edit-course.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

// Get course ID from URL
$course_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$course_id) {
    $_SESSION['error_message'] = "Invalid course ID.";
    redirect('dashboard/admin/courses/list-courses.php');
}

// --- Edit Course Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = sanitize_input($_POST['course_name']);
    $course_code = sanitize_input($_POST['course_code']);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_SANITIZE_NUMBER_INT);
    $description = sanitize_input($_POST['description']);
    $status = sanitize_input($_POST['status']);

    // --- PLACEHOLDER LOGIC ---
    // $stmt = $pdo->prepare("UPDATE Courses SET course_code = ?, course_name = ?, description = ?, semester = ?, status = ? WHERE id = ?");
    // $stmt->execute([$course_code, $course_name, $description, $semester, $status, $course_id]);
    
    $_SESSION['success_message'] = "Course updated successfully! (Simulated)";
    redirect('dashboard/admin/courses/list-courses.php');
}
// --- End Processing ---


// --- Fetch Course Data (GET) ---
// $stmt = $pdo->prepare("SELECT * FROM Courses WHERE id = ?");
// $stmt->execute([$course_id]);
// $course = $stmt->fetch();
$course = [
    'id' => $course_id, 'course_code' => 'CS', 'course_name' => 'Computer Science', 'semester' => 8, 'status' => 'active', 'description' => 'The study of computation.'
];

if (!$course) {
    $_SESSION['error_message'] = "Course not found.";
    redirect('dashboard/admin/courses/list-courses.php');
}
// --- End Fetch ---

$page_title = "Edit Course: " . htmlspecialchars($course['course_name']);
require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><?php echo $page_title; ?></h4>
            </div>
            <div class="card-body">
                
                <form action="edit-course.php?id=<?php echo $course_id; ?>" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label">Total Semesters</label>
                            <input type="number" class="form-control" id="semester" name="semester" min="1" max="10" value="<?php echo htmlspecialchars($course['semester']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($course['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php if ($course['status'] == 'active') echo 'selected'; ?>>Active</option>
                            <option value="inactive" <?php if ($course['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <a href="list-courses.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>