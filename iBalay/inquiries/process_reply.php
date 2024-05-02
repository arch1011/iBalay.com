<?php
include '../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inquiryID = $_POST['inquiryID'];
    $replyMessage = $_POST['replyMessage'];

    $insertQuery = "INSERT INTO inquiry (RoomID, TenantID, OwnerID, Message, Reply, InquiryDate) 
                    SELECT RoomID, TenantID, OwnerID, '', ?, NOW() 
                    FROM inquiry 
                    WHERE InquiryID = ?";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'si', $replyMessage, $inquiryID);
    $success = mysqli_stmt_execute($stmt);
                if ($success) {
                    echo 'Reply sent successfully.';
                    
                    // Redirect to inquiry_page.php after a successful reply
                    header('ibalay-project.000webhostapp.com/iBalay.com/iBalay/inquiries/inquiry_page.php');
                    exit;
                } else {
                    echo 'Error inserting the reply: ' . mysqli_error($conn);
                }
            mysqli_stmt_close($stmt);
            } else {
                header('Location: error.php');
                exit;
           }

mysqli_close($conn);
?>
