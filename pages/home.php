<?php
// /pages/home.php

// This file is intended to be *included* by the main index.php
// (e.g., require_once 'pages/home.php';)
// We assume config.php, functions.php, and header.php have already been called.
?>

<header class="hero-section bg-primary text-white text-center p-5">
    <div class="container">
        <h1 class="display-4">Welcome to <?php echo SITE_NAME; ?></h1>
        <p class="lead">Your complete solution for online learning and management.</p>
        <a href="<?php echo BASE_URL; ?>auth/login.php" class="btn btn-light btn-lg m-2">Login</a>
        <a href="<?php echo BASE_URL; ?>auth/register.php" class="btn btn-outline-light btn-lg m-2">Register Now</a>
    </div>
</header>

<section class="welcome-section p-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>About Our Institution</h2>
                <p>Kollege LMS is dedicated to providing high-quality education and resources to students everywhere. Our platform connects students, teachers, and administrators in a seamless, collaborative environment.</p>
                <p>Explore our courses, meet our faculty, and discover why Kollege LMS is the right choice for your educational journey.</p>
                <a href="<?php echo BASE_URL; ?>pages/about.php" class="btn btn-primary">Learn More About Us</a>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?php echo BASE_URL; ?>public/images/placeholders/institution-image.jpg" alt="Institution" class="img-fluid rounded-circle shadow" style="width: 300px; height: 300px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<section class="featured-courses-section bg-light p-5">
    <div class="container">
        <h2 class="text-center mb-4">Featured Courses</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/course-placeholder-1.jpg" class="card-img-top" alt="Course 1" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Introduction to Web Development</h5>
                        <p class="card-text">Learn the fundamentals of HTML, CSS, and JavaScript to build modern websites.</p>
                        <a href="<?php echo BASE_URL; ?>auth/register.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/course-placeholder-2.jpg" class="card-img-top" alt="Course 2" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Data Science with Python</h5>
                        <p class="card-text">Explore data analysis, visualization, and machine learning with Python.</p>
                        <a href="<?php echo BASE_URL; ?>auth/register.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <img src="<?php echo BASE_URL; ?>public/images/placeholders/course-placeholder-3.jpg" class="card-img-top" alt="Course 3" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Business Analytics</h5>
                        <p class="card-text">Understand how to use data to make informed business decisions.</p>
                        <a href="<?php echo BASE_URL; ?>auth/register.php" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>