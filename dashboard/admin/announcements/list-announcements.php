<?php
// /dashboard/admin/announcements/list-announcements.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Manage Announcements";
$user = get_session_user();

// --- Placeholder Data ---
// $sql = "SELECT a.id, a.title, a.status, a.priority, a.created_date, CONCAT(u.first_name, ' ', u.last_name) AS author
//         FROM Announcements a
//         JOIN Users u ON a.created_by = u.id
//         ORDER BY a.priority DESC, a.created_date DESC";
// $announcements = $pdo->query($sql)->fetchAll();
$announcements = [
    ['id' => 1, 'title' => 'Midterm Exams Schedule Announced', 'status' => 'published', 'priority' => 1, 'created_date' => '2025-10-20 10:00:00', 'author' => 'Admin User'],
    ['id' => 2, 'title' => 'Guest Lecture on "AI"', 'status' => 'published', 'priority' => 0, 'created_date' => '2025-10-18 15:30:00', 'author' => 'Admin User'],
    ['id' => 3, 'title' => 'System Maintenance (Draft)', 'status' => 'draft', 'priority' => 0, 'created_date' => '2025-10-17 09:00:00', 'author' => 'Admin User'],
];
// --- End Placeholder Data ---

require_once '../../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Announcement Management</h4>
        <a href="add-announcement.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create New Announcement
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
                        <th>Author</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($announcements)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No announcements found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($announcements as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td><?php echo htmlspecialchars($item['author']); ?></td>
                                <td>
                                    <?php if ($item['status'] == 'published'): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['priority'] == 1): ?>
                                        <span class="badge bg-warning text-dark">High</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo format_date($item['created_date']); ?></td>
                                <td class="actions-cell">
                                    <a href="edit-announcement.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                            data-title="Delete Announcement" 
                                            data-body="Are you sure you want to delete this announcement: <?php echo htmlspecialchars($item['title']); ?>?"
                                            data-confirm-url="delete-announcement.php?id=<?php echo $item['id']; ?>">
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