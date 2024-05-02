<?php
session_start(); 
// Include your database connection code
include 'connect_db/connection.php';

$ownerID = $_POST['ownerID'];
 
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve owner's ID from the session or any other method you're using
    $ownerID = $_SESSION['owner_id']; // Replace with your actual session variable

    // Define the target directory for the uploaded files
$targetDir = __DIR__ . '/./../uploads/photos/';

    // Create the "uploads" directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Sanitize and validate form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if a file was uploaded
    if ($_FILES['photo']['size'] > 0) { // Check the name attribute, should be 'photo'
        // Generate a unique filename for the uploaded photo
        $uniqueFilename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $targetDir . $uniqueFilename;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Valid file extensions
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowedExtensions)) {
            // Move the uploaded file to the "uploads" folder
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                // File uploaded successfully, update the database with the file path
                $updateQuery = "UPDATE owners SET
                    username = '$username',
                    name = '$name',
                    contact_number = '$phone',
                    email = '$email',
                    location = '$location',
                    photo = '$uniqueFilename'  -- Update the 'photo' column in the database
                    WHERE owner_id = $ownerID";

                if (mysqli_query($conn, $updateQuery)) {
                    // Profile updated successfully
                    header("Location: users-profile.php"); // Redirect to the profile page
                    exit();
                } else {
                    // Handle the update error and display the SQL error message
                    echo "Error updating profile: " . mysqli_error($conn);
                }
            } else {
                // Handle the file upload error
                echo "Error uploading file.";
            }
        } else {
            // Invalid file type
            echo "Invalid file type. Allowed extensions: jpg, jpeg, png, gif.";
        }
    } else {
        // If no file is uploaded, update only the user's profile information
        $updateQuery = "UPDATE owners SET
            username = '$username',
            name = '$name',
            contact_number = '$phone',
            email = '$email',
            location = '$location'
            WHERE owner_id = $ownerID";

        if (mysqli_query($conn, $updateQuery)) {
            // Profile updated successfully
            header("Location: users-profile.php"); // Redirect to the profile page
            exit();
        } else {
            // Handle the update error
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
} else {
    // Redirect back to the profile page if the form is not submitted
    header("Location: users-profile.php");
    exit();
}
?>
