<?php
// /dashboard/admin/settings/backup.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Backup & Maintenance";
$user = get_session_user();

// --- Backup Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['run_backup'])) {
    // --- PLACEHOLDER LOGIC ---
    // A real backup script would:
    // 1. Use `mysqldump` command via exec() or a PHP library
    // 2. Create a .sql file in a secure, non-public directory
    // 3. Log the action to `AuditLogs`
    // 4. Optionally, offer the file for download.
    
    $_SESSION['success_message'] = "Database backup successfully created! (Simulated)";
    redirect('dashboard/admin/settings/backup.php');
}
// --- End Processing ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Database Backup</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <p>Click the button below to generate a full backup of the website database. This may take a few moments.</p>
                <p>Backups are stored in a secure location on the server. Please download them periodically for off-site storage.</p>
                
                <form action="backup.php" method="POST">
                    <button type="submit" name="run_backup" class="btn btn_primary">
                        <i class="fas fa-database me-2"></i> Run Database Backup Now
                    </button>
                </form>

                <hr class="my-4">
                
                <h5 class="mb-3">Recent Backups</h5>
                <p class="text-muted">(This is a placeholder. A real system would list recent backup files here.)</p>
                <ul class="list-group">
                    <li class="list-group-item">backup-2025-10-22.sql</li>
                    <li class="list-group-item">backup-2025-10-21.sql</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>