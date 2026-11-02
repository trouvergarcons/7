<?php
// dashboard.php - Role-Based Directory Viewer
// Condition:
// If employee login -> authenticate & view all Admin details
// If admin login -> authenticate & view all Employee details

require_once __DIR__ . '/config.php';

// Authentication Guard
if (!is_logged_in()) {
    $_SESSION['error'] = "Access denied. Please log in to view the personnel directory.";
    header('Location: login.php');
    exit;
}

$currentUser = current_user();
$myRole = $currentUser['role'];

// Determine which records to fetch based on user's role
if ($myRole === 'employee') {
    $targetRole = 'admin';
    $directoryTitle = "Corporate Administration & Executive Leadership";
    $directoryDescription = "You are logged in as an <strong>Employee</strong>. As per system policy, your dashboard displays all registered <strong>Administrators</strong> and executive leaders.";
    $viewingLabel = "All Administrator Profiles";
    $badgeStyle = "badge-viewing-admin";
    $targetBadgeClass = "badge-admin";
    $targetRoleTitle = "Admin";
} else { // 'admin'
    $targetRole = 'employee';
    $directoryTitle = "Corporate Staff & Employee Directory";
    $directoryDescription = "You are logged in as an <strong>Administrator</strong>. As per system policy, your dashboard displays all registered <strong>Employees</strong> across all corporate departments.";
    $viewingLabel = "All Employee Profiles";
    $badgeStyle = "badge-viewing-employee";
    $targetBadgeClass = "badge-employee";
    $targetRoleTitle = "Employee";
}

// Fetch all target records from the database
$stmt = mysqli_prepare($conn, "SELECT `id`, `fullname`, `email`, `role`, `department`, `designation`, `phone`, `location`, `created_at` FROM `users` WHERE `role` = ? ORDER BY `fullname` ASC");
mysqli_stmt_bind_param($stmt, 's', $targetRole);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$records = [];
$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $records[] = $row;
    if (!empty($row['department']) && !in_array($row['department'], $departments)) {
        $departments[] = $row['department'];
    }
}
mysqli_stmt_close($stmt);
sort($departments);

$pageTitle = ($myRole === 'employee') ? 'Admin Directory (Employee View)' : 'Employee Directory (Admin View)';
$includeDashboardJs = true;

require_once __DIR__ . '/includes/header.php';
?>

<!-- User Profile Hero Bar -->
<div class="dashboard-header">
    <div class="container dashboard-header-inner">
        <div class="user-profile-summary">
            <div class="user-avatar-circle <?php echo htmlspecialchars($myRole); ?>">
                <?php echo strtoupper(substr($currentUser['fullname'], 0, 1)); ?>
            </div>
            <div class="user-info-text">
                <h1>Welcome, <?php echo htmlspecialchars($currentUser['fullname']); ?></h1>
                <p>
                    <strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($myRole)); ?> | 
                    <strong>Department:</strong> <?php echo htmlspecialchars($currentUser['department'] ?: 'General'); ?> | 
                    <strong>Designation:</strong> <?php echo htmlspecialchars($currentUser['designation'] ?: 'Staff Member'); ?>
                </p>
            </div>
        </div>

        <div>
            <a href="logout.php" class="btn btn-danger btn-sm">
                <span>Sign Out</span>
            </a>
        </div>
    </div>
</div>

<div class="container">
    <!-- Condition Notification Banner -->
    <div class="condition-banner <?php echo ($myRole === 'employee') ? 'employee-view' : 'admin-view'; ?>">
        <div class="condition-text">
            <h3><?php echo ($myRole === 'employee') ? '🔒 Employee Mode Active' : '👑 Administrator Mode Active'; ?></h3>
            <p><?php echo $directoryDescription; ?></p>
        </div>
        <div>
            <span class="condition-badge <?php echo $badgeStyle; ?>">
                Viewing: <?php echo $viewingLabel; ?> (<span id="resultCount"><?php echo count($records); ?></span>)
            </span>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: <?php echo ($myRole === 'employee') ? '#f5f3ff' : '#f0f9ff'; ?>; color: <?php echo ($myRole === 'employee') ? '#7c3aed' : '#0284c7'; ?>; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="fa-solid <?php echo ($myRole === 'employee') ? 'fa-crown' : 'fa-users'; ?>"></i>
            </div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: var(--secondary-card); line-height: 1.2;"><?php echo count($records); ?></div>
                <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Total <?php echo $targetRoleTitle; ?>s</div>
            </div>
        </div>

        <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: var(--secondary-card); line-height: 1.2;"><?php echo count($departments); ?></div>
                <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Departments</div>
            </div>
        </div>

        <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="fa-solid fa-database"></i>
            </div>
            <div>
                <div style="font-size: 1.2rem; font-weight: 800; color: #065f46; line-height: 1.2;">Port <?php echo htmlspecialchars($active_port); ?></div>
                <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">MariaDB Database</div>
            </div>
        </div>

        <div style="background: white; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div style="font-size: 1.2rem; font-weight: 800; color: var(--secondary-card); line-height: 1.2;"><?php echo ucfirst($myRole); ?> View</div>
                <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Active Session</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="filter-bar">
        <div class="search-input-wrapper">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" id="directorySearch" placeholder="Search by name, email, designation, or location...">
        </div>

        <div class="filter-actions">
            <select id="departmentFilter" class="filter-select">
                <option value="all">All Departments (<?php echo count($departments); ?>)</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?php echo htmlspecialchars(strtolower($dept)); ?>"><?php echo htmlspecialchars($dept); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="button" class="btn btn-secondary btn-sm" onclick="exportDirectoryCSV()" title="Export list to CSV" style="color: var(--secondary-card); background: #f8fafc; border: 1.5px solid var(--border-color);">
                <i class="fa-solid fa-file-arrow-down"></i> CSV Export
            </button>

            <!-- Quick Demo Switcher -->
            <?php if ($myRole === 'employee'): ?>
                <form action="login.php" method="POST" style="display: inline;">
                    <input type="hidden" name="email" value="admin@apexcorp.com">
                    <input type="hidden" name="password" value="Admin@123">
                    <button type="submit" class="btn btn-sm" style="background: var(--admin-gradient); color: white; border: none;" title="Switch to Admin login demo">
                        <i class="fa-solid fa-crown"></i> Switch to Admin
                    </button>
                </form>
            <?php else: ?>
                <form action="login.php" method="POST" style="display: inline;">
                    <input type="hidden" name="email" value="john.dev@apexcorp.com">
                    <input type="hidden" name="password" value="Emp@123">
                    <button type="submit" class="btn btn-sm" style="background: var(--emp-gradient); color: white; border: none;" title="Switch to Employee login demo">
                        <i class="fa-solid fa-user"></i> Switch to Employee
                    </button>
                </form>
            <?php endif; ?>
    </div>

    <!-- Directory Cards Grid -->
    <div class="directory-grid" id="directoryGrid">
        <?php if (empty($records)): ?>
            <div class="empty-directory" id="emptyDirectoryState">
                <div class="empty-icon">📂</div>
                <h3>No <?php echo htmlspecialchars($targetRoleTitle); ?> Profiles Found</h3>
                <p style="color: #64748b;">There are currently no records with role '<?php echo htmlspecialchars($targetRole); ?>' in the database.</p>
                <a href="register.php" class="btn btn-primary" style="margin-top: 16px;">Register New <?php echo htmlspecialchars($targetRoleTitle); ?></a>
            </div>
        <?php else: ?>
            <?php foreach ($records as $person): ?>
                <?php 
                $personJson = htmlspecialchars(json_encode($person), ENT_QUOTES, 'UTF-8');
                $initials = strtoupper(substr($person['fullname'], 0, 1));
                ?>
                <div class="person-card" 
                     data-name="<?php echo htmlspecialchars($person['fullname']); ?>"
                     data-email="<?php echo htmlspecialchars($person['email']); ?>"
                     data-designation="<?php echo htmlspecialchars($person['designation']); ?>"
                     data-department="<?php echo htmlspecialchars($person['department']); ?>"
                     data-location="<?php echo htmlspecialchars($person['location']); ?>">
                    
                    <div class="person-card-header">
                        <div class="person-avatar <?php echo htmlspecialchars($person['role']); ?>">
                            <?php echo $initials; ?>
                        </div>
                        <div class="person-name-box">
                            <h3><?php echo htmlspecialchars($person['fullname']); ?></h3>
                            <div class="person-designation"><?php echo htmlspecialchars($person['designation']); ?></div>
                            <span class="badge <?php echo $targetBadgeClass; ?>" style="margin-top: 4px;">
                                <?php echo strtoupper(htmlspecialchars($person['role'])); ?>
                            </span>
                        </div>
                    </div>

                    <ul class="person-details-list">
                        <li>
                            <strong>Department:</strong>
                            <span><?php echo htmlspecialchars($person['department']); ?></span>
                        </li>
                        <li>
                            <strong>Email:</strong>
                            <a href="mailto:<?php echo htmlspecialchars($person['email']); ?>">
                                <?php echo htmlspecialchars($person['email']); ?>
                            </a>
                        </li>
                        <li>
                            <strong>Phone:</strong>
                            <a href="tel:<?php echo htmlspecialchars($person['phone']); ?>">
                                <?php echo htmlspecialchars($person['phone']); ?>
                            </a>
                        </li>
                        <li>
                            <strong>Location:</strong>
                            <span><?php echo htmlspecialchars($person['location']); ?></span>
                        </li>
                    </ul>

                    <div class="person-card-footer">
                        <button type="button" class="btn btn-outline btn-sm btn-block" onclick="openProfileModal(<?php echo $personJson; ?>)">
                            <span>View Full Profile</span> ↗
                        </button>
                        <a href="mailto:<?php echo htmlspecialchars($person['email']); ?>" class="btn btn-primary btn-sm" title="Send Email">
                            ✉️ Contact
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="empty-directory" id="emptyDirectoryState" style="display: none;">
                <div class="empty-icon">🔎</div>
                <h3>No Matching Profiles</h3>
                <p style="color: #64748b;">No <?php echo htmlspecialchars($targetRoleTitle); ?> profiles matched your search or department filter.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal for Profile Details -->
<div class="modal-overlay" id="profileModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 1.15rem;">Personnel Dossier</h3>
            <button type="button" class="modal-close-btn" id="closeModalBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 id="modalName" style="margin-bottom: 4px; color: var(--secondary);">Full Name</h2>
                <div id="modalDesignation" style="font-weight: 600; color: var(--primary); margin-bottom: 8px;">Designation</div>
                <span id="modalRoleBadge" class="badge">ROLE</span>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 0.92rem;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px 0; color: var(--text-muted); font-weight: 600; width: 35%;">Department</td>
                    <td id="modalDepartment" style="padding: 10px 0; font-weight: 500;">-</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px 0; color: var(--text-muted); font-weight: 600;">Email Address</td>
                    <td style="padding: 10px 0;"><a id="modalEmailLink" href="#"><span id="modalEmail">-</span></a></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px 0; color: var(--text-muted); font-weight: 600;">Contact Phone</td>
                    <td style="padding: 10px 0;"><a id="modalPhoneLink" href="#"><span id="modalPhone">-</span></a></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 10px 0; color: var(--text-muted); font-weight: 600;">Office Location</td>
                    <td id="modalLocation" style="padding: 10px 0; font-weight: 500;">-</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: var(--text-muted); font-weight: 600;">Registered Since</td>
                    <td id="modalJoined" style="padding: 10px 0; font-weight: 500;">-</td>
                </tr>
            </table>

            <div style="margin-top: 24px; text-align: right;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('profileModal').classList.remove('active')">Close</button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
