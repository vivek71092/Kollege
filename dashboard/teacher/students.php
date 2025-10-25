<?php
// /dashboard/teacher/students.php

// Load core files
require_once '../../config.php';
require_once '../../functions.php';
require_once '../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['teacher']);
$user = get_session_user();
$teacher_id = $user['id'];
$page_title = "My Students";

// --- Placeholder Data ---
// $sql = "SELECT DISTINCT u.id, u.first_name, u.last_name, u.email, u.phone, s.subject_name
//         FROM Users u
//         JOIN Enrollments e ON u.id = e.student_id
//         JOIN Subjects s ON e.subject_id = s.id
//         JOIN Courses c ON s.course_id = c.id
//         WHERE c.teacher_id = ?
//         ORDER BY u.last_name, u.first_name";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$teacher_id]);
// $all_students = $stmt->fetchAll();
$all_students = [
    ['id' => 12, 'first_name' => 'Charlie', 'last_name' => 'Brown', 'email' => 'charlie@example.com', 'phone' => '111222333', 'subject_name' => 'Web Development'],
    ['id' => 11, 'first_name' => 'Bob', 'last_name' => 'Johnson', 'email' => 'bob@example.com', 'phone' => '987654321', 'subject_name' => 'Data Science'],
    ['id' => 10, 'first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice@example.com', 'phone' => '123456789', 'subject_name' => 'Web Development'],
    ['id' => 10, 'first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice@example.com', 'phone' => '123456789', 'subject_name' => 'Business Analytics'],
];

// Group by student ID to avoid duplicates in the main list
$students = [];
foreach ($all_students as $student) {
    if (!isset($students[$student['id']])) {
        $students[$student['id']] = $student;
        $students[$student['id']]['subjects'] = [];
    }
    $students[$student['id']]['subjects'][] = $student['subject_name'];
}
// --- End Placeholder Data ---

require_once '../../includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">All Enrolled Students</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle data-table">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Enrolled Subjects</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No students are enrolled in your courses.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                <td>
                                    <?php foreach ($student['subjects'] as $subject_name): ?>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($subject_name); ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <a href="messages.php?to=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-secondary" title="Message Student">
                                        <i class="fas fa-envelope"></i>
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