<?php
// /dashboard/student/assignments.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "My Assignments";
$user = get_session_user();
$student_id = $user['id'];

// --- Placeholder Data ---
// $sql = "SELECT a.id, a.title, a.due_date, s.subject_name, sub.status, sub.marks_obtained, a.max_marks
//         FROM Assignments a
//         JOIN Subjects s ON a.subject_id = s.id
//         JOIN Enrollments e ON s.id = e.subject_id
//         LEFT JOIN Submissions sub ON a.id = sub.assignment_id AND sub.student_id = ?
//         WHERE e.student_id = ?
//         ORDER BY a.due_date DESC";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$student_id, $student_id]);
// $assignments = $stmt->fetchAll();
$assignments = [
    ['id' => 1, 'title' => 'Project Phase 1', 'due_date' => '2025-10-28 23:59:00', 'subject_name' => 'Web Development', 'status' => null, 'marks_obtained' => null, 'max_marks' => 50],
    ['id' => 2, 'title' => 'HTML/CSS Homepage', 'due_date' => '2025-10-15 23:59:00', 'subject_name' => 'Web Development', 'status' => 'graded', 'marks_obtained' => 45, 'max_marks' => 50],
    ['id' => 3, 'title' => 'Analysis Report', 'due_date' => '2025-10-30 23:59:00', 'subject_name' => 'Data Science', 'status' => 'submitted', 'marks_obtained' => null, 'max_marks' => 100],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Assignments</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th>Assignment Title</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Marks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No assignments found for your courses.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($assignment['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                                <td><?php echo format_date($assignment['due_date']); ?></td>
                                <td>
                                    <?php 
                                    $status = $assignment['status'];
                                    $due_date = new DateTime($assignment['due_date']);
                                    $now = new DateTime();
                                    
                                    if ($status === 'graded') {
                                        echo '<span class="badge bg-success">Graded</span>';
                                    } elseif ($status === 'submitted') {
                                        echo '<span class="badge bg-info">Submitted</span>';
                                    } elseif ($now > $due_date) {
                                        echo '<span class="badge bg-danger">Overdue</span>';
                                    } else {
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($assignment['marks_obtained'] !== null) {
                                        echo '<strong>' . $assignment['marks_obtained'] . ' / ' . $assignment['max_marks'] . '</strong>';
                                    } else {
                                        echo '<span class="text-muted">N/A</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="view-assignment.php?id=<?php echo $assignment['id']; ?>" class="btn btn-primary btn-sm">
                                        View Details
                                    </a>
                                </td>
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