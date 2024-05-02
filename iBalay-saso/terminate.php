<?php
// Include your database connection file
include 'connect_db/connection.php';

// Get the owner ID from the POST request
$ownerId = $_POST['owner_id'];

// Perform the database update query to set disable to 1
$sql = "UPDATE owners SET close_account = 1 WHERE owner_id = '$ownerId'";

if (mysqli_query($conn, $sql)) {
    // Close the database connection
    mysqli_close($conn);
    
    // Redirect to owner-list-warning.php
    header("Location: /iBalay.com/iBalay-saso/owner-list-warning.php");
    exit();
} else {
    // If there is an error in the query, send an error response
    echo json_encode(array('success' => false, 'message' => 'Error disabling owner: ' . mysqli_error($conn)));
}

// Close the database connection
mysqli_close($conn);

?>
