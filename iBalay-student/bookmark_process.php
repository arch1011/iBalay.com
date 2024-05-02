<?php
// Start the session
session_start();
// Assuming you have a database connection established
include 'connect_db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the RoomID and TenantID from the POST data
    $roomID = $_POST["roomID"];

    // Check if TenantID is set in the session
    if (isset($_SESSION["TenantID"])) {
        $tenantID = $_SESSION["TenantID"];

        // Insert a new record into the bookmark table
        $sql = "INSERT INTO bookmark (TenantID, RoomID) VALUES ($tenantID, $roomID)";

        if ($conn->query($sql) === TRUE) {
            echo "Bookmark added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Handle the case when TenantID is not set in the session
        echo "Error: TenantID is not set in the session";
    }
}

// Close the database connection
$conn->close();
?>
