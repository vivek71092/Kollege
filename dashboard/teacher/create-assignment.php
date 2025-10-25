<?php
// /dashboard/teacher/create-assignment.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];

// --- Assignment Creation Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $due_date = sanitize_input($_POST['due_date']);
    $max_marks = filter_input(INPUT_POST, 'max_marks', FILTER_SANITIZE_NUMBER_INT);

    if (empty($subject_id) || empty($title) || empty($due_date) || empty($max_marks)) {
        $_SESSION['error_message'] = "Please fill out all required fields.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // 1. Verify teacher owns this subject_id
        // 2. Insert into `Assignments` table
        // $stmt = $pdo->prepare("INSERT INTO Assignments (subject_id, title, description, due_date, max_marks, created_by, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'published', NOW())");
        // $stmt->execute([$subject_id, $title, $description, $due_date, $max_marks, $teacher_id]);
        
        $_SESSION['success_message'] = "Assignment created successfully! (Simulated)";
        redirect('dashboard/teacher/manage-assignments.php');
    }
    // Redirect back on error
    redirect('dashboard/teacher/create-assignment.php');
}
// --- End Processing ---


// --- Fetch teacher's subjects for dropdown ---
// $stmt = $pdo->prepare("SELECT s.id, s.subject_name FROM Subjects s JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = ?");
// $stmt->execute([$teacher_id]);
// $subjects = $stmt->fetchAll();
$subjects = [
    ['id' => 1, 'subject_name' => 'Web Development'],
    ['id' => 2, 'subject_name' => 'Data Science'],
    ['id' => 3, 'subject_name' => 'Business Analytics'],
];
// Pre-select subject if ID is in URL
$selected_subject = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
// --- End Fetch ---

$page_title = "Create Assignment";
require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Create New Assignment</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="create-assignment.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="">Select a subject...</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo $subject['id']; ?>" <?php if ($subject['id'] == $selected_subject) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($subject['subject_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a subject.</div>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Assignment Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <div class="invalid-feedback">Please provide a title.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Instructions</label>
                        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
                            <div class="invalid-feedback">Please set a due date.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="max_marks" class="form-label">Max Marks</label>
                            <input type="number" class="form-control" id="max_marks" name="max_marks" min="1" required>
                            <div class="invalid-feedback">Please set max marks.</div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Assignment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>