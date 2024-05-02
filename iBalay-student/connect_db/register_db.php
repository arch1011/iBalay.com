<?php
// Database configuration
$db_host = 'localhost';      // Your database host
$db_user = 'root';  // Your database username
$db_pass = '';  // Your database password
$db_name = 'ibalay_database'; // Your database name

// Create a database connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
