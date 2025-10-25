<?php
// /dashboard/admin/settings/email-settings.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Email Settings";
$user = get_session_user();

// --- Settings Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- PLACEHOLDER LOGIC ---
    // Loop and save settings like 'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass'
    // to the `Settings` table.
    
    $_SESSION['success_message'] = "Email settings saved successfully! (Simulated)";
    redirect('dashboard/admin/settings/email-settings.php');
}
// --- End Processing ---


// --- Fetch Current Settings ---
// $settings_raw = $pdo->query("SELECT setting_key, setting_value FROM Settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$settings = [
    'mail_driver' => 'smtp',
    'smtp_host' => 'smtp.example.com',
    'smtp_port' => '587',
    'smtp_user' => 'user@example.com',
    'smtp_pass' => 'password123',
    'smtp_encryption' => 'tls'
];
// --- End Fetch ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Email (SMTP) Settings</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="email-settings.php" method="POST">
                    <div class="mb-3">
                        <label for="mail_driver" class="form-label">Mail Driver</label>
                        <select class="form-select" id="mail_driver" name="mail_driver">
                            <option value="smtp" <?php if ($settings['mail_driver'] == 'smtp') echo 'selected'; ?>>SMTP</option>
                            <option value="mail" <?php if ($settings['mail_driver'] == 'mail') echo 'selected'; ?>>PHP mail()</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="smtp_host" class="form-label">SMTP Host</label>
                        <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                               value="<?php echo htmlspecialchars($settings['smtp_host']); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="smtp_port" class="form-label">SMTP Port</label>
                            <input type="text" class="form-control" id="smtp_port" name="smtp_port" 
                                   value="<?php echo htmlspecialchars($settings['smtp_port']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="smtp_encryption" class="form-label">Encryption</label>
                            <select class="form-select" id="smtp_encryption" name="smtp_encryption">
                                <option value="tls" <?php if ($settings['smtp_encryption'] == 'tls') echo 'selected'; ?>>TLS</option>
                                <option value="ssl" <?php if ($settings['smtp_encryption'] == 'ssl') echo 'selected'; ?>>SSL</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="smtp_user" class="form-label">SMTP Username</label>
                        <input type="text" class="form-control" id="smtp_user" name="smtp_user" 
                               value="<?php echo htmlspecialchars($settings['smtp_user']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="smtp_pass" class="form-label">SMTP Password</label>
                        <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" 
                               value="<?php echo htmlspecialchars($settings['smtp_pass']); ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Email Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>