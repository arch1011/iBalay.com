<?php
include 'connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the owner ID from the POST data
    $ownerId = $_POST['ownerId'];

    // Update the approval status in the database
    $updateQuery = "UPDATE owners SET approval_status = 2 WHERE owner_id = $ownerId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'Owner disapproved successfully';
    } else {
        echo 'Error disapproving owner: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request method';
}
?>
