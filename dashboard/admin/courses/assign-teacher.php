<?php
// /dashboard/admin/courses/assign-teacher.php

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

// --- Assignment Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = filter_input(INPUT_POST, 'teacher_id', FILTER_SANITIZE_NUMBER_INT);
    // Use NULL if "None" is selected
    $teacher_id_to_save = ($teacher_id == 0) ? null : $teacher_id;

    // --- PLACEHOLDER LOGIC ---
    // $stmt = $pdo->prepare("UPDATE Courses SET teacher_id = ? WHERE id = ?");
    // $stmt->execute([$teacher_id_to_save, $course_id]);
    
    $_SESSION['success_message'] = "Teacher assigned successfully! (Simulated)";
    redirect('dashboard/admin/courses/list-courses.php');
}
// --- End Processing ---


// --- Fetch Course Data (GET) ---
// $stmt = $pdo->prepare("SELECT course_name, teacher_id FROM Courses WHERE id = ?");
// $stmt->execute([$course_id]);
// $course = $stmt->fetch();
$course = [
    'course_name' => 'Computer Science', 'teacher_id' => 2
];

if (!$course) {
    $_SESSION['error_message'] = "Course not found.";
    redirect('dashboard/admin/courses/list-courses.php');
}

// --- Fetch all teachers for dropdown ---
// $teachers = $pdo->query("SELECT id, first_name, last_name FROM Users WHERE role = 'teacher' ORDER BY last_name")->fetchAll();
$teachers = [
    ['id' => 2, 'first_name' => 'Dr. Alan', 'last_name' => 'Smith'],
    ['id' => 5, 'first_name' => 'Prof. Emily', 'last_name' => 'White'],
    ['id' => 6, 'first_name' => 'Mr. John', 'last_name' => 'Davis'],
];
// --- End Fetch ---

$page_title = "Assign Teacher to " . htmlspecialchars($course['course_name']);
require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><?php echo $page_title; ?></h4>
            </div>
            <div class="card-body">
                
                <form action="assign-teacher.php?id=<?php echo $course_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Select Head Teacher</label>
                        <select class="form-select" id="teacher_id" name="teacher_id" required>
                            <option value="0">-- None (Unassign) --</option>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?php echo $teacher['id']; ?>" <?php if ($course['teacher_id'] == $teacher['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text">This assigns a teacher as the head of the entire course/program.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Assignment</button>
                    <a href="list-courses.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>