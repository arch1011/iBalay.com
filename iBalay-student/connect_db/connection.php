<?php
// Database configuration
$db_host = 'localhost';      // Your database host
$db_user = 'root';  // Your database username
$db_pass = '';  // Your database password
$db_name = 'ibalay_database'; // Your database name

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>