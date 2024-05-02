<?php
include 'connect_db/connection.php';

$roomID = $_POST['roomID'];
$tenantID = $_POST['tenantID'];

// Check if the room is already reserved by the tenant
$query = "SELECT * FROM reservation WHERE RoomID = $roomID AND TenantID = $tenantID";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Room is already reserved by the tenant
    echo "already_reserved";
} else {
    // Check if the tenant already has a reserved room
    $existingReservationQuery = "SELECT * FROM reservation WHERE TenantID = $tenantID";
    $existingReservationResult = mysqli_query($conn, $existingReservationQuery);

    if (mysqli_num_rows($existingReservationResult) > 0) {
        // Tenant already has a reserved room
        echo "existing_reserved";
    } else {
        // Room is not reserved, and the tenant does not have an existing reserved room
        echo "not_reserved";
    }
}

mysqli_close($conn);
?>
