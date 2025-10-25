<?php
// /dashboard/teacher/manage-assignments.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];

// Filter by subject if ID is in URL
$subject_filter = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);

// --- Placeholder Data ---
// $sql = "SELECT a.id, a.title, a.due_date, s.subject_name,
//         (SELECT COUNT(*) FROM Submissions sub WHERE sub.assignment_id = a.id) AS total_submissions,
//         (SELECT COUNT(*) FROM Submissions sub WHERE sub.assignment_id = a.id AND sub.status = 'submitted') AS pending_grading
//         FROM Assignments a
//         JOIN Subjects s ON a.subject_id = s.id
//         WHERE a.created_by = ?";
// if ($subject_filter) {
//     $sql .= " AND a.subject_id = $subject_filter";
// }
// $sql .= " ORDER BY a.due_date DESC";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$teacher_id]);
// $assignments = $stmt->fetchAll();
$all_assignments = [
    ['id' => 1, 'title' => 'Project Phase 1', 'due_date' => '2025-10-28 23:59:00', 'subject_name' => 'Web Development', 'total_submissions' => 1, 'pending_grading' => 1],
    ['id' => 2, 'title' => 'HTML/CSS Homepage', 'due_date' => '2025-10-15 23:59:00', 'subject_name' => 'Web Development', 'total_submissions' => 12, 'pending_grading' => 0],
    ['id' => 3, 'title' => 'Analysis Report', 'due_date' => '2025-10-30 23:59:00', 'subject_name' => 'Data Science', 'total_submissions' => 1, 'pending_grading' => 1],
];
// Apply filter
$assignments = $subject_filter ? array_filter($all_assignments, fn($a) => $a['subject_id'] == $subject_filter) : $all_assignments;
// --- End Placeholder Data ---

$page_title = "Manage Assignments";
require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">My Created Assignments</h4>
        <a href="create-assignment.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create New Assignment
        </a>
    </div>
    <div class="card-body">
        
        <?php 
        display_flash_message('success_message', 'alert-success');
        display_flash_message('error_message', 'alert-danger');
        ?>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Due Date</th>
                        <th>Submissions</th>
                        <th>Pending Grading</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No assignments found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['subject_name']); ?></td>
                                <td><?php echo format_date($assignment['due_date']); ?></td>
                                <td><?php echo $assignment['total_submissions']; ?></td>
                                <td>
                                    <?php if ($assignment['pending_grading'] > 0): ?>
                                        <span class="badge bg-warning text-dark"><?php echo $assignment['pending_grading']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success">0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="view-submissions.php?id=<?php echo $assignment['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure? This will delete the assignment and all submissions.');">
                                        <i class="fas fa-trash"></i>
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