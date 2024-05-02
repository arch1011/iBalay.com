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
        // Update the Notified column to 1 for the logged-in tenant's relevant inquiries
        $updateQuery = "UPDATE reply 
                        INNER JOIN inquiry ON reply.InquiryID = inquiry.InquiryID 
                        SET reply.Notified = 1 
                        WHERE inquiry.TenantID = $tenantID 
                        AND reply.ReplyMessage IS NOT NULL 
                        AND reply.Notified = 0";
        mysqli_query($conn, $updateQuery);

        // Redirect to inquiry_page.php after updating
        header("Location: /iBalay.com/iBalay-student/inquiry_page.php");
        exit;
    }
} else {
    // Redirect to login page if tenant ID is not set in the session
    header("Location: /iBalay.com/iBalay-student/login.php");
    exit;
}
?>
