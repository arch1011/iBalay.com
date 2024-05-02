<?php
include './../connect_db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomID = $_POST['roomID'];

    $deleteReservationQuery = "DELETE FROM reservation WHERE RoomID = '$roomID'";

    if (mysqli_query($conn, $deleteReservationQuery)) {
        header("Location: https://ibalay-project.000webhostapp.com/iBalay.com/iBalay/Reserved_Rooms/reserved_room.php");
        exit();
    } else {
        echo "Error: " . $deleteReservationQuery . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}

mysqli_close($conn);
?>
