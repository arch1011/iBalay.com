<?php
// Start a session to manage user login state
session_start();

// Check if the user is logged in
if (isset($_SESSION['TenantID'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other desired page after logout
    header("Location: login.php"); // Replace with your login page URL
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php"); // Replace with your login page URL
    exit();
}
?>
