<?php
// /dashboard/teacher/schedule.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];
$page_title = "My Class Schedule";

// --- Placeholder Data ---
// $sql = "SELECT cs.day_of_week, cs.start_time, cs.end_time, cs.classroom, s.subject_name
//         FROM ClassSchedule cs
//         JOIN Subjects s ON cs.subject_id = s.id
//         WHERE cs.teacher_id = ?
//         ORDER BY FIELD(cs.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), cs.start_time";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$teacher_id]);
// $schedule_data = $stmt->fetchAll();
$schedule_data = [
    ['day_of_week' => 'Monday', 'start_time' => '09:00:00', 'end_time' => '11:00:00', 'classroom' => 'Room 101', 'subject_name' => 'Web Development'],
    ['day_of_week' => 'Tuesday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'classroom' => 'Lab 3', 'subject_name' => 'Data Science'],
    ['day_of_week' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '11:00:00', 'classroom' => 'Room 101', 'subject_name' => 'Web Development'],
    ['day_of_week' => 'Thursday', 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'classroom' => 'Lab 3', 'subject_name' => 'Data Science'],
    ['day_of_week' => 'Friday', 'start_time' => '13:00:00', 'end_time' => '15:00:00', 'classroom' => 'Room 205', 'subject_name' => 'Business Analytics'],
];
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">My Class Schedule</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Subject</th>
                        <th>Classroom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $current_day = '';
                    foreach ($schedule_data as $class): 
                        $start = (new DateTime($class['start_time']))->format('h:i A');
                        $end = (new DateTime($class['end_time']))->format('h:i A');
                    ?>
                        <tr>
                            <?php if ($current_day != $class['day_of_week']): ?>
                                <?php $current_day = $class['day_of_week']; ?>
                                <td class="fw-bold align-middle" rowspan="<?php echo count(array_filter($schedule_data, fn($c) => $c['day_of_week'] == $current_day)); ?>">
                                    <?php echo htmlspecialchars($current_day); ?>
                                </td>
                            <?php endif; ?>
                            <td><?php echo $start; ?> - <?php echo $end; ?></td>
                            <td><?php echo htmlspecialchars($class['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($class['classroom']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($schedule_data)): ?>
                        <tr>
                            <td colspan="4" class="text-muted">Your schedule is not available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>