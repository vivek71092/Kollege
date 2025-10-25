<?php
// /dashboard/admin/settings/system-settings.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "System Settings";
$user = get_session_user();

// --- Settings Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- PLACEHOLDER LOGIC ---
    // In a real app, you would loop through $_POST and update
    // each key in the `Settings` table.
    // e.g.,
    // $settings_to_update = [
    //     'site_name' => sanitize_input($_POST['site_name']),
    //     'admin_email' => sanitize_input($_POST['admin_email']),
    //     'maintenance_mode' => sanitize_input($_POST['maintenance_mode'])
    // ];
    // foreach ($settings_to_update as $key => $value) {
    //    $stmt = $pdo->prepare("UPDATE Settings SET setting_value = ? WHERE setting_key = ?");
    //    $stmt->execute([$value, $key]);
    // }
    
    $_SESSION['success_message'] = "System settings updated successfully! (Simulated)";
    redirect('dashboard/admin/settings/system-settings.php');
}
// --- End Processing ---


// --- Fetch Current Settings ---
// $settings_raw = $pdo->query("SELECT setting_key, setting_value FROM Settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$settings = [
    'site_name' => 'Kollege LMS',
    'admin_email' => 'admin@kollege.ct.ws',
    'maintenance_mode' => '0' // 0 for off, 1 for on
];
// --- End Fetch ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">General System Settings</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="system-settings.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" 
                               value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email" 
                               value="<?php echo htmlspecialchars($settings['admin_email']); ?>" required>
                        <small class="form-text">This email is used for system notifications.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="maintenance_mode" class="form-label">Maintenance Mode</label>
                        <select class="form-select" id="maintenance_mode" name="maintenance_mode" required>
                            <option value="0" <?php if ($settings['maintenance_mode'] == '0') echo 'selected'; ?>>Off (Live)</option>
                            <option value="1" <?php if ($settings['maintenance_mode'] == '1') echo 'selected'; ?>>On (Site disabled for users)</option>
                        </select>
                    </div>
                    
                    <hr class="my-4">
                    
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>