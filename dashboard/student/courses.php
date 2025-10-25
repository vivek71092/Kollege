<?php
// /dashboard/student/courses.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "My Courses";
$user = get_session_user();
$student_id = $user['id'];

// --- Placeholder Data ---
// $stmt = $pdo->prepare("SELECT s.id, s.subject_name, s.subject_code, c.course_name, CONCAT(u.first_name, ' ', u.last_name) AS teacher_name
//                        FROM Subjects s
//                        JOIN Enrollments e ON s.id = e.subject_id
//                        JOIN Courses c ON s.course_id = c.id
//                        LEFT JOIN Users u ON c.teacher_id = u.id
//                        WHERE e.student_id = ? AND e.status = 'enrolled'");
// $stmt->execute([$student_id]);
// $courses = $stmt->fetchAll();
$courses = [
    ['id' => 1, 'subject_name' => 'Web Development', 'subject_code' => 'CS305', 'course_name' => 'Computer Science', 'teacher_name' => 'Dr. Alan Smith'],
    ['id' => 2, 'subject_name' => 'Data Science', 'subject_code' => 'CS306', 'course_name' => 'Computer Science', 'teacher_name' => 'Prof. Emily White'],
    ['id' => 3, 'subject_name' => 'Business Analytics', 'subject_code' => 'MBA501', 'course_name' => 'Business Administration', 'teacher_name' => 'Mr. John Davis']
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Enrolled Subjects</h4>
    </div>
    <div class="card-body">
        <?php if (empty($courses)): ?>
            <div class="alert alert-info">You are not currently enrolled in any subjects.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm course-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($course['subject_name']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($course['subject_code']); ?></h6>
                                <p class="card-text mb-1">
                                    <small>Program: <?php echo htmlspecialchars($course['course_name']); ?></small>
                                </p>
                                <p class="card-text">
                                    <small>Instructor: <?php echo htmlspecialchars($course['teacher_name']); ?></small>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <a href="view-course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-arrow-right me-2"></i> View Subject
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>

<style>
.course-card {
    transition: all 0.3s ease;
}
.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
}
</style>