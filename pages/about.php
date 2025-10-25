<?php
// /pages/about.php

require_once '../config.php';
require_once '../functions.php';

$page_title = "About Us";
require_once '../includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            
            <h1 class="display-5 text-center mb-4"><?php echo $page_title; ?></h1>
            
            <p class="lead">Welcome to <?php echo SITE_NAME; ?>, your premier destination for online learning and institutional management. We are passionate about revolutionizing education by providing a seamless, powerful, and intuitive platform for students, teachers, and administrators.</p>

            <hr class="my-4">

            <h2 class="mt-5 mb-3">Our Story</h2>
            <p>Founded on the principle that education should be accessible to everyone, everywhere, <?php echo SITE_NAME; ?> was born from a desire to bridge the gap between traditional learning and the digital age. Our team of educators and developers has worked tirelessly to create a Learning Management System (LMS) that is not only feature-rich but also user-friendly and adaptable to various educational needs.</p>

            <h2 class="mt-5 mb-3">What We Do</h2>
            <p>We provide a comprehensive, full-stack LMS solution designed to manage every aspect of the academic journey:</p>
            <ul>
                <li><strong>For Students:</strong> Access course materials, submit assignments, track grades and attendance, and communicate with instructors, all from one central dashboard.</li>
                <li><strong>For Teachers:</strong> Effortlessly upload notes, create and grade assignments, manage student attendance and marks, and engage with students.</li>
                <li><strong>For Administrators:</strong> Complete control over user management, course creation, content moderation, and system-wide analytics and reporting.</li>
            </ul>

            <h2 class="mt-5 mb-3">Our Team</h2>
            <p>We are a diverse team of developers, designers, and education professionals committed to excellence. We believe in continuous improvement and work closely with our community to adapt and evolve our platform.</p>
            
            <div class="row text-center mt-4">
                <div class="col-md-4">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/team-1.jpg" alt="Team Member 1" class="img-fluid rounded-circle mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5>Jane Doe</h5>
                    <p class="text-muted">Lead Developer</p>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/team-2.jpg" alt="Team Member 2" class="img-fluid rounded-circle mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5>John Smith</h5>
                    <p class="text-muted">UX/UI Designer</p>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/team-3.jpg" alt="Team Member 3" class="img-fluid rounded-circle mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5>Emily White</h5>
                    <p class="text-muted">Project Manager</p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>