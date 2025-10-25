<?php
// /dashboard/admin/announcements/edit-announcement.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);
$user = get_session_user();

// Get announcement ID from URL
$announcement_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$announcement_id) {
    $_SESSION['error_message'] = "Invalid announcement ID.";
    redirect('dashboard/admin/announcements/list-announcements.php');
}

// --- Edit Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $status = sanitize_input($_POST['status']);
    $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_NUMBER_INT) ?? 0;

    // --- PLACEHOLDER LOGIC ---
    // $stmt = $pdo->prepare("UPDATE Announcements SET title = ?, description = ?, status = ?, priority = ? WHERE id = ?");
    // $stmt->execute([$title, $description, $status, $priority, $announcement_id]);
    
    $_SESSION['success_message'] = "Announcement updated successfully! (Simulated)";
    redirect('dashboard/admin/announcements/list-announcements.php');
}
// --- End Processing ---


// --- Fetch Announcement Data (GET) ---
// $stmt = $pdo->prepare("SELECT * FROM Announcements WHERE id = ?");
// $stmt->execute([$announcement_id]);
// $announcement = $stmt->fetch();
$announcement = [
    'id' => $announcement_id, 'title' => 'Midterm Exams Schedule Announced', 'description' => 'The schedule for the upcoming midterm exams has been finalized.', 'status' => 'published', 'priority' => 1
];

if (!$announcement) {
    $_SESSION['error_message'] = "Announcement not found.";
    redirect('dashboard/admin/announcements/list-announcements.php');
}
// --- End Fetch ---

$page_title = "Edit Announcement";
require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Edit Announcement</h4>
            </div>
            <div class="card-body">
                
                <form action="edit-announcement.php?id=<?php echo $announcement_id; ?>" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Content</label>
                        <textarea class="form-control" id="description" name="description" rows="8" required><?php echo htmlspecialchars($announcement['description']); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="published" <?php if($announcement['status'] == 'published') echo 'selected'; ?>>Published</option>
                                <option value="draft" <?php if($announcement['status'] == 'draft') echo 'selected'; ?>>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="0" <?php if($announcement['priority'] == 0) echo 'selected'; ?>>Normal</option>
                                <option value="1" <?php if($announcement['priority'] == 1) echo 'selected'; ?>>High (Pin to top)</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Announcement</button>
                    <a href="list-announcements.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>