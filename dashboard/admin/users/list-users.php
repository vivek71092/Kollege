<?php
// /dashboard/admin/users/list-users.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Manage Users";
$user = get_session_user();

// --- Placeholder Data ---
// $sql = "SELECT id, first_name, last_name, email, role, status, created_at FROM Users ORDER BY created_at DESC";
// $users = $pdo->query($sql)->fetchAll();
$users = [
    ['id' => 1, 'first_name' => 'Admin', 'last_name' => 'User', 'email' => 'admin@kollege.ct.ws', 'role' => 'admin', 'status' => 'active', 'created_at' => '2025-10-01 08:00:00'],
    ['id' => 2, 'first_name' => 'Dr. Alan', 'last_name' => 'Smith', 'email' => 'alan.smith@kollege.ct.ws', 'role' => 'teacher', 'status' => 'active', 'created_at' => '2025-10-02 09:00:00'],
    ['id' => 10, 'first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice@example.com', 'role' => 'student', 'status' => 'active', 'created_at' => '2025-10-20 10:00:00'],
    ['id' => 11, 'first_name' => 'Bob', 'last_name' => 'Johnson', 'email' => 'bob@example.com', 'role' => 'student', 'status' => 'pending', 'created_at' => '2025-10-21 11:00:00'],
];
// --- End Placeholder Data ---

require_once '../../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">User Management</h4>
        <a href="add-user.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New User
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><span class="badge bg-primary"><?php echo ucfirst($u['role']); ?></span></td>
                                <td>
                                    <?php if ($u['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo format_date($u['created_at'], 'M d, Y'); ?></td>
                                <td class="actions-cell">
                                    <a href="edit-user.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#confirmModal" 
                                            data-title="Delete User" 
                                            data-body="Are you sure you want to delete this user (<?php echo htmlspecialchars($u['email']); ?>)? This action cannot be undone."
                                            data-confirm-url="delete-user.php?id=<?php echo $u['id']; ?>">
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
$page_scripts = ['public/js/confirm-modal.js']; // You'll need to create this simple JS file
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