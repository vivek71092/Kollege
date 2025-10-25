<?php
// /dashboard/student/attendance.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['student']);

$page_title = "My Attendance";
$user = get_session_user();
$student_id = $user['id'];

// --- Placeholder Data ---
// $sql = "SELECT a.date, a.status, a.remarks, s.subject_name
//         FROM Attendance a
//         JOIN Subjects s ON a.subject_id = s.id
//         WHERE a.student_id = ?
//         ORDER BY s.subject_name, a.date DESC";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$student_id]);
// $all_attendance = $stmt->fetchAll();
$all_attendance = [
    ['date' => '2025-10-01', 'status' => 'present', 'remarks' => '', 'subject_name' => 'Web Development'],
    ['date' => '2025-10-03', 'status' => 'present', 'remarks' => '', 'subject_name' => 'Web Development'],
    ['date' => '2025-10-06', 'status' => 'absent', 'remarks' => 'Sick leave', 'subject_name' => 'Web Development'],
    ['date' => '2025-10-02', 'status' => 'present', 'remarks' => '', 'subject_name' => 'Data Science'],
    ['date' => '2025-10-04', 'status' => 'present', 'remarks' => '', 'subject_name' => 'Data Science'],
];

// Group by subject and calculate stats
$attendance_by_subject = [];
foreach ($all_attendance as $record) {
    $subject = $record['subject_name'];
    if (!isset($attendance_by_subject[$subject])) {
        $attendance_by_subject[$subject] = ['present' => 0, 'absent' => 0, 'total' => 0, 'records' => []];
    }
    $attendance_by_subject[$subject]['records'][] = $record;
    $attendance_by_subject[$subject]['total']++;
    if ($record['status'] == 'present') {
        $attendance_by_subject[$subject]['present']++;
    } else {
        $attendance_by_subject[$subject]['absent']++;
    }
}
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Attendance Record</h4>
    </div>
    <div class="card-body">
        <?php if (empty($attendance_by_subject)): ?>
            <div class="alert alert-info">Your attendance has not been marked yet.</div>
        <?php else: ?>
            <div class="accordion" id="attendanceAccordion">
                <?php $i = 0; foreach ($attendance_by_subject as $subject_name => $data): $i++; ?>
                    <?php 
                    $percentage = ($data['total'] > 0) ? round(($data['present'] / $data['total']) * 100) : 0;
                    $badge_class = $percentage >= 80 ? 'bg-success' : ($percentage >= 60 ? 'bg-warning text-dark' : 'bg-danger');
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $i; ?>">
                            <button class="accordion-button <?php if($i > 1) echo 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $i; ?>" aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $i; ?>">
                                <span class="me-auto"><?php echo htmlspecialchars($subject_name); ?></span>
                                <span class="badge <?php echo $badge_class; ?> me-3"><?php echo $percentage; ?>%</span>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 1) echo 'show'; ?>" aria-labelledby="heading-<?php echo $i; ?>">
                            <div class="accordion-body">
                                <p>
                                    <strong>Total Classes:</strong> <?php echo $data['total']; ?> | 
                                    <strong>Present:</strong> <?php echo $data['present']; ?> | 
                                    <strong>Absent:</strong> <?php echo $data['absent']; ?>
                                </p>
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['records'] as $record): ?>
                                            <tr>
                                                <td><?php echo format_date($record['date'], 'M d, Y'); ?></td>
                                                <td>
                                                    <?php if ($record['status'] == 'present'): ?>
                                                        <span class="badge bg-success">Present</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Absent</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($record['remarks']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>