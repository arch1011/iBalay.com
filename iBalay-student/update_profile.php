<?php
// Start session
session_start();
// Include database connection
include 'connect_db/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get tenant ID from session
    $tenantID = $_SESSION['TenantID'];

    // Get form data (use mysqli_real_escape_string for security)
    $firstName = mysqli_real_escape_string($conn, $_POST['updateFirstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['updateLastName']);
    $email = mysqli_real_escape_string($conn, $_POST['updateEmail']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['updatePhoneNumber']);
    $gender = mysqli_real_escape_string($conn, $_POST['updateGender']);

    // Update tenant information in the database
    $updateQuery = "UPDATE tenant SET 
                    FirstName = '$firstName',
                    LastName = '$lastName',
                    Email = '$email',
                    PhoneNumber = '$phoneNumber',
                    gender = '$gender'
                    WHERE TenantID = $tenantID";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Tenant information updated successfully

        // Check if a photo is uploaded
        if ($_FILES['updatePhoto']['error'] == 0) {
            $uploadDir = '/iBalay.com/uploads/'; // Update this with your actual path
            $uploadFileName = basename($_FILES['updatePhoto']['name']);
            $uploadFile = $uploadDir . $uploadFileName;

            // Upload the photo
            if (move_uploaded_file($_FILES['updatePhoto']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadFile)) {
                // Update the 'Photos' column in the database with the new photo path
                $updatePhotoPathQuery = "UPDATE tenant SET Photos = '$uploadFileName' WHERE TenantID = $tenantID";
                $updatePhotoPathResult = mysqli_query($conn, $updatePhotoPathQuery);

                if (!$updatePhotoPathResult) {
                    // Handle error in updating photo path
                    echo "Error updating photo path in the database.";
                }
            } else {
                // Handle photo upload error
                echo "Error uploading photo.";
            }
        }

        // Redirect to the profile page
        header("Location: profile.php");
        exit();
    } else {
        // Handle update error
        echo "Error updating tenant information.";
    }
} else {
    // Redirect to the update profile page if the form is not submitted
    header("Location: update_profile.php");
    exit();
}
?>
