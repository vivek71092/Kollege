<?php
// /dashboard/teacher/upload-notes.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];

// --- File Upload Processing ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);

    if (empty($subject_id) || empty($title) || !isset($_FILES['note_file']) || $_FILES['note_file']['error'] != 0) {
        $_SESSION['error_message'] = "Please select a subject, add a title, and choose a file.";
    } else {
        // --- PLACEHOLDER LOGIC ---
        // 1. Verify teacher owns this subject_id
        // 2. Perform file validation (size, type)
        // 3. Move uploaded file to `public/uploads/notes/`
        // 4. Insert record into `Notes` table
        //
        // $file = $_FILES['note_file'];
        // $file_path = 'public/uploads/notes/' . time() . '_' . $file['name'];
        // move_uploaded_file($file['tmp_name'], '../../' . $file_path);
        //
        // $stmt = $pdo->prepare("INSERT INTO Notes (subject_id, title, description, file_path, uploaded_by, upload_date) VALUES (?, ?, ?, ?, ?, NOW())");
        // $stmt->execute([$subject_id, $title, $description, $file_path, $teacher_id]);
        
        $_SESSION['success_message'] = "Note uploaded successfully! (Simulated)";
        redirect('dashboard/teacher/manage-notes.php');
    }
    // Redirect back on error
    redirect('dashboard/teacher/upload-notes.php');
}
// --- End Processing ---


// --- Fetch teacher's subjects for dropdown ---
// $stmt = $pdo->prepare("SELECT s.id, s.subject_name FROM Subjects s JOIN Courses c ON s.course_id = c.id WHERE c.teacher_id = ?");
// $stmt->execute([$teacher_id]);
// $subjects = $stmt->fetchAll();
$subjects = [
    ['id' => 1, 'subject_name' => 'Web Development'],
    ['id' => 2, 'subject_name' => 'Data Science'],
    ['id' => 3, 'subject_name' => 'Business Analytics'],
];
// Pre-select subject if ID is in URL
$selected_subject = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
// --- End Fetch ---

$page_title = "Upload Notes";
require_once '../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Upload New Lecture Note</h4>
            </div>
            <div class="card-body">
                
                <?php 
                display_flash_message('success_message', 'alert-success');
                display_flash_message('error_message', 'alert-danger');
                ?>

                <form action="upload-notes.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="">Select a subject...</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo $subject['id']; ?>" <?php if ($subject['id'] == $selected_subject) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($subject['subject_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a subject.</div>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Note Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <div class="invalid-feedback">Please provide a title.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="note_file" class="form-label">Note File</label>
                        <input class="form-control" type="file" id="note_file" name="note_file" required>
                        <div class="form-text">Allowed types: PDF, PPT, DOCX, TXT, ZIP. Max size: 10MB.</div>
                        <div class="invalid-feedback">Please choose a file.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Note</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>