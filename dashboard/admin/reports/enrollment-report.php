<?php
// /dashboard/admin/reports/enrollment-report.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Enrollment Report";
$user = get_session_user();

// --- Fetch data for filters ---
// $courses = $pdo->query("SELECT id, course_name FROM Courses ORDER BY course_name")->fetchAll();
$courses = [
    ['id' => 1, 'course_name' => 'Business Administration'],
    ['id' => 2, 'course_name' => 'Computer Science'],
];
// $subjects = $pdo->query("SELECT id, subject_name FROM Subjects ORDER BY subject_name")->fetchAll();
$subjects = [
    ['id' => 1, 'subject_name' => 'Web Development'],
    ['id' => 2, 'subject_name' => 'Data Science'],
];
// --- End Fetch ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Generate Enrollment Report</h4>
            </div>
            <div class="card-body">
                <p>Select your criteria to generate a CSV report of student enrollments.</p>
                
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Filter by Course (Optional)</label>
                        <select class="form-select" id="course_id" name="course_id">
                            <option value="">All Courses</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Filter by Subject (Optional)</label>
                        <select class="form-select" id="subject_id" name="subject_id">
                            <option value="">All Subjects</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Filter by Enrollment Status (Optional)</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="enrolled">Enrolled</option>
                            <option value="completed">Completed</option>
                            <option value="withdrawn">Withdrawn</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" disabled>
                        <i class="fas fa-file-csv me-2"></i> Generate Report (Not Implemented)
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>