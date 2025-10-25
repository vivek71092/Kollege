<?php
// /includes/footer.php

// Check again if we are in a dashboard page
$is_dashboard = (strpos($_SERVER['SCRIPT_NAME'], '/dashboard/') !== false);
?>

<?php if ($is_dashboard): ?>

    </main> <?php else: ?>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><?php echo SITE_NAME; ?></h5>
                    <p>Providing quality education through a modern, accessible learning management system.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>pages/about.php">About Us</a></li>
                        <li><a href="<?php echo BASE_URL; ?>pages/contact.php">Contact</a></li>
                        <li><a href="<?php echo BASE_URL; ?>pages/privacy.php">Privacy Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>pages/terms.php">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact Us</h5>
                    <p>
                        Email: <a href="mailto:info@kollege.ct.ws">info@kollege.ct.ws</a><br>
                        Phone: +1 234 567 890
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.
            </div>
        </div>
    </footer>

<?php endif; ?>

<?php require_once 'modals.php'; // Include site-wide modals ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<?php if ($is_dashboard): ?>
    <script src="public/js/dashboard.js"></script>
    <?php if (strpos($_SERVER['SCRIPT_NAME'], '/dashboard/admin/') !== false): ?>
        <script src="public/js/admin.js"></script>
    <?php endif; ?>
<?php else: ?>
    <script src="public/js/main.js"></script>
<?php endif; ?>

<script src="public/js/validation.js"></script>

<?php
if (isset($page_scripts) && is_array($page_scripts)) {
    foreach ($page_scripts as $script) {
        echo '<script src="' . htmlspecialchars($script) . '"></script>' . "\n";
    }
}
?>

</body>
</html>