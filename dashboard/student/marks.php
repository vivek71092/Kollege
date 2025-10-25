<?php
// /dashboard/student/marks.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "My Marks & Grades";
$user = get_session_user();
$student_id = $user['id'];

// --- Placeholder Data ---
// $sql = "SELECT m.assignment_marks, m.midterm_marks, m.final_marks, m.total_marks, m.grade, s.subject_name
//         FROM Marks m
//         JOIN Subjects s ON m.subject_id = s.id
//         WHERE m.student_id = ?
//         ORDER BY s.subject_name";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$student_id]);
// $marks = $stmt->fetchAll();
$marks = [
    ['subject_name' => 'Web Development', 'assignment_marks' => 45, 'midterm_marks' => 30, 'final_marks' => null, 'total_marks' => 75, 'grade' => 'A-'],
    ['subject_name' => 'Data Science', 'assignment_marks' => 80, 'midterm_marks' => null, 'final_marks' => null, 'total_marks' => 80, 'grade' => 'A'],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Marks & Grades</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th>Assignment Marks</th>
                        <th>Midterm Marks</th>
                        <th>Final Marks</th>
                        <th>Total Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($marks)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Your marks have not been published yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($marks as $mark): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($mark['subject_name']); ?></strong></td>
                                <td><?php echo $mark['assignment_marks'] ?? '<span class="text-muted">N/A</span>'; ?></td>
                                <td><?php echo $mark['midterm_marks'] ?? '<span class="text-muted">N/A</span>'; ?></td>
                                <td><?php echo $mark['final_marks'] ?? '<span class="text-muted">N/A</span>'; ?></td>
                                <td><strong><?php echo $mark['total_marks'] ?? 'N/A'; ?></strong></td>
                                <td><span class="badge bg-primary fs-6"><?php echo $mark['grade'] ?? 'N/A'; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>