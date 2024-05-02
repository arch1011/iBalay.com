<?php
include '../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inquiryID = isset($_POST['inquiryID']) ? intval($_POST['inquiryID']) : 0;
    $replyMessage = isset($_POST['replyMessage']) ? htmlspecialchars($_POST['replyMessage']) : '';

    $checkInquiryQuery = "SELECT InquiryID FROM inquiry WHERE InquiryID = ?";
    $checkInquiryStmt = $conn->prepare($checkInquiryQuery);
    $checkInquiryStmt->bind_param('i', $inquiryID);
    $checkInquiryStmt->execute();
    $checkInquiryResult = $checkInquiryStmt->get_result();

    if ($checkInquiryResult->num_rows > 0) {
        $insertReplyQuery = "INSERT INTO reply (InquiryID, ReplyMessage, ReplyDate) VALUES (?, ?, NOW())";
        $insertReplyStmt = $conn->prepare($insertReplyQuery);
        $insertReplyStmt->bind_param('is', $inquiryID, $replyMessage);

        if ($insertReplyStmt->execute()) {
            header("Location: inquiry_page.php");
        } else {
            echo "Error: " . $insertReplyStmt->error;
        }
        $insertReplyStmt->close();
    } else {
        echo "Error: InquiryID not found.";
    }
    $checkInquiryStmt->close();
    $conn->close();
}
?>
