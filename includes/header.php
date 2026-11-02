<?php
// includes/header.php - Shared Navigation & Header
require_once __DIR__ . '/../config.php';
$currentUser = current_user();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="navbar">
    <div class="container">
        <a href="index.php" class="nav-brand">
            <span class="brand-logo-icon">🏢</span>
            <span>Apex<span class="highlight">Corp</span></span>
        </a>

        <ul class="nav-links">
            <li><a href="index.php" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="index.php#portal-matrix">Portal Matrix</a></li>
            <?php if ($currentUser): ?>
                <li><a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>
            <?php endif; ?>
        </ul>

        <div class="nav-auth-btns">
            <?php if ($currentUser): ?>
                <div class="user-badge-pill">
                    <span>👋 <?php echo htmlspecialchars($currentUser['fullname']); ?></span>
                    <span class="role-tag <?php echo htmlspecialchars($currentUser['role']); ?>">
                        <?php echo strtoupper(htmlspecialchars($currentUser['role'])); ?>
                    </span>
                </div>
                <a href="dashboard.php" class="btn btn-primary btn-sm">Directory</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-secondary btn-sm">Login</a>
                <a href="register.php" class="btn btn-primary btn-sm">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="main-content">
<?php
// Display flash messages if any
$flashSuccess = flash_message('success');
$flashError = flash_message('error');
if ($flashSuccess || $flashError):
?>
    <div class="container" style="margin-top: 20px;">
        <?php if ($flashSuccess): ?>
            <div class="alert alert-success">✓ <?php echo htmlspecialchars($flashSuccess); ?></div>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <div class="alert alert-danger">✕ <?php echo htmlspecialchars($flashError); ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
