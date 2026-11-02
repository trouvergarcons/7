<?php
// ============================================================================
// Database Auto-Setup & Migration Script
// Can be run via CLI or accessed directly in browser: http://localhost/company/setup.php
// ============================================================================

require_once __DIR__ . '/config.php';

$success_messages = [];
$error_messages = [];

// 1. Create table
$table_sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'employee') NOT NULL,
    `department` VARCHAR(100) NOT NULL,
    `designation` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (mysqli_query($conn, $table_sql)) {
    $success_messages[] = "Table `users` created or already exists.";
} else {
    $error_messages[] = "Error creating `users` table: " . mysqli_error($conn);
}

// 2. Check if users already seeded
$check_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `users`");
$row = mysqli_fetch_assoc($check_res);

if ($row && $row['cnt'] == 0) {
    // Seed initial demo data
    $admin_pass = password_hash('Admin@123', PASSWORD_BCRYPT);
    $emp_pass   = password_hash('Emp@123', PASSWORD_BCRYPT);

    $seeds = [
        // Admins
        ['Michael Sterling', 'admin@apexcorp.com', $admin_pass, 'admin', 'Executive', 'Chief Executive Officer (CEO)', '+1 (555) 019-2831', 'New York HQ - Floor 14'],
        ['Sarah Jenkins', 'sarah.director@apexcorp.com', $admin_pass, 'admin', 'Human Resources', 'VP of People & Culture', '+1 (555) 019-2832', 'New York HQ - Floor 12'],
        ['David Chen', 'david.cto@apexcorp.com', $admin_pass, 'admin', 'Engineering & Tech', 'Chief Technology Officer (CTO)', '+1 (555) 019-2833', 'San Francisco Tech Hub'],
        ['Elena Rostova', 'elena.ops@apexcorp.com', $admin_pass, 'admin', 'Operations', 'Chief Operations Officer (COO)', '+1 (555) 019-2834', 'Chicago Operations Center'],

        // Employees
        ['John Doe', 'john.dev@apexcorp.com', $emp_pass, 'employee', 'Engineering', 'Senior Full Stack Engineer', '+1 (555) 441-1001', 'Remote - Austin, TX'],
        ['Emma Watson', 'emma.design@apexcorp.com', $emp_pass, 'employee', 'Product Design', 'Lead UX/UI Designer', '+1 (555) 441-1002', 'San Francisco Tech Hub'],
        ['Alex Rivera', 'alex.marketing@apexcorp.com', $emp_pass, 'employee', 'Marketing', 'Digital Growth Strategist', '+1 (555) 441-1003', 'New York HQ - Floor 9'],
        ['Sophia Martinez', 'sophia.data@apexcorp.com', $emp_pass, 'employee', 'Data Science', 'Machine Learning Engineer', '+1 (555) 441-1004', 'Seattle Research Lab'],
        ['Liam Gallagher', 'liam.qa@apexcorp.com', $emp_pass, 'employee', 'Quality Assurance', 'Lead QA Automation Engineer', '+1 (555) 441-1005', 'Chicago Operations Center']
    ];

    $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`fullname`, `email`, `password`, `role`, `department`, `designation`, `phone`, `location`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $inserted_count = 0;
    foreach ($seeds as $u) {
        mysqli_stmt_bind_param($stmt, 'ssssssss', $u[0], $u[1], $u[2], $u[3], $u[4], $u[5], $u[6], $u[7]);
        if (mysqli_stmt_execute($stmt)) {
            $inserted_count++;
        }
    }
    mysqli_stmt_close($stmt);
    $success_messages[] = "Successfully seeded $inserted_count initial Admin & Employee accounts.";
} else {
    $success_messages[] = "Database already contains {$row['cnt']} user records. Skipping seed insertion.";
}

// Check if running from CLI
if (php_sapi_name() === 'cli') {
    echo "=== Database Setup Result (Port: $active_port) ===" . PHP_EOL;
    foreach ($success_messages as $m) echo "[OK] " . $m . PHP_EOL;
    foreach ($error_messages as $m) echo "[ERR] " . $m . PHP_EOL;
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApexCorp - Database Setup</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="setup-body">
    <div class="setup-container">
        <div class="setup-card">
            <div class="setup-header">
                <h2>🚀 Database Setup & Diagnostics</h2>
                <p>Connected to MySQL on port <strong><?php echo htmlspecialchars($active_port); ?></strong></p>
            </div>
            <div class="setup-content">
                <?php foreach ($success_messages as $msg): ?>
                    <div class="alert alert-success">✓ <?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>
                <?php foreach ($error_messages as $msg): ?>
                    <div class="alert alert-danger">✕ <?php echo htmlspecialchars($msg); ?></div>
                <?php endforeach; ?>

                <div class="credentials-box">
                    <h4>Pre-configured Demo Credentials</h4>
                    <table class="creds-table">
                        <tr>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                        <tr>
                            <td><span class="badge badge-admin">Admin</span></td>
                            <td>admin@apexcorp.com</td>
                            <td><code>Admin@123</code></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-employee">Employee</span></td>
                            <td>john.dev@apexcorp.com</td>
                            <td><code>Emp@123</code></td>
                        </tr>
                    </table>
                </div>

                <div class="setup-actions">
                    <a href="index.php" class="btn btn-primary">Go to Home Page</a>
                    <a href="login.php" class="btn btn-secondary">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
