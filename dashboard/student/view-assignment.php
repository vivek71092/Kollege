<?php
// /dashboard/student/view-assignment.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$user = get_session_user();
$student_id = $user['id'];

// Get assignment ID from URL
$assignment_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$assignment_id) {
    $_SESSION['error_message'] = "Invalid assignment ID.";
    redirect('dashboard/student/assignments.php');
}

// --- Placeholder Data ---
// 1. Fetch assignment details
// $stmt = $pdo->prepare("SELECT a.*, s.subject_name FROM Assignments a JOIN Subjects s ON a.subject_id = s.id WHERE a.id = ?");
// $stmt->execute([$assignment_id]);
// $assignment = $stmt->fetch();
$assignment = [
    'id' => $assignment_id,
    'title' => 'Project Phase 1',
    'description' => 'Create the database schema and authentication system.',
    'instructions' => 'Submit a .sql file for the schema and a .zip of your auth files.',
    'due_date' => '2025-10-28 23:59:00',
    'max_marks' => 50,
    'subject_name' => 'Web Development'
];

// 2. Check for existing submission
// $stmt = $pdo->prepare("SELECT * FROM Submissions WHERE assignment_id = ? AND student_id = ?");
// $stmt->execute([$assignment_id, $student_id]);
// $submission = $stmt->fetch();
$submission = null; // No submission yet
// Example of a graded submission:
// $submission = [
//     'file_path' => 'public/uploads/submissions/student1_proj1.zip',
//     'submission_date' => '2025-10-14 10:00:00',
//     'status' => 'graded',
//     'marks_obtained' => 45,
//     'feedback' => 'Good work. Minor issue in password hashing.'
// ];

$is_overdue = (new DateTime() > new DateTime($assignment['due_date']));
$can_submit = (!$submission && !$is_overdue) || ($submission && $submission['status'] == 'pending_resubmit'); // Example logic
// --- End Placeholder Data ---

$page_title = $assignment['title'];
require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h4 class="mb-0">Assignment Details</h4>
            </div>
            <div class="card-body">
                <h3 class="h5"><?php echo htmlspecialchars($assignment['subject_name']); ?></h3>
                <hr>
                <p><strong>Description:</strong><br> <?php echo nl2br(htmlspecialchars($assignment['description'])); ?></p>
                <p><strong>Instructions:</strong><br> <?php echo nl2br(htmlspecialchars($assignment['instructions'])); ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Due Date:</strong>
                    <span class="text-danger"><?php echo format_date($assignment['due_date']); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Max Marks:</strong>
                    <span><?php echo htmlspecialchars($assignment['max_marks']); ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h4 class="mb-0">Submission Status</h4>
            </div>
            <div class="card-body">
                <?php if ($submission): ?>
                    <h5>Your Submission</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Status:</strong>
                            <span class="badge bg-<?php echo $submission['status'] == 'graded' ? 'success' : 'info'; ?>"><?php echo ucfirst($submission['status']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Submitted On:</strong>
                            <span><?php echo format_date($submission['submission_date']); ?></span>
                        </li>
                        <li class="list-group-item">
                            <strong>File:</strong>
                            <a href="<?php echo htmlspecialchars($submission['file_path']); ?>" download>
                                <?php echo basename($submission['file_path']); ?>
                            </a>
                        </li>
                    </ul>

                    <?php if ($submission['status'] == 'graded'): ?>
                        <h5>Feedback</h5>
                        <div class="alert alert-success">
                            <h4 class="alert-heading">Grade: <?php echo $submission['marks_obtained']; ?> / <?php echo $assignment['max_marks']; ?></h4>
                            <p><?php echo nl2br(htmlspecialchars($submission['feedback'])); ?></p>
                        </div>
                    <?php endif; ?>

                <?php elseif ($is_overdue): ?>
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Past Due Date</h5>
                        <p>The due date for this assignment has passed. Submissions are no longer accepted.</p>
                    </div>

                <?php else: ?>
                    <h5>Submit Your Work</h5>
                    <p>Please upload your assignment file below.</p>
                    <form action="submit-assignment.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">
                        <div class="mb-3">
                            <label for="assignment_file" class="form-label">Assignment File</label>
                            <input class="form-control" type="file" id="assignment_file" name="assignment_file" required>
                            <div class="form-text">Allowed file types: PDF, DOCX, ZIP, SQL. Max size: 10MB.</div>
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments (Optional)</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Assignment</button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>