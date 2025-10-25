<?php
// /dashboard/admin/users/edit-user.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);
$user = get_session_user();

// Get user ID from URL
$user_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$user_id) {
    $_SESSION['error_message'] = "Invalid user ID.";
    redirect('dashboard/admin/users/list-users.php');
}

// --- Edit User Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $phone = sanitize_input($_POST['phone']);
    $role = sanitize_input($_POST['role']);
    $status = sanitize_input($_POST['status']);
    // Note: Don't update email or password here to keep it simple
    // Password reset should be a separate function.

    // --- PLACEHOLDER LOGIC ---
    // $stmt = $pdo->prepare("UPDATE Users SET first_name = ?, last_name = ?, phone = ?, role = ?, status = ? WHERE id = ?");
    // $stmt->execute([$first_name, $last_name, $phone, $role, $status, $user_id]);
    
    $_SESSION['success_message'] = "User profile updated successfully! (Simulated)";
    redirect('dashboard/admin/users/list-users.php');
}
// --- End Processing ---


// --- Fetch User Data (GET) ---
// $stmt = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
// $stmt->execute([$user_id]);
// $user_to_edit = $stmt->fetch();
$user_to_edit = [
    'id' => $user_id, 'first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice@example.com', 'phone' => '123456789', 'role' => 'student', 'status' => 'active'
];

if (!$user_to_edit) {
    $_SESSION['error_message'] = "User not found.";
    redirect('dashboard/admin/users/list-users.php');
}
// --- End Fetch ---

$page_title = "Edit User: " . htmlspecialchars($user_to_edit['email']);
require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><?php echo $page_title; ?></h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="edit-user.php?id=<?php echo $user_id; ?>" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user_to_edit['email']); ?>" readonly disabled>
                        <small class="form-text">Email address cannot be changed.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_to_edit['first_name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user_to_edit['last_name']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user_to_edit['phone']); ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="student" <?php if ($user_to_edit['role'] == 'student') echo 'selected'; ?>>Student</option>
                                <option value="teacher" <?php if ($user_to_edit['role'] == 'teacher') echo 'selected'; ?>>Teacher</option>
                                <option value="admin" <?php if ($user_to_edit['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?php if ($user_to_edit['status'] == 'active') echo 'selected'; ?>>Active</option>
                                <option value="pending" <?php if ($user_to_edit['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                <option value="suspended" <?php if ($user_to_edit['status'] == 'suspended') echo 'selected'; ?>>Suspended</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="list-users.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>