<?php
// Start the session
session_start();

// Assuming you have a database connection established
include 'connect_db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the BookmarkID from the POST data
    $bookmarkID = $_POST["bookmarkID"];

    // Check if BookmarkID is valid
    if (!empty($bookmarkID)) {
        // Delete the bookmark record from the database
        $sql = "DELETE FROM bookmark WHERE BookmarkID = $bookmarkID";

        if ($conn->query($sql) === TRUE) {
            echo "Bookmark deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Handle the case when BookmarkID is empty or not provided
        echo "Error: BookmarkID is empty or not provided";
    }
}

// Close the database connection
$conn->close();
?>
