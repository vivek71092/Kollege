<?php
// /dashboard/student/view-course.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$user = get_session_user();
$student_id = $user['id'];

// Get subject ID from URL
$subject_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$subject_id) {
    $_SESSION['error_message'] = "Invalid subject ID.";
    redirect('dashboard/student/courses.php');
}

// --- Placeholder Data ---
// 1. Verify student is enrolled in this subject
// $stmt = $pdo->prepare("SELECT 1 FROM Enrollments WHERE student_id = ? AND subject_id = ?");
// $stmt->execute([$student_id, $subject_id]);
// if (!$stmt->fetch()) {
//    $_SESSION['error_message'] = "You are not authorized to view this subject.";
//    redirect('dashboard/student/courses.php');
// }

// 2. Fetch subject details
// $stmt = $pdo->prepare("SELECT s.subject_name, s.subject_code, c.description, CONCAT(u.first_name, ' ', u.last_name) AS teacher_name
//                        FROM Subjects s
//                        JOIN Courses c ON s.course_id = c.id
//                        LEFT JOIN Users u ON c.teacher_id = u.id
//                        WHERE s.id = ?");
// $stmt->execute([$subject_id]);
// $subject = $stmt->fetch();
$subject = [
    'subject_name' => 'Web Development', 
    'subject_code' => 'CS305', 
    'description' => 'This course covers the fundamentals of HTML, CSS, JavaScript, PHP, and MySQL.', 
    'teacher_name' => 'Dr. Alan Smith'
];

if (!$subject) {
     $_SESSION['error_message'] = "Subject not found.";
    redirect('dashboard/student/courses.php');
}

// 3. Fetch related notes
// $notes = $pdo->prepare("SELECT id, title, description, upload_date FROM Notes WHERE subject_id = ? ORDER BY upload_date DESC LIMIT 5")->execute([$subject_id])->fetchAll();
$notes = [
    ['id' => 1, 'title' => 'Lecture 1: Intro to HTML', 'description' => 'Basic HTML tags and document structure.', 'upload_date' => '2025-10-01 10:00:00'],
    ['id' => 2, 'title' => 'Lecture 2: CSS Fundamentals', 'description' => 'Selectors, properties, and the box model.', 'upload_date' => '2025-10-03 10:00:00']
];

// 4. Fetch related assignments
// $assignments = $pdo->prepare("SELECT id, title, due_date FROM Assignments WHERE subject_id = ? ORDER BY due_date DESC LIMIT 5")->execute([$subject_id])->fetchAll();
$assignments = [
    ['id' => 1, 'title' => 'Project Phase 1', 'due_date' => '2025-10-28 23:59:00'],
    ['id' => 2, 'title' => 'HTML/CSS Homepage', 'due_date' => '2025-10-15 23:59:00']
];
// --- End Placeholder Data ---

$page_title = $subject['subject_name'];
require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4"><?php echo htmlspecialchars($subject['subject_name']); ?> (<?php echo htmlspecialchars($subject['subject_code']); ?>)</h2>
                <p class="text-muted mb-2">Instructor: <?php echo htmlspecialchars($subject['teacher_name']); ?></p>
                <p><?php echo htmlspecialchars($subject['description']); ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Latest Notes</h5>
                <a href="notes.php?subject_id=<?php echo $subject_id; ?>" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($notes as $note): ?>
                    <a href="notes.php#note-<?php echo $note['id']; ?>" class="list-group-item list-group-item-action">
                        <strong><?php echo htmlspecialchars($note['title']); ?></strong>
                        <p class="mb-0 small text-muted"><?php echo htmlspecialchars($note['description']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Latest Assignments</h5>
                <a href="assignments.php?subject_id=<?php echo $subject_id; ?>" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($assignments as $assignment): ?>
                    <a href="view-assignment.php?id=<?php echo $assignment['id']; ?>" class="list-group-item list-group-item-action">
                        <strong><?php echo htmlspecialchars($assignment['title']); ?></strong>
                        <p class="mb-0 small text-danger">Due: <?php echo format_date($assignment['due_date']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>