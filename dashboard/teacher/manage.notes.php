<?php
// /dashboard/teacher/manage-notes.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];

// Filter by subject if ID is in URL
$subject_filter = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);

// --- Placeholder Data ---
// $sql = "SELECT n.id, n.title, n.upload_date, s.subject_name, n.file_path
//         FROM Notes n
//         JOIN Subjects s ON n.subject_id = s.id
//         WHERE n.uploaded_by = ?";
// if ($subject_filter) {
//     $sql .= " AND n.subject_id = $subject_filter";
// }
// $sql .= " ORDER BY n.upload_date DESC";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$teacher_id]);
// $notes = $stmt->fetchAll();
$all_notes = [
    ['id' => 1, 'title' => 'Lecture 1: Intro to HTML', 'upload_date' => '2025-10-01 10:00:00', 'subject_name' => 'Web Development', 'file_path' => 'public/uploads/notes/lecture1.pdf'],
    ['id' => 2, 'title' => 'Lecture 2: CSS Fundamentals', 'upload_date' => '2025-10-03 10:00:00', 'subject_name' => 'Web Development', 'file_path' => 'public/uploads/notes/lecture2.pdf'],
    ['id' => 3, 'title' => 'Module 1: Data Basics', 'upload_date' => '2025-10-02 14:00:00', 'subject_name' => 'Data Science', 'file_path' => 'public/uploads/notes/data-basics.pdf'],
];
// Apply filter
$notes = $subject_filter ? array_filter($all_notes, fn($n) => $n['subject_id'] == $subject_filter) : $all_notes;
// --- End Placeholder Data ---

$page_title = "Manage Notes";
require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">My Uploaded Notes</h4>
        <a href="upload-notes.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Upload New Note
        </a>
    </div>
    <div class="card-body">
        
        <?php 
        display_flash_message('success_message', 'alert-success');
        display_flash_message('error_message', 'alert-danger');
        ?>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Uploaded On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($notes)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No notes found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($note['title']); ?></td>
                                <td><?php echo htmlspecialchars($note['subject_name']); ?></td>
                                <td><?php echo format_date($note['upload_date']); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL . $note['file_path']; ?>" class="btn btn-sm btn-outline-success" target="_blank" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this note?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>