<?php
// /dashboard/teacher/dashboard.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);

$page_title = "Teacher Dashboard";
$user = get_session_user();
$teacher_id = $user['id'];

// --- Placeholder Data ---
// In a real app, you would query the database using $teacher_id

// 1. Get stats
// $course_count = $pdo->query("SELECT COUNT(*) FROM Courses WHERE teacher_id = $teacher_id")->fetchColumn();
$course_count = 3;
// $student_count = $pdo->query("SELECT COUNT(DISTINCT e.student_id) FROM Enrollments e JOIN Subjects s ON e.subject_id = s.id JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = $teacher_id")->fetchColumn();
$student_count = 45;

// 2. Get recent submissions
// $new_submissions = $pdo->prepare("SELECT sub.id, u.first_name, u.last_name, a.title FROM Submissions sub JOIN Users u ON sub.student_id = u.id JOIN Assignments a ON sub.assignment_id = a.id JOIN Subjects s ON a.subject_id = s.id JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = ? AND sub.status = 'submitted' ORDER BY sub.submission_date DESC LIMIT 5");
// $new_submissions->execute([$teacher_id]);
$new_submissions = [
    ['id' => 1, 'first_name' => 'Alice', 'last_name' => 'Smith', 'title' => 'Project Phase 1'],
    ['id' => 2, 'first_name' => 'Bob', 'last_name' => 'Johnson', 'title' => 'Analysis Report'],
];

// 3. Get today's schedule
// $today = date('l'); // e.g., 'Monday'
// $schedule_today = $pdo->prepare("SELECT cs.start_time, cs.end_time, s.subject_name, cs.classroom FROM ClassSchedule cs JOIN Subjects s ON cs.subject_id = s.id JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = ? AND cs.day_of_week = ? ORDER BY cs.start_time ASC");
// $schedule_today->execute([$teacher_id, $today]);
$schedule_today = [
    ['start_time' => '09:00:00', 'end_time' => '11:00:00', 'subject_name' => 'Web Development', 'classroom' => 'Room 101'],
    ['start_time' => '13:00:00', 'end_time' => '15:00:00', 'subject_name' => 'Business Analytics', 'classroom' => 'Room 205'],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-primary">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>My Courses</h5>
                    <div class="stat-number"><?php echo $course_count; ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-success">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Total Students</h5>
                    <div class="stat-number"><?php echo $student_count; ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-warning">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>New Submissions</h5>
                    <div class="stat-number"><?php echo count($new_submissions); ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-inbox"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card border-info">
            <div class="card-body">
                <div class="stat-card-info">
                    <h5>Classes Today</h5>
                    <div class="stat-number"><?php echo count($schedule_today); ?></div>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-inbox me-2"></i> New Submissions to Grade</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if (empty($new_submissions)): ?>
                        <div class="list-group-item text-center text-muted">No new submissions.</div>
                    <?php else: ?>
                        <?php foreach ($new_submissions as $sub): ?>
                            <a href="grade-assignment.php?id=<?php echo $sub['id']; ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($sub['first_name'] . ' ' . $sub['last_name']); ?></h6>
                                    <small>needs grading</small>
                                </div>
                                <p class="mb-1 text-muted"><?php echo htmlspecialchars($sub['title']); ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="manage-assignments.php" class="btn btn-outline-primary btn-sm">View All Assignments</a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-day me-2"></i> Today's Schedule</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if (empty($schedule_today)): ?>
                        <li class="list-group-item text-center text-muted">No classes scheduled for today.</li>
                    <?php else: ?>
                        <?php foreach ($schedule_today as $class): 
                            $start = (new DateTime($class['start_time']))->format('h:i A');
                            $end = (new DateTime($class['end_time']))->format('h:i A');
                        ?>
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <strong><?php echo "$start - $end"; ?></strong>
                                    <span class="text-muted"><?php echo htmlspecialchars($class['classroom']); ?></span>
                                </div>
                                <div><?php echo htmlspecialchars($class['subject_name']); ?></div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="schedule.php" class="btn btn-outline-primary btn-sm">View Full Schedule</a>
            </div>
        </div>
    </div>

</div>

<?php
require_once '../../includes/footer.php';
?>