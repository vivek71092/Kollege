<?php
// /dashboard/teacher/messages.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);

$page_title = "Messages";
$user = get_session_user();
$teacher_id = $user['id'];

// --- Placeholder Data ---
// $messages = $pdo->prepare("SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS sender_name FROM Messages m JOIN Users u ON m.sender_id = u.id WHERE m.receiver_id = ? ORDER BY m.sent_date DESC")->execute([$teacher_id])->fetchAll();
$messages = [
    ['id' => 3, 'subject' => 'Question about Assignment 1', 'message' => 'I am having trouble with...', 'sent_date' => '2025-10-22 11:00:00', 'sender_name' => 'Alice Smith', 'read_status' => 0],
    ['id' => 4, 'subject' => 'Late Submission Request', 'message' => 'I was sick, can I submit late?', 'sent_date' => '2025-10-21 15:30:00', 'sender_name' => 'Bob Johnson', 'read_status' => 1],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Inbox</h4>
    </div>
    <div class="card-body">
        <div class="list-group">
            <?php if (empty($messages)): ?>
                <div class="list-group-item text-center text-muted">You have no messages.</div>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <a href="#" class="list-group-item list-group-item-action <?php echo !$message['read_status'] ? 'fw-bold' : ''; ?>">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($message['subject']); ?></h5>
                            <small><?php echo format_date($message['sent_date'], 'M d'); ?></small>
                        </div>
                        <p class="mb-1">From: <?php echo htmlspecialchars($message['sender_name']); ?></p>
                        <small class="text-muted"><?php echo truncate_text(htmlspecialchars($message['message']), 150); ?></small>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>