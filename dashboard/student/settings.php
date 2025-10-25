<?php
// /dashboard/student/settings.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "Account Settings";
$user = get_session_user();
$student_id = $user['id'];

// --- Password Change Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Please fill out all password fields.";
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "New passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $_SESSION['error_message'] = "New password must be at least 8 characters long.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // In a real app, you would:
        // 1. Fetch the user's current hashed password
        // $stmt = $pdo->prepare("SELECT password FROM Users WHERE id = ?");
        // $stmt->execute([$student_id]);
        // $hashed_password = $stmt->fetchColumn();
        
        // 2. Verify the current password
        // if (password_verify($current_password, $hashed_password)) {
        //    // 3. Hash the new password
        //    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        //    // 4. Update the password in the database
        //    $update_stmt = $pdo->prepare("UPDATE Users SET password = ? WHERE id = ?");
        //    $update_stmt->execute([$new_hashed_password, $student_id]);
        //    $_SESSION['success_message'] = "Password changed successfully.";
        // } else {
        //    $_SESSION['error_message'] = "Incorrect current password.";
        // }
        
        $_SESSION['success_message'] = "Password changed successfully! (Simulated)";
    }
    redirect('dashboard/student/settings.php');
}
// --- End Processing ---

require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Change Password</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="settings.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback">Please enter your current password.</div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" required>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback">Please confirm your new password.</div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
        
        </div>
</div>

<?php
require_once '../../includes/footer.php';
?>