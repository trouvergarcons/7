<?php
// logout.php - Session Termination
require_once __DIR__ . '/config.php';

// Unset all session variables
$_SESSION = [];

// Destroy session cookie if present
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Start fresh session for flash message
session_start();
$_SESSION['success'] = "You have been successfully logged out.";

header('Location: login.php');
exit;
