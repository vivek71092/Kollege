<?php
// /dashboard/teacher/mark-attendance.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];
$page_title = "Mark Attendance";

// --- Attendance Processing (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_attendance'])) {
    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
    $attendance_date = sanitize_input($_POST['attendance_date']);
    $student_statuses = $_POST['status']; // Array of [student_id => 'present'/'absent']
    $remarks = $_POST['remarks']; // Array of [student_id => 'text']

    // --- PLACEHOLDER LOGIC ---
    // 1. Verify teacher owns this subject_id.
    // 2. Loop through $student_statuses
    // 3. Use `INSERT ... ON DUPLICATE KEY UPDATE` to save/update attendance for that date.
    // foreach ($student_statuses as $student_id => $status) {
    //    $remark = sanitize_input($remarks[$student_id]);
    //    $stmt = $pdo->prepare("INSERT INTO Attendance (student_id, subject_id, date, status, teacher_id, remarks, created_at) 
    //                         VALUES (?, ?, ?, ?, ?, ?, NOW()) 
    //                         ON DUPLICATE KEY UPDATE status = VALUES(status), remarks = VALUES(remarks)");
    //    $stmt->execute([$student_id, $subject_id, $attendance_date, $status, $teacher_id, $remark]);
    // }
    
    $_SESSION['success_message'] = "Attendance for " . format_date($attendance_date, 'M d, Y') . " saved successfully! (Simulated)";
    redirect('dashboard/teacher/mark-attendance.php?subject_id=' . $subject_id . '&date=' . $attendance_date);
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

// Get selected subject/date from URL (or defaults)
$selected_subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT) ?? $subjects[0]['id'] ?? 0;
$selected_date = sanitize_input($_GET['date'] ?? date('Y-m-d'));

// --- Fetch students for the selected subject ---
// $stmt = $pdo->prepare("SELECT u.id, u.first_name, u.last_name, a.status, a.remarks
//                       FROM Users u
//                       JOIN Enrollments e ON u.id = e.student_id
//                       LEFT JOIN Attendance a ON u.id = a.student_id AND a.subject_id = ? AND a.date = ?
//                       WHERE e.subject_id = ?
//                       ORDER BY u.last_name, u.first_name");
// $stmt->execute([$selected_subject_id, $selected_date, $selected_subject_id]);
// $students = $stmt->fetchAll();
$students = [
    ['id' => 10, 'first_name' => 'Alice', 'last_name' => 'Smith', 'status' => 'present', 'remarks' => ''],
    ['id' => 11, 'first_name' => 'Bob', 'last_name' => 'Johnson', 'status' => 'absent', 'remarks' => 'Sick'],
    ['id' => 12, 'first_name' => 'Charlie', 'last_name' => 'Brown', 'status' => null, 'remarks' => ''],
];
// --- End Fetch ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Mark Class Attendance</h4>
    </div>
    <div class="card-body">

        <?php 
        display_flash_message('success_message', 'alert-success');
        display_flash_message('error_message', 'alert-danger');
        ?>
        
        <form action="mark-attendance.php" method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" onchange="this.form.submit()">
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if ($subject['id'] == $selected_subject_id) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label for="attendance_date" class="form-label">Date</label>
                <input type="date" class="form-control" id="attendance_date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" onchange="this.form.submit()">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Load List</button>
            </div>
        </form>
        
        <hr>

        <?php if (!empty($students)): ?>
            <form action="mark-attendance.php" method="POST">
                <input type="hidden" name="subject_id" value="<?php echo $selected_subject_id; ?>">
                <input type="hidden" name="attendance_date" value="<?php echo $selected_date; ?>">
                
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Student Name</th>
                                <th width="200px">Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): 
                                $status = $student['status'] ?? 'present'; // Default to present
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status[<?php echo $student['id']; ?>]" id="present-<?php echo $student['id']; ?>" value="present" <?php if ($status == 'present') echo 'checked'; ?>>
                                            <label class="form-check-label" for="present-<?php echo $student['id']; ?>">Present</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status[<?php echo $student['id']; ?>]" id="absent-<?php echo $student['id']; ?>" value="absent" <?php if ($status == 'absent') echo 'checked'; ?>>
                                            <label class="form-check-label" for="absent-<?php echo $student['id']; ?>">Absent</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="remarks[<?php echo $student['id']; ?>]" value="<?php echo htmlspecialchars($student['remarks']); ?>" placeholder="Optional remarks...">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="submit_attendance" class="btn btn-primary">Save Attendance</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">No students are enrolled in this subject.</div>
        <?php endif; ?>

    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>