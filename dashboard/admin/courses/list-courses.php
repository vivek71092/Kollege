<?php
// /dashboard/admin/courses/list-courses.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Manage Courses (Programs)";
$user = get_session_user();

// --- Placeholder Data ---
// $sql = "SELECT c.id, c.course_code, c.course_name, c.semester, c.status, CONCAT(u.first_name, ' ', u.last_name) AS teacher_name
//         FROM Courses c
//         LEFT JOIN Users u ON c.teacher_id = u.id
//         ORDER BY c.course_name";
// $courses = $pdo->query($sql)->fetchAll();
$courses = [
    ['id' => 1, 'course_code' => 'BBA', 'course_name' => 'Business Administration', 'semester' => 6, 'status' => 'active', 'teacher_name' => 'Mr. John Davis'],
    ['id' => 2, 'course_code' => 'CS', 'course_name' => 'Computer Science', 'semester' => 8, 'status' => 'active', 'teacher_name' => 'Dr. Alan Smith'],
    ['id' => 3, 'course_code' => 'PSY', 'course_name' => 'Psychology', 'semester' => 6, 'status' => 'inactive', 'teacher_name' => null],
];
// --- End Placeholder Data ---

require_once '../../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Course/Program Management</h4>
        <a href="add-course.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Course
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
                        <th>ID</th>
                        <th>Code</th>
                        <th>Course Name</th>
                        <th>Head Teacher</th>
                        <th>Semesters</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No courses found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo $course['id']; ?></td>
                                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td><?php echo $course['teacher_name'] ?? '<span class="text-muted">Not Assigned</span>'; ?></td>
                                <td><?php echo htmlspecialchars($course['semester']); ?></td>
                                <td>
                                    <?php if ($course['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions-cell">
                                    <a href="assign-teacher.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-outline-info" title="Assign Teacher">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    <a href="edit-course.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                            data-title="Delete Course" 
                                            data-body="Are you sure you want to delete this course (<?php echo htmlspecialchars($course['course_name']); ?>)? This will also delete all associated subjects."
                                            data-confirm-url="delete-course.php?id=<?php echo $course['id']; ?>">
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