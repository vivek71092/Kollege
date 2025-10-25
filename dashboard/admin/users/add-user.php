<?php
// /dashboard/admin/users/add-user.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Add New User";
$user = get_session_user();

// --- Add User Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $role = sanitize_input($_POST['role']);
    $status = sanitize_input($_POST['status']);

    if (empty($first_name) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['error_message'] = "Please fill out all required fields.";
    } elseif (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // 1. Check if email already exists
        // $stmt = $pdo->prepare("SELECT id FROM Users WHERE email = ?");
        // $stmt->execute([$email]);
        // if ($stmt->fetch()) {
        //    $_SESSION['error_message'] = "An account with this email already exists.";
        // } else {
        //    // 2. Hash password
        //    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        //    // 3. Insert user
        //    $stmt = $pdo->prepare("INSERT INTO Users (first_name, last_name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        //    $stmt->execute([$first_name, $last_name, $email, $hashed_password, $role, $status]);
        //    $_SESSION['success_message'] = "User ($email) created successfully!";
        //    redirect('dashboard/admin/users/list-users.php');
        // }
        
        $_SESSION['success_message'] = "User ($email) created successfully! (Simulated)";
        redirect('dashboard/admin/users/list-users.php');
    }
    // Redirect back to this page on error
    redirect('dashboard/admin/users/add-user.php');
}
// --- End Processing ---


require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Add New User</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="add-user.php" method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">A valid email is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                        <small class="form-text">Min 8 characters. The user will be prompted to change this.</small>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select a role...</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" selected>Active</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="list-users.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>