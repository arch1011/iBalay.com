<?php
session_start();

include 'connect_db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationID = $_POST["reservationID"];

    if (!empty($reservationID)) {
        $sql = "DELETE FROM reservation WHERE ReservationID = $reservationID";

        if ($conn->query($sql) === TRUE) {
            // Reservation canceled successfully, redirect to reserved_bh.php
            header("Location: /iBalay.com/iBalay-student/reserved_bh.php");
            exit; // Stop further execution
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: ReservationID is empty or not provided";
    }
}

$conn->close();
?>
