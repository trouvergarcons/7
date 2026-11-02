<?php
// includes/footer.php - Shared Footer
?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">ApexCorp Enterprise Solutions</div>
                <p style="font-size: 0.9rem; line-height: 1.6; max-width: 320px;">
                    Empowering global enterprise collaboration, human capital visibility, and high-performance workflow execution.
                </p>
                <div style="margin-top: 14px; font-size: 0.85rem; color: #64748b;">
                    <span>📍 450 Lexington Ave, New York, NY</span><br>
                    <span>📞 +1 (800) 555-APEX</span>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Portal Login</a></li>
                    <li><a href="register.php">Staff Registration</a></li>
                    <li><a href="setup.php">System Diagnostic</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Role Portals</h4>
                <ul>
                    <li><a href="login.php">Employee Authentication</a></li>
                    <li><a href="login.php">Administrator Access</a></li>
                    <li><a href="dashboard.php">Personnel Directory</a></li>
                    <li><a href="index.php#portal-matrix">Access Matrix</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Technology</h4>
                <ul>
                    <li><a href="#">PHP 8.x Engine</a></li>
                    <li><a href="#">MySQL / phpMyAdmin</a></li>
                    <li><a href="#">Bcrypt Cryptography</a></li>
                    <li><a href="#">Vanilla JavaScript</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; <?php echo date('Y'); ?> ApexCorp Innovations Inc. All rights reserved.</div>
            <div>Integrated with MySQL / phpMyAdmin Database Backend</div>
        </div>
    </div>
</footer>

<script src="assets/js/validation.js"></script>
<?php if (isset($includeDashboardJs) && $includeDashboardJs): ?>
<script src="assets/js/dashboard.js"></script>
<?php endif; ?>
</body>
</html>
