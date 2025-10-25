<?php
// /dashboard/admin/announcements/add-announcement.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "Create Announcement";
$user = get_session_user();

// --- Add Announcement Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']); // Note: May want to allow some HTML
    $status = sanitize_input($_POST['status']);
    $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_NUMBER_INT) ?? 0;
    $created_by = $user['id'];

    if (empty($title) || empty($description)) {
        $_SESSION['error_message'] = "Title and Description are required.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // 1. Handle image upload if `image` field is used
        // 2. Insert into `Announcements` table
        // $stmt = $pdo->prepare("INSERT INTO Announcements (title, description, created_by, created_date, status, priority) VALUES (?, ?, ?, NOW(), ?, ?)");
        // $stmt->execute([$title, $description, $created_by, $status, $priority]);
        
        $_SESSION['success_message'] = "Announcement created successfully! (Simulated)";
        redirect('dashboard/admin/announcements/list-announcements.php');
    }
    redirect('dashboard/admin/announcements/add-announcement.php');
}
// --- End Processing ---

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Create New Announcement</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="add-announcement.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Content</label>
                        <textarea class="form-control" id="description" name="description" rows="8" required></textarea>
                        </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="published" selected>Published (Visible to all)</option>
                                <option value="draft">Draft (Hidden)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="0" selected>Normal</option>
                                <option value="1">High (Pin to top)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Featured Image (Optional)</label>
                        <input type="file" class="form-control" id="image" name="image" disabled>
                        <small class="form-text">(File upload not implemented in this demo)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Announcement</button>
                    <a href="list-announcements.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>