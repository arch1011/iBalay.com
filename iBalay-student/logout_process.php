<?php
// Start a session to manage user login state
session_start();
// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['TenantID'])) {
    header("Location: login.php");
    exit();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: login.php");
exit();
?>
