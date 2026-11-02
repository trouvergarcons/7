<?php
// login.php - Employee & Admin Portal Authentication
$pageTitle = 'Portal Sign In';
require_once __DIR__ . '/config.php';

// Redirect if already logged in
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email_val = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $email_val = $email;

    if (empty($email) || empty($password)) {
        $error = "Please enter both your email address and password.";
    } else {
        // Query user from database
        $stmt = mysqli_prepare($conn, "SELECT `id`, `fullname`, `email`, `password`, `role`, `department`, `designation`, `phone`, `location` FROM `users` WHERE `email` = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify Bcrypt password hash
            if (password_verify($password, $row['password'])) {
                // Set session data
                $_SESSION['user_id']     = $row['id'];
                $_SESSION['fullname']    = $row['fullname'];
                $_SESSION['email']       = $row['email'];
                $_SESSION['role']        = $row['role']; // 'admin' or 'employee'
                $_SESSION['department']  = $row['department'];
                $_SESSION['designation'] = $row['designation'];
                $_SESSION['phone']       = $row['phone'];
                $_SESSION['location']    = $row['location'];

                $_SESSION['success'] = "Welcome back, {$row['fullname']}! Authenticated as " . ucfirst($row['role']) . ".";
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Invalid password. Please check your credentials and try again.";
            }
        } else {
            $error = "No user found with this email address ($email).";
        }
        mysqli_stmt_close($stmt);
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>ApexCorp Enterprise Sign In</h2>
            <p>Role-authenticated access for Employees and Administrators</p>
        </div>

        <div class="auth-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    ✕ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" id="loginForm" novalidate>
                <div class="form-group">
                    <label for="login_email" class="form-label">Corporate Email Address <span class="req">*</span></label>
                    <input type="email" name="email" id="login_email" class="form-control" placeholder="name@apexcorp.com" value="<?php echo htmlspecialchars($email_val); ?>" required autofocus>
                    <div class="field-error" id="login_email_error"></div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="login_password" class="form-label" style="margin-bottom: 0;">Password <span class="req">*</span></label>
                    </div>
                    <div class="input-password-wrapper">
                        <input type="password" name="password" id="login_password" class="form-control" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password-btn" data-target="login_password" title="Show password">👁️</button>
                    </div>
                    <div class="field-error" id="login_password_error"></div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top: 10px;">
                    Authenticate & Access Directory &rarr;
                </button>
            </form>

            <!-- Quick One-Click Fill for Demo Testing -->
            <div class="demo-account-pills">
                <p>⚡ Fast Demo Login (Click to Auto-fill):</p>
                <div class="demo-btn-group">
                    <button type="button" class="btn-demo" onclick="fillCredentials('admin@apexcorp.com', 'Admin@123')">
                        👑 <strong>Admin Demo</strong><br><small>admin@apexcorp.com</small>
                    </button>
                    <button type="button" class="btn-demo" onclick="fillCredentials('john.dev@apexcorp.com', 'Emp@123')">
                        💼 <strong>Employee Demo</strong><br><small>john.dev@apexcorp.com</small>
                    </button>
                </div>
            </div>

            <div class="auth-footer-links">
                Don't have an account? <a href="register.php"><strong>Register as Employee or Admin</strong></a>
            </div>
        </div>
    </div>
</div>

<script>
function fillCredentials(email, pass) {
    document.getElementById('login_email').value = email;
    document.getElementById('login_password').value = pass;
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
