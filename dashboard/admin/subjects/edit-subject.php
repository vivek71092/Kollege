<?php
// /dashboard/admin/subjects/edit-subject.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

// Get subject ID from URL
$subject_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$subject_id) {
    $_SESSION['error_message'] = "Invalid subject ID.";
    redirect('dashboard/admin/subjects/list-subjects.php');
}

// --- Edit Subject Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = filter_input(INPUT_POST, 'course_id', FILTER_SANITIZE_NUMBER_INT);
    $subject_name = sanitize_input($_POST['subject_name']);
    $subject_code = sanitize_input($_POST['subject_code']);
    $semester = filter_input(INPUT_POST, 'semester', FILTER_SANITIZE_NUMBER_INT);
    $credits = filter_input(INPUT_POST, 'credits', FILTER_SANITIZE_NUMBER_INT);
    $status = sanitize_input($_POST['status']);

    // --- PLACEHOLDER LOGIC ---
    // $stmt = $pdo->prepare("UPDATE Subjects SET course_id = ?, subject_code = ?, subject_name = ?, semester = ?, credits = ?, status = ? WHERE id = ?");
    // $stmt->execute([$course_id, $subject_code, $subject_name, $semester, $credits, $status, $subject_id]);
    
    $_SESSION['success_message'] = "Subject updated successfully! (Simulated)";
    redirect('dashboard/admin/subjects/list-subjects.php');
}
// --- End Processing ---


// --- Fetch Subject Data (GET) ---
// $stmt = $pdo->prepare("SELECT * FROM Subjects WHERE id = ?");
// $stmt->execute([$subject_id]);
// $subject = $stmt->fetch();
$subject = [
    'id' => $subject_id, 'course_id' => 2, 'subject_code' => 'CS305', 'subject_name' => 'Web Development', 'semester' => 3, 'credits' => 3, 'status' => 'active'
];

if (!$subject) {
    $_SESSION['error_message'] = "Subject not found.";
    redirect('dashboard/admin/subjects/list-subjects.php');
}

// --- Fetch Courses for dropdown ---
// $courses = $pdo->query("SELECT id, course_name FROM Courses WHERE status = 'active' ORDER BY course_name")->fetchAll();
$courses = [
    ['id' => 1, 'course_name' => 'Business Administration'],
    ['id' => 2, 'course_name' => 'Computer Science'],
];
// --- End Fetch ---

$page_title = "Edit Subject: " . htmlspecialchars($subject['subject_name']);
require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><?php echo $page_title; ?></h4>
            </div>
            <div class="card-body">
                
                <form action="edit-subject.php?id=<?php echo $subject_id; ?>" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course (Program)</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['id']; ?>" <?php if ($subject['course_id'] == $course['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($course['course_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo htmlspecialchars($subject['subject_name']); ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="subject_code" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="subject_code" name="subject_code" value="<?php echo htmlspecialchars($subject['subject_code']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" id="semester" name="semester" min="1" max="10" value="<?php echo htmlspecialchars($subject['semester']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="credits" class="form-label">Credits</label>
                            <input type="number" class="form-control" id="credits" name="credits" min="1" max="5" value="<?php echo htmlspecialchars($subject['credits']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php if ($subject['status'] == 'active') echo 'selected'; ?>>Active</option>
                            <option value="inactive" <?php if ($subject['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Subject</button>
                    <a href="list-subjects.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>