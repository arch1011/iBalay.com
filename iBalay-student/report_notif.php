<?php
// Start session if not already started
session_start();

// Check if the tenant ID is set in the session
if (isset($_SESSION['TenantID'])) {
    // Assign the tenant ID from the session to the $tenantID variable
    $tenantID = $_SESSION['TenantID'];

    // Include database connection
    include 'connect_db/connection.php';

    // Handle update action
    if (isset($_GET['action']) && $_GET['action'] === 'update_notified') {
        // Update the Notified column to 1 for the logged-in tenant's unnotified reports
        $updateQuery = "UPDATE report SET Notified = 1 WHERE TenantID = $tenantID AND Notified = 0";
        mysqli_query($conn, $updateQuery);
        header("Location: /iBalay.com/iBalay-student/report_page.php");
        exit;
    }
} else {
    // Handle the case when the tenant ID is not set in the session
    // You may redirect the user to a login page or handle the situation accordingly
    echo "Tenant ID not found in session!";
}
?>
