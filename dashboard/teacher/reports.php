<?php
// /dashboard/teacher/reports.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);

$page_title = "Generate Reports";
$user = get_session_user();
$teacher_id = $user['id'];

// --- Fetch teacher's subjects for dropdown ---
// $stmt = $pdo->prepare("SELECT s.id, s.subject_name FROM Subjects s JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = ?");
// $stmt->execute([$teacher_id]);
// $subjects = $stmt->fetchAll();
$subjects = [
    ['id' => 1, 'subject_name' => 'Web Development'],
    ['id' => 2, 'subject_name' => 'Data Science'],
    ['id' => 3, 'subject_name' => 'Business Analytics'],
];
// --- End Fetch ---

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Reports</h4>
            </div>
            <div class="card-body">
                <p>Select a report to generate. This would typically create a CSV or PDF file.</p>
                
                <form action="#" method="POST" class="border p-3 rounded mb-3">
                    <h5 class="mb-3">Attendance Report</h5>
                    <div class="mb-3">
                        <label for="subject_id_att" class="form-label">Select Subject</label>
                        <select class="form-select" id="subject_id_att" name="subject_id">
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" disabled>Generate (Not Implemented)</button>
                </form>

                <form action="#" method="POST" class="border p-3 rounded">
                    <h5 class="mb-3">Grade Report</h5>
                    <div class="mb-3">
                        <label for="subject_id_marks" class="form-label">Select Subject</label>
                        <select class="form-select" id="subject_id_marks" name="subject_id">
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" disabled>Generate (Not Implemented)</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>