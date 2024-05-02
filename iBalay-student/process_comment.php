<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection code
    include 'connect_db/connection.php';

    // Get data from the form
    $roomID = $_POST['roomID'];
    $tenantID = $_POST['tenantID'];
    $commentText = $_POST['commentText'];
    $rating = $_POST['rating'];
    $crRating = $_POST['crRating']; // New CR rating
    $coBoardersRating = $_POST['coBoardersRating']; // New co-boarders rating
    $ownerRating = $_POST['ownerRating']; // New owner rating

    // Check if the tenant has already submitted a comment for this room
    $existingCommentQuery = "SELECT CommentID FROM comment WHERE RoomID = '$roomID' AND TenantID = '$tenantID'";
    $existingCommentResult = mysqli_query($conn, $existingCommentQuery);

    if (mysqli_num_rows($existingCommentResult) > 0) {
        // Tenant has already submitted a comment for this room
        echo json_encode(['error' => 'You have already submitted a comment for this room.']);
    } else {
        // Perform SQL insertion for comments
        $insertCommentQuery = "INSERT INTO comment (RoomID, TenantID, CommentText, Rating, CrRating, CoBoardersRating, OwnerRating) 
                                VALUES ('$roomID', '$tenantID', '$commentText', '$rating', '$crRating', '$coBoardersRating', '$ownerRating')";

        if (mysqli_query($conn, $insertCommentQuery)) {
            // Comment insertion successful
            echo json_encode(['success' => 'Comment submitted successfully.']);
        } else {
            // Comment insertion failed
            echo json_encode(['error' => 'Error in SQL query: ' . mysqli_error($conn)]);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}

?>
