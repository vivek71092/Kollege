<?php
// /dashboard/admin/reports/user-report.php

// Load core files
require_once '../../../config.php';
require_once '../../../functions.php';
require_once '../../../auth/check_auth.php'; // Ensure user is logged in

// Role-specific check
require_role(['admin']);

$page_title = "User Report";
$user = get_session_user();

require_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Generate User Report</h4>
            </div>
            <div class="card-body">
                <p>Select your criteria to generate a CSV report of system users.</p>
                
                <form action="#" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="role" class="form-label">Filter by Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">All Roles</option>
                            <option value="student">Students</option>
                            <option value="teacher">Teachers</option>
                            <option value="admin">Admins</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Filter by Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" disabled>
                        <i class="fas fa-file-csv me-2"></i> Generate Report (Not Implemented)
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once '../../../includes/footer.php';
?>