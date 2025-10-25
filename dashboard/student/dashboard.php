<?php
// /dashboard/student/dashboard.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "Student Dashboard";
$user = get_session_user(); // Get user info

// --- Placeholder Data ---
// In a real app, you would query the database using $user['id']
$student_id = $user['id'];

// Example: Fetch course count
// $course_count = $pdo->query("SELECT COUNT(*) FROM Enrollments WHERE student_id = $student_id")->fetchColumn();
$course_count = 3;

// Example: Fetch upcoming assignments
// $stmt = $pdo->prepare("SELECT a.title, a.due_date, s.subject_name FROM Assignments a JOIN Subjects s ON a.subject_id = s.id JOIN Enrollments e ON s.id = e.subject_id WHERE e.student_id = ? AND a.due_date > NOW() ORDER BY a.due_date ASC LIMIT 3");
// $stmt->execute([$student_id]);
// $upcoming_assignments = $stmt->fetchAll();
$upcoming_assignments = [
    ['subject_name' => 'Web Development', 'title' => 'Project Phase 1', 'due_date' => '2025-10-28 23:59:00'],
    ['subject_name' => 'Data Science', 'title' => 'Analysis Report', 'due_date' => '2025-10-30 23:59:00']
];

// Example: Fetch recent announcements
// $recent_announcements = $pdo->query("SELECT title, description, created_date FROM Announcements ORDER BY created_date DESC LIMIT 3")->fetchAll();
$recent_announcements = [
    ['title' => 'Midterm Exams Schedule', 'description' => 'Midterm exams will be held...'],
    ['title' => 'Guest Lecture on AI', 'description' => 'A guest lecture is scheduled...']
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-primary">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Enrolled Courses</h5>
                    <div class="stat-number"><?php echo $course_count; ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-warning">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Pending Assignments</h5>
                    <div class="stat-number"><?php echo count($upcoming_assignments); ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-success">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Overall Attendance</h5>
                    <div class="stat-number">92%</div> </div>
                <div class="stat-card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-info">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Unread Messages</h5>
                    <div class="stat-number">2</div> </div>
                <div class="stat-card-icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i> Upcoming Due Dates</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if (empty($upcoming_assignments)): ?>
                        <div class="list-group-item text-center text-muted">No upcoming assignments.</div>
                    <?php else: ?>
                        <?php foreach ($upcoming_assignments as $assignment): ?>
                            <a href="assignments.php" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($assignment['title']); ?></h6>
                                    <small class="text-danger">Due: <?php echo format_date($assignment['due_date'], 'M d, Y'); ?></small>
                                </div>
                                <p class="mb-1 text-muted"><?php echo htmlspecialchars($assignment['subject_name']); ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="assignments.php" class="btn btn-outline-primary btn-sm">View All Assignments</a>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Recent Announcements</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($recent_announcements as $item): ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($item['title']); ?></strong>
                            <p class="mb-0 small"><?php echo truncate_text(htmlspecialchars($item['description']), 100); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="<?php echo BASE_URL; ?>pages/announcements.php" class="btn btn-outline-primary btn-sm">View All Announcements</a>
            </div>
        </div>
    </div>

</div>

<?php
require_once '../../includes/footer.php';
?>