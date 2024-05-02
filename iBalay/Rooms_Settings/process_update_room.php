<?php
session_start(); 
// Include your database connection code
include './../connect_db/connection.php';

$roomID = $_POST['roomID']; // Assuming roomID is sent via POST

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $boardingHouseName = mysqli_real_escape_string($conn, $_POST['BoardingHouseName']);
    $roomNumber = mysqli_real_escape_string($conn, $_POST['RoomNumber']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $capacity = mysqli_real_escape_string($conn, $_POST['Capacity']);
    $category = mysqli_real_escape_string($conn, $_POST['Category']);
    $barangay = mysqli_real_escape_string($conn, $_POST['Barangay']);
    $availability = ($_POST['Availability'] == '1') ? 1 : 0;
    $price = mysqli_real_escape_string($conn, $_POST['Price']);

    // Retrieve location data and split into latitude and longitude
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    list($latitude, $longitude) = explode(',', $location);

    // Get the existing room data from the database
    $selectQuery = "SELECT * FROM room WHERE RoomID = '$roomID'";
    $result = mysqli_query($conn, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Use existing values if user didn't change them
        $boardingHouseName = empty($boardingHouseName) ? $row['BoardingHouseName'] : $boardingHouseName;
        $roomNumber = empty($roomNumber) ? $row['RoomNumber'] : $roomNumber;
        $description = empty($description) ? $row['Description'] : $description;
        $capacity = empty($capacity) ? $row['Capacity'] : $capacity;
        $category = empty($category) ? $row['Category'] : $category;
        $barangay = empty($barangay) ? $row['Barangay'] : $barangay;
        $availability = empty($availability) ? $row['Availability'] : $availability;
        $price = empty($price) ? $row['Price'] : $price;
        $latitude = empty($latitude) ? $row['Latitude'] : $latitude;
        $longitude = empty($longitude) ? $row['Longitude'] : $longitude;
    }

    // Get the owner ID from the session
    $ownerID = $_SESSION['owner_id'];

    // Handle file uploads for required photos
    $requiredPhotos = $_FILES['photos'];
    $requiredPhotosPaths = [];

    // Check if the required photos are uploaded
    foreach ($requiredPhotos['error'] as $key => $error) {
        if ($error === UPLOAD_ERR_OK) {
            // Handle file upload logic for required photos
            // Make sure to validate and sanitize the file before storing it
            $requiredPhotosPath = '/iBalay.com/uploads/room-photos-' . $ownerID . '/' . basename($requiredPhotos['name'][$key]);
            move_uploaded_file($requiredPhotos['tmp_name'][$key], $_SERVER['DOCUMENT_ROOT'] . $requiredPhotosPath);
            $requiredPhotosPaths[] = $requiredPhotosPath;
        }
    }

    // Check if optional photos are uploaded
    if (!empty($_FILES['optionalPhotos'])) {
        $optionalPhotos = $_FILES['optionalPhotos'];
        $optionalPhotosPaths = [];

        // Handle file uploads for optional photos
        foreach ($optionalPhotos['error'] as $key => $error) {
            if ($error === UPLOAD_ERR_OK) {
                // Handle file upload logic for optional photos
                // Make sure to validate and sanitize the file before storing it
                $optionalPhotosPath = '/iBalay.com/uploads/room-photos-' . $ownerID . '/' . basename($optionalPhotos['name'][$key]);
                move_uploaded_file($optionalPhotos['tmp_name'][$key], $_SERVER['DOCUMENT_ROOT'] . $optionalPhotosPath);
                $optionalPhotosPaths[] = $optionalPhotosPath;
            }
        }

        // Combine the paths into a single string or store them as needed in your database
        $optionalPhotosString = implode(',', $optionalPhotosPaths);
    }

    // Combine required and optional photo paths
    $requiredPhotosString = implode(',', $requiredPhotosPaths);
    $allPhotosString = $requiredPhotosString . (!empty($requiredPhotosString) && !empty($optionalPhotosString) ? ',' : '') . $optionalPhotosString;

    // Update room information in the database
    $updateQuery = "UPDATE room SET
        BoardingHouseName = '$boardingHouseName',
        RoomNumber = '$roomNumber',
        Description = '$description',
        Capacity = '$capacity',
        Category = '$category',
        Barangay = '$barangay',
        Availability = '$availability',
        Price = '$price',
        Latitude = '$latitude', 
        Longitude = '$longitude'";
    
    // Only update Photos field if new photos are uploaded
    if (!empty($allPhotosString)) {
        $updateQuery .= ", Photos = '$allPhotosString'";
    }
    
    $updateQuery .= " WHERE RoomID = '$roomID'";

    if (mysqli_query($conn, $updateQuery)) {
        // You may redirect the user to a success page or perform additional actions
        header("Location: update_room.php?success=1");
        exit();
    } else {
        echo "Error updating room: " . mysqli_error($conn);
        // You may redirect the user back to the form or show an error message
        header("Location: /iBalay.com/iBalay/Rooms_Settings/update_room.php");
        exit();
    }
}
?>
