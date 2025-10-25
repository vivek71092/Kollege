<?php
// /dashboard/admin/subjects/list-subjects.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Manage Subjects";
$user = get_session_user();

// --- Placeholder Data ---
// $sql = "SELECT s.id, s.subject_code, s.subject_name, s.semester, c.course_name, s.status
//         FROM Subjects s
//         JOIN Courses c ON s.course_id = c.id
//         ORDER BY c.course_name, s.semester, s.subject_name";
// $subjects = $pdo->query($sql)->fetchAll();
$subjects = [
    ['id' => 1, 'subject_code' => 'CS305', 'subject_name' => 'Web Development', 'semester' => 3, 'course_name' => 'Computer Science', 'status' => 'active'],
    ['id' => 2, 'subject_code' => 'CS306', 'subject_name' => 'Data Science', 'semester' => 3, 'course_name' => 'Computer Science', 'status' => 'active'],
    ['id' => 3, 'subject_code' => 'MBA501', 'subject_name' => 'Business Analytics', 'semester' => 1, 'course_name' => 'Business Administration', 'status' => 'active'],
    ['id' => 4, 'subject_code' => 'CS101', 'subject_name' => 'Intro to Programming', 'semester' => 1, 'course_name' => 'Computer Science', 'status' => 'inactive'],
];
// --- End Placeholder Data ---

require_once '../../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Subject Management</h4>
        <a href="add-subject.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Subject
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
                        <th>Code</th>
                        <th>Subject Name</th>
                        <th>Course (Program)</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subjects)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No subjects found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($subject['course_name']); ?></td>
                                <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                                <td>
                                    <?php if ($subject['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions-cell">
                                    <a href="edit-subject.php?id=<?php echo $subject['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                            data-title="Delete Subject" 
                                            data-body="Are you sure you want to delete this subject (<?php echo htmlspecialchars($subject['subject_name']); ?>)? This will also delete all associated notes, assignments, and grades."
                                            data-confirm-url="delete-subject.php?id=<?php echo $subject['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
// Add the JS to make the confirmation modal dynamic
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var confirmModal = document.getElementById('confirmModal');
    if(confirmModal) {
        confirmModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var title = button.getAttribute('data-title');
            var body = button.getAttribute('data-body');
            var url = button.getAttribute('data-confirm-url');
            
            confirmModal.querySelector('.modal-title').textContent = title;
            confirmModal.querySelector('.modal-body').textContent = body;
            confirmModal.querySelector('#confirmModalButton').href = url;
        });
    }
});
</script>

<?php
require_once '../../../includes/footer.php';
?>