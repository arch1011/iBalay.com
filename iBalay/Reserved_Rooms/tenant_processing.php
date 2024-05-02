<?php
include './../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomID = $_POST['roomID'];
    $amount = $_POST['amount'];
    $dueDate = $_POST['dueDate'];
    $isFirstPayment = isset($_POST['isFirstPayment']) ? 1 : 0;

    // Fetch room details
    $roomQuery = "SELECT * FROM room WHERE RoomID = $roomID";
    $roomResult = mysqli_query($conn, $roomQuery);
    $room = mysqli_fetch_assoc($roomResult);

    // Fetch reservation details
    $reservationQuery = "SELECT * FROM reservation WHERE RoomID = $roomID";
    $reservationResult = mysqli_query($conn, $reservationQuery);
    $reservation = mysqli_fetch_assoc($reservationResult);

    // Fetch tenant details
    $tenantID = $reservation['TenantID'];
    $tenantQuery = "SELECT * FROM tenant WHERE TenantID = $tenantID";
    $tenantResult = mysqli_query($conn, $tenantQuery);
    $tenant = mysqli_fetch_assoc($tenantResult);

    // Update tenant information
    $updateTenantQuery = "UPDATE tenant SET OwnerID = {$room['OwnerID']}, RoomID = $roomID, checked_out = 0 WHERE TenantID = {$reservation['TenantID']}";
    mysqli_query($conn, $updateTenantQuery);

    // Insert owner information (if not already exists)
    $ownerID = $room['OwnerID'];
    $checkOwnerQuery = "SELECT * FROM owners WHERE owner_id = $ownerID";
    $checkOwnerResult = mysqli_query($conn, $checkOwnerQuery);

    if (mysqli_num_rows($checkOwnerResult) == 0) {
        $insertOwnerQuery = "INSERT INTO owners (owner_id, username, password, name, contact_number, email, photo, location) 
                             VALUES ($ownerID, '{$room['OwnerID']}', 'password', '{$room['BoardingHouseName']} Owner', '123456789', 'owner@example.com', '', 'Location')";
        mysqli_query($conn, $insertOwnerQuery);
    }

    // Insert tenant check-in history
    // $insertTenantHistoryQuery = "INSERT INTO tenant_history (TenantID, OwnerID) VALUES ($tenantID, $ownerID)";
   // mysqli_query($conn, $insertTenantHistoryQuery);

    // Insert payment information
    $insertPaymentQuery = "INSERT INTO payment (RoomID, TenantID, OwnerID, Amount, DueDate, PaymentDate, IsFirstPayment) 
                           VALUES ($roomID, {$reservation['TenantID']}, $ownerID, $amount, '$dueDate', NULL, $isFirstPayment)";
    mysqli_query($conn, $insertPaymentQuery);

    // Insert payment information into payment history
    $paymentID = mysqli_insert_id($conn);
    $insertPaymentHistoryQuery = "INSERT INTO payment_history (PaymentID, RoomID, TenantID, OwnerID, Amount, DueDate, PaymentDate, IsFirstPayment) 
                                  VALUES ($paymentID, $roomID, {$reservation['TenantID']}, $ownerID, $amount, '$dueDate', NULL, $isFirstPayment)";
    mysqli_query($conn, $insertPaymentHistoryQuery);

    // Update room capacity
    $updatedCapacity = $room['Capacity'] - 1;
    $updateCapacityQuery = "UPDATE room SET Capacity = $updatedCapacity WHERE RoomID = $roomID";
    mysqli_query($conn, $updateCapacityQuery);

    // Delete reserved room
    $deleteReservationQuery = "DELETE FROM reservation WHERE RoomID = $roomID";
    mysqli_query($conn, $deleteReservationQuery);

    // You can add additional logic or redirects as needed
    header("Location: /iBalay.com/iBalay/tenant_options/tenant_list.php"); // Replace with your actual dashboard page URL
} else {
    // Redirect or handle the case when the form is not submitted via POST
    header("Location: http://localhost/iBalay/pages-error-404.php");
    exit();
}
?>
