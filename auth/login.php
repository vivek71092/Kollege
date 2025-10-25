<?php
// /auth/login.php

require_once '../config.php';
require_once '../functions.php';

// If user is already logged in, redirect to their dashboard
if (is_logged_in()) {
    redirect('dashboard/index.php');
}

$page_title = "Login";

// --- Login Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Email and password are required.";
    } else {
        try {
            // Find the user by email
            $stmt = $pdo->prepare("SELECT id, first_name, email, password, role, status FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Verify user and password
            if ($user && password_verify($password, $user['password'])) {
                
                // Check if account is active
                if ($user['status'] !== 'active') {
                    $_SESSION['error_message'] = "Your account is pending verification or has been suspended.";
                } else {
                    // --- SUCCESSFUL LOGIN ---
                    session_regenerate_id(true); // Prevent session fixation
                    
                    // Store user data in session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['first_name'] = $user['first_name'];
                    
                    // Redirect to the main dashboard router
                    redirect('dashboard/index.php');
                }
            } else {
                $_SESSION['error_message'] = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            log_error($e->getMessage(), __FILE__, __LINE__);
            $_SESSION['error_message'] = "A database error occurred. Please try again later.";
        }
    }
    // Reload the page to show the error
    redirect('auth/login.php');
}
// --- End Login Processing ---

require_once '../includes/header.php';
?>

<div class="container" style="max-width: 500px; margin-top: 5rem; margin-bottom: 5rem;">
    <div class="card shadow-lg border-0">
        <div class="card-body p-4 p-md-5">
            <h2 class="text-center h3 mb-4">Login to <?php echo SITE_NAME; ?></h2>
            
            <?php 
            // Display flash messages
            display_flash_message('success_message', 'alert-success');
            display_flash_message('error_message', 'alert-danger');
            ?>

            <form action="auth/login.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Please enter your password.</div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
                <div class="text-center">
                    <a href="auth/forgot-password.php" class="form-text">Forgot Password?</a>
                </div>
            </form>
        </div>
        <div class="card-footer text-center p-3 bg-light">
            <p class="mb-0">Don't have an account? 
                <a href="auth/register.php">Register as a Student</a>
            </p>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>