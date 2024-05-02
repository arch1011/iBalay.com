<?php
session_start();
// Include the database connection file
include 'connect_db/connection.php';

// Get ownerID from the session
$ownerID = $_SESSION['owner_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $complete_address = mysqli_real_escape_string($conn, $_POST['complete_address']);
    $business_permit = mysqli_real_escape_string($conn, $_POST['business_permit']);
    $monthly_payment_rate = mysqli_real_escape_string($conn, $_POST['monthly_payment_rate']);
    $number_of_kitchen = mysqli_real_escape_string($conn, $_POST['number_of_kitchen']);
    $number_of_living_room = mysqli_real_escape_string($conn, $_POST['number_of_living_room']);
    $number_of_students_tenants = mysqli_real_escape_string($conn, $_POST['number_of_students_tenants']);
    $number_of_cr = mysqli_real_escape_string($conn, $_POST['number_of_cr']);
    $number_of_beds = mysqli_real_escape_string($conn, $_POST['number_of_beds']);
    $number_of_rooms = mysqli_real_escape_string($conn, $_POST['number_of_rooms']);
    $bh_max_capacity = mysqli_real_escape_string($conn, $_POST['bh_max_capacity']);
    $gender_allowed = mysqli_real_escape_string($conn, $_POST['gender_allowed']);

    // Check if a record with the same ownerID already exists
    $check_sql = "SELECT * FROM bh_information WHERE owner_id='$ownerID'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // If a record exists, update it
        $update_sql = "UPDATE bh_information SET
            complete_address='$complete_address',
            business_permit='$business_permit',
            monthly_payment_rate='$monthly_payment_rate',
            number_of_kitchen='$number_of_kitchen',
            number_of_living_room='$number_of_living_room',
            number_of_students_tenants='$number_of_students_tenants',
            number_of_cr='$number_of_cr',
            number_of_beds='$number_of_beds',
            number_of_rooms='$number_of_rooms',
            bh_max_capacity='$bh_max_capacity',
            gender_allowed='$gender_allowed'
            WHERE owner_id='$ownerID'";

        if (mysqli_query($conn, $update_sql)) {
           // Record successfully updated
                    header("Location: dashboard.php");
        } else {
            // Error in update
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // If no record exists, perform an INSERT
        $insert_sql = "INSERT INTO bh_information (owner_id, complete_address, business_permit, monthly_payment_rate, number_of_kitchen, number_of_living_room, number_of_students_tenants, number_of_cr, number_of_beds, number_of_rooms, bh_max_capacity, gender_allowed) 
            VALUES ('$ownerID', '$complete_address', '$business_permit', '$monthly_payment_rate', '$number_of_kitchen', '$number_of_living_room', '$number_of_students_tenants', '$number_of_cr', '$number_of_beds', '$number_of_rooms', '$bh_max_capacity', '$gender_allowed')";

        if (mysqli_query($conn, $insert_sql)) {

        header("Location: dashboard.php");
        exit();
        } else {
            // Error in insertion
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the situation where the form is not submitted
    echo "Form not submitted!";
}
?>
