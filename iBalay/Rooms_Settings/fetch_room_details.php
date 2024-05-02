<?php
// Include your database connection code
include './../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected room ID from the POST data
    $selectedRoomID = $_POST['roomID'];

    // Fetch room details from the database
    $query = "SELECT * FROM room WHERE RoomID = $selectedRoomID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the room details as an associative array
        $roomDetails = mysqli_fetch_assoc($result);

        // Convert the array to JSON format
        $jsonResponse = json_encode($roomDetails);

        // Return the JSON response
        echo $jsonResponse;
    } else {
        // Room not found
        echo json_encode(['error' => 'Room not found']);
    }
} else {
    // Invalid request method
    echo json_encode(['error' => 'Invalid request method']);
}

// Close the database connection
mysqli_close($conn);
?>
