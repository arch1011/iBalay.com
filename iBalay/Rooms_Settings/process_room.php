<?php
session_start();
// Include your database connection code
include './../connect_db/connection.php';

$ownerID = $_SESSION['owner_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $boardingHouseName = mysqli_real_escape_string($conn, $_POST['boardingHouseName']);
    $roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $municipality = "Tanauan"; // Set default value for municipality
    $availability = ($_POST['availability'] == '1') ? 1 : 0;
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Retrieve location data and split into latitude and longitude
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    list($latitude, $longitude) = explode(',', $location);

    // Create a folder for the owner if it doesn't exist
    $ownerPhotosFolder = __DIR__ . '/../../uploads/room-photos-' . $ownerID . '/';
    if (!is_dir($ownerPhotosFolder)) {
        mkdir($ownerPhotosFolder, 0777, true);
    }

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

    // Handle file uploads for optional photos
    $optionalPhotos = $_FILES['optionalPhotos'];
    $optionalPhotosPaths = [];

    // Check if optional photos are uploaded
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
    $requiredPhotosString = implode(',', $requiredPhotosPaths);
    $optionalPhotosString = implode(',', $optionalPhotosPaths);

    // Combine required and optional photo paths
    $allPhotosString = $requiredPhotosString . ',' . $optionalPhotosString;

    // Insert data into the database
    $insertQuery = "INSERT INTO room (ownerID, boardingHouseName, roomNumber, description, capacity, category, barangay, municipality, availability, price, photos, Latitude, Longitude) 
                    VALUES ('$ownerID', '$boardingHouseName', '$roomNumber', '$description', '$capacity', '$category', '$barangay', '$municipality', '$availability', '$price', '$allPhotosString', '$latitude', '$longitude')";

    if (mysqli_query($conn, $insertQuery)) {
        // You may redirect the user to a success page or perform additional actions
        header("Location: add-room.php?success=1");
        exit();
    } else {
        // Log the error
        $error_message = "Error inserting data into database: " . mysqli_error($conn);
        error_log($error_message, 3, 'error.log');

        // You may redirect the user back to the form or show an error message
        header("Location: add-room.php?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
}
?>
