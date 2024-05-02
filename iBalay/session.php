<?php
session_start();
include 'connect_db/connection.php';
// Check if the ownerID is set in the session
if (!isset($_SESSION['owner_id'])) {
    // If not set, redirect to the login page
    header("Location: /iBalay.com/iBalay/login_page/pages-login.php");
    exit();
}

$ownerID = $_SESSION['owner_id'];
?>