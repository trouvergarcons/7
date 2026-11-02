<?php
// ============================================================================
// ApexCorp Solutions - Configuration & Auto-Setup Database Connection
// Zero-Configuration: Automatically creates database, table & seeds demo accounts!
// ============================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Credentials (Supports environment variables or local defaults)
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'company_db';

// Candidate ports (auto-detects standard 3306 or XAMPP alternate 3307)
$candidate_ports = array_unique(array_filter([
    getenv('DB_PORT') ? (int)getenv('DB_PORT') : null,
    3306,
    3307
]));

$conn = null;
$active_port = null;

mysqli_report(MYSQLI_REPORT_OFF);

// 1. Establish connection to MySQL
foreach ($candidate_ports as $port) {
    $test_conn = @mysqli_connect($db_host, $db_user, $db_pass, '', $port);
    if ($test_conn) {
        $active_port = $port;
        // Auto-create database if not exists
        @mysqli_query($test_conn, "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        if (@mysqli_select_db($test_conn, $db_name)) {
            $conn = $test_conn;
            mysqli_set_charset($conn, 'utf8mb4');
            break;
        }
    }
}

if (!$conn) {
    die("<div style='font-family: sans-serif; padding: 24px; background: #fee2e2; border: 1px solid #ef4444; border-radius: 12px; max-width: 620px; margin: 40px auto; color: #1e293b; box-shadow: 0 10px 25px rgba(0,0,0,0.1);'>
        <h3 style='color: #b91c1c; margin-top: 0;'>⚠️ Database Connection Required</h3>
        <p>Could not connect to MySQL server on ports <strong>3306</strong> or <strong>3307</strong>.</p>
        <p><strong>Quick Fix:</strong> Please ensure MySQL is started in your XAMPP Control Panel or MySQL service is running.</p>
    </div>");
}

// 2. Auto-Migration: Ensure `users` table exists
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
@mysqli_query($conn, $table_sql);

// 3. Auto-Seed: Populate demo data if table is empty
$count_res = @mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `users`");
$row = $count_res ? mysqli_fetch_assoc($count_res) : null;

if ($row && $row['cnt'] == 0) {
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
    if ($stmt) {
        foreach ($seeds as $u) {
            mysqli_stmt_bind_param($stmt, 'ssssssss', $u[0], $u[1], $u[2], $u[3], $u[4], $u[5], $u[6], $u[7]);
            @mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// ----------------------------------------------------------------------------
// Helper Functions
// ----------------------------------------------------------------------------

function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}

function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function current_user() {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id'          => $_SESSION['user_id'],
        'fullname'    => $_SESSION['fullname'],
        'email'       => $_SESSION['email'],
        'role'        => $_SESSION['role'],
        'department'  => $_SESSION['department'] ?? '',
        'designation' => $_SESSION['designation'] ?? '',
        'phone'       => $_SESSION['phone'] ?? '',
        'location'    => $_SESSION['location'] ?? ''
    ];
}

function flash_message($key = 'flash') {
    if (isset($_SESSION[$key])) {
        $msg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $msg;
    }
    return null;
}
