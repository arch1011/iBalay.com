<?php
// Include the database connection
include 'connect_db/connection.php';

// Assuming you have the TenantID stored in the session
session_start();
$tenantID = $_SESSION['TenantID'];

// Get the RoomID from the button click
if (isset($_POST['roomID'])) {
    $roomID = $_POST['roomID'];

    // Insert a reservation record into the 'reservation' table
    $insertReservationQuery = "INSERT INTO reservation (RoomID, TenantID, ReservationDate, ReservedDate, OwnerID) 
                              VALUES ('$roomID', '$tenantID', CURDATE(), CURDATE(), (SELECT OwnerID FROM room WHERE RoomID = '$roomID'))";
    
    if (mysqli_query($conn, $insertReservationQuery)) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $insertReservationQuery . "<br>" . mysqli_error($connection);
    }
} else {
    echo "Error: RoomID not set.";
}

// Close the database connection
mysqli_close($conn);
?>
