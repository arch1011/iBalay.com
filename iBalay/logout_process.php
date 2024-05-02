<?php
// Start session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
$redirect_url = "/iBalay.com/iBalay/login_page/pages-login.php";
header("Location: $redirect_url");
exit();
?>
