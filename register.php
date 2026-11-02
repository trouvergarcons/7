<?php
// register.php - Staff & Admin Registration
$pageTitle = 'Register Staff Account';
require_once __DIR__ . '/config.php';

// Redirect if already logged in
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$old = [
    'fullname'    => '',
    'email'       => '',
    'role'        => 'employee',
    'department'  => 'Computer Science',
    'designation' => '',
    'phone'       => '',
    'location'    => 'New York HQ - Floor 12'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname    = trim($_POST['fullname'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $password    = $_POST['password'] ?? '';
    $confirm_pwd = $_POST['confirm_password'] ?? '';
    $role        = trim($_POST['role'] ?? 'employee');
    $department  = trim($_POST['department'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $location    = trim($_POST['location'] ?? '');

    $old['fullname']    = $fullname;
    $old['email']       = $email;
    $old['role']        = $role;
    $old['department']  = $department;
    $old['designation'] = $designation;
    $old['phone']       = $phone;
    $old['location']    = $location;

    // Validation
    if (empty($fullname) || strlen($fullname) < 3) {
        $errors[] = "Full Name must be at least 3 characters long.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid corporate email address.";
    }

    if (!in_array($role, ['employee', 'admin'])) {
        $errors[] = "Role must be either 'employee' or 'admin'.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_pwd) {
        $errors[] = "Password and Confirmation Password do not match.";
    }

    if (empty($department)) {
        $errors[] = "Please select a department.";
    }

    if (empty($designation)) {
        $errors[] = "Please enter your designation / job title.";
    }

    if (empty($phone)) {
        $errors[] = "Please enter your contact phone number.";
    }

    // Check duplicate email
    if (empty($errors)) {
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM `users` WHERE `email` = ?");
        mysqli_stmt_bind_param($check_stmt, 's', $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $errors[] = "An account with email address '$email' already exists. Please log in.";
        }
        mysqli_stmt_close($check_stmt);
    }

    // Insert user into database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $insert_stmt = mysqli_prepare($conn, "INSERT INTO `users` (`fullname`, `email`, `password`, `role`, `department`, `designation`, `phone`, `location`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insert_stmt, 'ssssssss', $fullname, $email, $hashed_password, $role, $department, $designation, $phone, $location);

        if (mysqli_stmt_execute($insert_stmt)) {
            mysqli_stmt_close($insert_stmt);
            $_SESSION['success'] = "Registration successful! You may now log in with your credentials.";
            header('Location: login.php?registered=1');
            exit;
        } else {
            $errors[] = "Registration failed due to a database error: " . mysqli_error($conn);
            mysqli_stmt_close($insert_stmt);
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-wrapper">
    <div class="auth-card wide-card">
        <div class="auth-header">
            <h2>Corporate Staff Registration</h2>
            <p>Join ApexCorp as an Employee or Administrator</p>
        </div>

        <div class="auth-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul style="margin-left: 20px; list-style-type: disc;">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" id="registerForm" novalidate>
                <!-- Role Selection -->
                <div class="form-group">
                    <label class="form-label">Select Account Role <span class="req">*</span></label>
                    <div class="role-selector-group">
                        <label class="role-radio-label <?php echo ($old['role'] === 'employee') ? 'selected' : ''; ?>">
                            <input type="radio" name="role" value="employee" <?php echo ($old['role'] === 'employee') ? 'checked' : ''; ?>>
                            <span class="role-icon">💼</span>
                            <span class="role-title">Employee</span>
                            <span class="role-hint">Views all Administrator profiles</span>
                        </label>

                        <label class="role-radio-label <?php echo ($old['role'] === 'admin') ? 'selected' : ''; ?>">
                            <input type="radio" name="role" value="admin" <?php echo ($old['role'] === 'admin') ? 'checked' : ''; ?>>
                            <span class="role-icon">👑</span>
                            <span class="role-title">Administrator</span>
                            <span class="role-hint">Views all Employee profiles</span>
                        </label>
                    </div>
                    <div class="field-error" id="role_error"></div>
                </div>

                <div class="form-row">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="fullname" class="form-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="fullname" id="fullname" class="form-control" placeholder="e.g. Robert Smith" value="<?php echo htmlspecialchars($old['fullname']); ?>" required>
                        <div class="field-error" id="fullname_error"></div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Corporate Email <span class="req">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="name@apexcorp.com" value="<?php echo htmlspecialchars($old['email']); ?>" required>
                        <div class="field-error" id="email_error"></div>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Department -->
                    <div class="form-group">
                        <label for="department" class="form-label">Department <span class="req">*</span></label>
                        <select name="department" id="department" class="form-control" required>
                            <?php
                            $departments = [
                                'Computer Science',
                                'Management',
                                'Mathematics',
                                'Physics'
                            ];
                            foreach ($departments as $dept) {
                                $sel = ($old['department'] === $dept) ? 'selected' : '';
                                echo "<option value=\"$dept\" $sel>$dept</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Designation -->
                    <div class="form-group">
                        <label for="designation" class="form-label">Designation / Title <span class="req">*</span></label>
                        <input type="text" name="designation" id="designation" class="form-control" placeholder="e.g. Senior Backend Engineer" value="<?php echo htmlspecialchars($old['designation']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Contact Phone <span class="req">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="+1 (555) 000-0000" value="<?php echo htmlspecialchars($old['phone']); ?>" required>
                        <div class="field-error" id="phone_error"></div>
                    </div>

                    <!-- Office Location -->
                    <div class="form-group">
                        <label for="location" class="form-label">Work Location <span class="req">*</span></label>
                        <select name="location" id="location" class="form-control" required>
                            <?php
                            $locations = [
                                'New York HQ - Floor 12',
                                'San Francisco Tech Hub',
                                'Chicago Operations Center',
                                'Seattle Research Lab',
                                'Austin Engineering Hub',
                                'Remote - Domestic / Global'
                            ];
                            foreach ($locations as $loc) {
                                $sel = ($old['location'] === $loc) ? 'selected' : '';
                                echo "<option value=\"$loc\" $sel>$loc</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password <span class="req">*</span></label>
                        <div class="input-password-wrapper">
                            <input type="password" name="password" id="password" class="form-control" placeholder="At least 6 characters" required>
                            <button type="button" class="toggle-password-btn" data-target="password" title="Show password">👁️</button>
                        </div>
                        <div class="field-error" id="password_error"></div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password <span class="req">*</span></label>
                        <div class="input-password-wrapper">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Re-type password" required>
                            <button type="button" class="toggle-password-btn" data-target="confirm_password" title="Show password">👁️</button>
                        </div>
                        <div class="field-error" id="confirm_password_error"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top: 12px;">
                    Complete Registration &rarr;
                </button>
            </form>

            <div class="auth-footer-links">
                Already registered with ApexCorp? <a href="login.php"><strong>Sign In Here</strong></a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
