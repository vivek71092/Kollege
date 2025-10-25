<?php
// /includes/breadcrumb.php

// Get user info from session
$user = get_session_user();
?>
<nav class="breadcrumb-header" aria-label="breadcrumb">
    
    <div class="page-title">
        <h1><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?></h1>
    </div>

    <div class="user-menu dropdown">
        <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle fa-lg me-2"></i>
            <span class="d-none d-sm-inline">
                <?php echo htmlspecialchars($user['first_name'] ?? 'User'); ?>
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li>
                <h6 class="dropdown-header">
                    <?php echo htmlspecialchars($user['email'] ?? 'user@example.com'); ?>
                </h6>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/<?php echo $user['role']; ?>/profile.php">
                    <i class="fas fa-user-edit me-2"></i> My Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>dashboard/<?php echo $user['role']; ?>/settings.php">
                    <i class="fas fa-cog me-2"></i> Account Settings
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>auth/logout.php" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>