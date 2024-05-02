<?php
include './../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount'], $_POST['dueDate'], $_POST['tenantID'])) {
    // Get data from the form
    $tenantID = $_POST['tenantID'];
    $amount = $_POST['amount'];
    $dueDate = $_POST['dueDate'];

    // Example: Insert payment into the database
    $insertPaymentQuery = "INSERT INTO payment (RoomID, TenantID, OwnerID, Amount, DueDate, PaymentDate, IsFirstPayment) VALUES ";
    $insertPaymentQuery .= "((SELECT RoomID FROM tenant WHERE TenantID = $tenantID), $tenantID, (SELECT OwnerID FROM room WHERE RoomID = (SELECT RoomID FROM tenant WHERE TenantID = $tenantID)), $amount, '$dueDate', NOW(), 0)";
    $insertPaymentResult = mysqli_query($conn, $insertPaymentQuery);

    if ($insertPaymentResult) {
        // Record payment history
        $paymentID = mysqli_insert_id($conn); // Get the last inserted payment ID
        $insertPaymentHistoryQuery = "INSERT INTO payment_history (PaymentID, RoomID, TenantID, OwnerID, Amount, DueDate, PaymentDate, IsFirstPayment) ";
        $insertPaymentHistoryQuery .= "VALUES ($paymentID, (SELECT RoomID FROM tenant WHERE TenantID = $tenantID), $tenantID, (SELECT OwnerID FROM room WHERE RoomID = (SELECT RoomID FROM tenant WHERE TenantID = $tenantID)), $amount, '$dueDate', NOW(), 0)";
        mysqli_query($conn, $insertPaymentHistoryQuery);

        // Redirect after successful payment
        header("Location: /iBalay.com/iBalay/tenant_options/tenant_payments.php");
        exit();
    } else {
        // Payment failed
        echo "<div class='alert alert-danger mt-3' role='alert'>Payment failed. Please try again.</div>";
    }
} else {
    // If form data is not received via POST, redirect to an error page
    header("Location: /iBalay/pages-error-404.php");
    exit();
}
?>
