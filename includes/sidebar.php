<?php
// /includes/sidebar.php

// Get user info from session for display
$user = get_session_user();
$user_role = $user['role'] ?? 'guest';
?>
<aside class="dashboard-sidebar">
    <div class="sidebar-brand">
        <a href="<?php echo BASE_URL; ?>dashboard/index.php"><?php echo SITE_NAME; ?></a>
    </div>

    <ul class="sidebar-nav nav flex-column">
        
        <?php if ($user_role === 'student'): ?>
            <li class="nav-heading">Student Menu</li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/courses.php">
                    <i class="fas fa-book"></i> My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/assignments.php">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/marks.php">
                    <i class="fas fa-marker"></i> My Marks
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/attendance.php">
                    <i class="fas fa-calendar-check"></i> My Attendance
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/student/schedule.php">
                    <i class="fas fa-calendar-alt"></i> Class Schedule
                </a>
            </li>
        <?php endif; ?>

        <?php if ($user_role === 'teacher'): ?>
            <li class="nav-heading">Teacher Menu</li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/courses.php">
                    <i class="fas fa-chalkboard-teacher"></i> My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/manage-assignments.php">
                    <i class="fas fa-edit"></i> Assignments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/manage-marks.php">
                    <i class="fas fa-percentage"></i> Manage Marks
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/mark-attendance.php">
                    <i class="fas fa-user-check"></i> Manage Attendance
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/teacher/students.php">
                    <i class="fas fa-users"></i> Enrolled Students
                </a>
            </li>
        <?php endif; ?>

        <?php if ($user_role === 'admin'): ?>
            <li class="nav-heading">Admin Menu</li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/dashboard.php">
                    <i class="fas fa-chart-line"></i> Analytics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/users/list-users.php">
                    <i class="fas fa-users-cog"></i> User Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/courses/list-courses.php">
                    <i class="fas fa-book-medical"></i> Course Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/subjects/list-subjects.php">
                    <i class="fas fa-clipboard-list"></i> Subject Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/announcements/list-announcements.php">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/reports/user-report.php">
                    <i class="fas fa-file-alt"></i> Generate Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/audit-logs.php">
                    <i class="fas fa-history"></i> Audit Logs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/admin/settings/system-settings.php">
                    <i class="fas fa-cogs"></i> System Settings
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-heading">Account</li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/<?php echo $user_role; ?>/profile.php">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
        </li>
        <li class_="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard/<?php echo $user_role; ?>/settings.php">
                <i class="fas fa-user-cog"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>auth/logout.php" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>

</aside>