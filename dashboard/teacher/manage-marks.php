<?php
// /dashboard/teacher/manage-marks.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];
$page_title = "Manage Marks";

// --- Marks Processing (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_marks'])) {
    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
    $student_marks = $_POST['marks']; // Array [student_id => ['midterm' => val, 'final' => val]]

    // --- PLACEHOLDER LOGIC ---
    // 1. Verify teacher owns subject.
    // 2. Loop through $student_marks
    // 3. Use `INSERT ... ON DUPLICATE KEY UPDATE` to save/update marks in the `Marks` table.
    // foreach ($student_marks as $student_id => $marks) {
    //    $midterm = $marks['midterm'] ?: null;
    //    $final = $marks['final'] ?: null;
    //    // (This assumes assignment marks are graded individually)
    //    $total = $midterm + $final; // Add assignment marks in real query
    //
    //    $stmt = $pdo->prepare("INSERT INTO Marks (student_id, subject_id, midterm_marks, final_marks, total_marks, teacher_id) 
    //                         VALUES (?, ?, ?, ?, ?, ?) 
    //                         ON DUPLICATE KEY UPDATE midterm_marks = VALUES(midterm_marks), final_marks = VALUES(final_marks), total_marks = VALUES(total_marks)");
    //    $stmt->execute([$student_id, $subject_id, $midterm, $final, $total, $teacher_id]);
    // }
    
    $_SESSION['success_message'] = "Marks saved successfully! (Simulated)";
    redirect('dashboard/teacher/manage-marks.php?subject_id=' . $subject_id);
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

$selected_subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT) ?? $subjects[0]['id'] ?? 0;

// --- Fetch students and their current marks for the selected subject ---
// $sql = "SELECT u.id, u.first_name, u.last_name, m.assignment_marks, m.midterm_marks, m.final_marks, m.total_marks
//         FROM Users u
//         JOIN Enrollments e ON u.id = e.student_id
//         LEFT JOIN Marks m ON u.id = m.student_id AND m.subject_id = ?
//         WHERE e.subject_id = ?
//         ORDER BY u.last_name, u.first_name";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$selected_subject_id, $selected_subject_id]);
// $students = $stmt->fetchAll();
$students = [
    ['id' => 10, 'first_name' => 'Alice', 'last_name' => 'Smith', 'assignment_marks' => 45, 'midterm_marks' => 30, 'final_marks' => null, 'total_marks' => 75],
    ['id' => 11, 'first_name' => 'Bob', 'last_name' => 'Johnson', 'assignment_marks' => 40, 'midterm_marks' => 25, 'final_marks' => null, 'total_marks' => 65],
];
// --- End Fetch ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Manage Student Marks</h4>
    </div>
    <div class="card-body">

        <?php 
        display_flash_message('success_message', 'alert-success');
        display_flash_message('error_message', 'alert-danger');
        ?>
        
        <form action="manage-marks.php" method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" onchange="this.form.submit()">
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if ($subject['id'] == $selected_subject_id) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Load Student List</button>
            </div>
        </form>
        
        <hr>

        <?php if (!empty($students)): ?>
            <form action="manage-marks.php" method="POST">
                <input type="hidden" name="subject_id" value="<?php echo $selected_subject_id; ?>">
                
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Student Name</th>
                                <th>Assignment Marks (Agg)</th>
                                <th>Midterm Marks</th>
                                <th>Final Marks</th>
                                <th>Total (Auto)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               value="<?php echo htmlspecialchars($student['assignment_marks']); ?>" readonly disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               name="marks[<?php echo $student['id']; ?>][midterm]" 
                                               value="<?php echo htmlspecialchars($student['midterm_marks']); ?>">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               name="marks[<?php echo $student['id']; ?>][final]" 
                                               value="<?php echo htmlspecialchars($student['final_marks']); ?>">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" 
                                               value="<?php echo htmlspecialchars($student['total_marks']); ?>" readonly disabled>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="submit_marks" class="btn btn-primary">Save All Marks</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">No students are enrolled in this subject.</div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>