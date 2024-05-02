<?php
include 'connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $roomID = $_POST['roomID'];
    $tenantID = $_POST['tenantID'];
    $ownerID = $_POST['ownerID']; // Retrieve ownerID
    $message = $_POST['message'];

    // Insert inquiry into the database
    $insertQuery = "INSERT INTO inquiry (RoomID, TenantID, OwnerID, Message, InquiryDate) 
                    VALUES ($roomID, $tenantID, $ownerID, '$message', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        // Redirect to inquiry_page.php upon successful inquiry
        header("Location: /iBalay.com/iBalay-student/inquiry_page.php");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo 'Error occurred while sending inquiry: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo 'Invalid request method.';
}
?>
