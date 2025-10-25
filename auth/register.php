<?php
// /auth/register.php

require_once '../config.php';
require_once '../functions.php';

// If user is already logged in, redirect to their dashboard
if (is_logged_in()) {
    redirect('dashboard/index.php');
}

$page_title = "Register";

// --- Registration Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Please fill out all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['error_message'] = "An account with this email already exists.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                // As per your plan, email verification is optional. We'll set status to 'active'.
                // If verification was required, you'd set status to 'pending'
                // and send a verification email here.
                $status = 'active'; 
                $role = 'student'; // Self-registration is for students only

                // Insert new user
                $insert_stmt = $pdo->prepare(
                    "INSERT INTO Users (first_name, last_name, email, phone, password, role, status, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
                );
                
                if ($insert_stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password, $role, $status])) {
                    $_SESSION['success_message'] = "Registration successful! You can now log in.";
                    redirect('auth/login.php');
                } else {
                    $_SESSION['error_message'] = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            log_error($e->getMessage(), __FILE__, __LINE__);
            $_SESSION['error_message'] = "A database error occurred. Please try again later.";
        }
    }
    // Reload the page to show the error
    redirect('auth/register.php');
}
// --- End Registration Processing ---

require_once '../includes/header.php';
?>

<div class="container" style="max-width: 600px; margin-top: 5rem; margin-bottom: 5rem;">
    <div class="card shadow-lg border-0">
        <div class="card-body p-4 p-md-5">
            <h2 class="text-center h3 mb-4">Create Student Account</h2>
            
            <?php 
            // Display flash messages
            display_flash_message('error_message', 'alert-danger');
            ?>

            <form action="auth/register.php" method="POST" class="needs-validation" novalidate>
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
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback">Please confirm your password.</div>
                    </div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center p-3 bg-light">
            <p class="mb-0">Already have an account? 
                <a href="auth/login.php">Login here</a>
            </p>
        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>