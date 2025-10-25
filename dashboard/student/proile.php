<?php
// /dashboard/student/profile.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "My Profile";
$user = get_session_user();
$student_id = $user['id'];

// --- Profile Update Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $phone = sanitize_input($_POST['phone']);
    $bio = sanitize_input($_POST['bio']);

    if (empty($first_name) || empty($last_name)) {
        $_SESSION['error_message'] = "First name and last name are required.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // In a real app, you would:
        // 1. Handle file upload for profile_image if included
        // 2. Update the user in the database
        // $stmt = $pdo->prepare("UPDATE Users SET first_name = ?, last_name = ?, phone = ?, bio = ? WHERE id = ?");
        // if ($stmt->execute([$first_name, $last_name, $phone, $bio, $student_id])) {
        //    $_SESSION['success_message'] = "Profile updated successfully!";
        //    // 3. Update session variables
        //    $_SESSION['first_name'] = $first_name;
        // } else {
        //    $_SESSION['error_message'] = "Failed to update profile.";
        // }
        
        $_SESSION['success_message'] = "Profile updated successfully! (Simulated)";
        $_SESSION['first_name'] = $first_name; // Update session
    }
    redirect('dashboard/student/profile.php');
}
// --- End Processing ---

// --- Fetch Current User Data ---
// $stmt = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
// $stmt->execute([$student_id]);
// $user_data = $stmt->fetch();
$user_data = [
    'first_name' => $user['first_name'],
    'last_name' => 'Student',
    'email' => $user['email'],
    'phone' => '1234567890',
    'bio' => 'Student in the Computer Science program.',
    'profile_image' => 'public/images/placeholders/default-profile.png'
];
// --- End Fetch ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Edit Profile</h4>
    </div>
    <div class="card-body">
        
        <?php 
        display_flash_message('success_message', 'alert-success');
        display_flash_message('error_message', 'alert-danger');
        ?>

        <form action="profile.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <img src="<?php echo htmlspecialchars($user_data['profile_image']); ?>" alt="Profile Image" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <label for="profile_image" class="form-label">Change Profile Picture</label>
                    <input type="file" class="form-control form-control-sm" id="profile_image" name="profile_image">
                    <small class="form-text">Max 2MB. (Upload not implemented in this demo)</small>
                </div>
                
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly disabled>
                        <small class="form-text">Email address cannot be changed.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user_data['first_name']); ?>" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user_data['last_name']); ?>" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio / About Me</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>