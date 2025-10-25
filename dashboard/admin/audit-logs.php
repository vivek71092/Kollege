<?php
// /dashboard/admin/audit-logs.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Audit Logs";
$user = get_session_user();

// --- Placeholder Data ---
// $sql = "SELECT al.id, al.action, al.table_name, al.record_id, al.details, al.timestamp, CONCAT(u.first_name, ' ', u.last_name) AS user_name
//         FROM AuditLogs al
//         JOIN Users u ON al.user_id = u.id
//         ORDER BY al.timestamp DESC
//         LIMIT 100"; // Paginate this in a real app
// $logs = $pdo->query($sql)->fetchAll();
$logs = [
    ['id' => 1, 'action' => 'UPDATE', 'table_name' => 'Users', 'record_id' => 10, 'details' => 'Changed status from pending to active', 'timestamp' => '2025-10-23 08:00:00', 'user_name' => 'Admin User'],
    ['id' => 2, 'action' => 'CREATE', 'table_name' => 'Assignments', 'record_id' => 3, 'details' => 'Created new assignment: Analysis Report', 'timestamp' => '2025-10-22 15:00:00', 'user_name' => 'Dr. Alan Smith'],
    ['id' => 3, 'action' => 'LOGIN', 'table_name' => 'Users', 'record_id' => 10, 'details' => 'User login successful', 'timestamp' => '2025-10-22 14:30:00', 'user_name' => 'Alice Smith'],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">System Audit Logs</h4>
    </div>
    <div class="card-body">
        
        <p>Showing the 100 most recent actions taken in the system.</p>
        
        <div class="table-responsive">
            <table class="table table-hover table-sm data-table">
                <thead class="table-light">
                    <tr>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Record ID</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No audit logs found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo format_date($log['timestamp']); ?></td>
                                <td><?php echo htmlspecialchars($log['user_name']); ?></td>
                                <td>
                                    <?php 
                                    $action = $log['action'];
                                    $class = 'secondary';
                                    if ($action == 'CREATE') $class = 'success';
                                    if ($action == 'UPDATE') $class = 'primary';
                                    if ($action == 'DELETE') $class = 'danger';
                                    if ($action == 'LOGIN') $class = 'info';
                                    echo "<span class='badge bg-$class'>$action</span>";
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($log['table_name']); ?></td>
                                <td><?php echo htmlspecialchars($log['record_id']); ?></td>
                                <td><?php echo htmlspecialchars($log['details']); ?></td>
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