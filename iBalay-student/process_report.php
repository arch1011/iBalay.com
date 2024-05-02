<?php
include 'connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $roomID = isset($_POST['roomID']) ? $_POST['roomID'] : null;
    $tenantID = isset($_POST['tenantID']) ? $_POST['tenantID'] : null;
    $reportMessage = isset($_POST['reportMessage']) ? $_POST['reportMessage'] : null;

    // Insert report into the 'report' table
    $reportDate = date("Y-m-d"); // Current date
    $insertQuery = "INSERT INTO report (RoomID, TenantID, ReportDate, ReportText) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iiss', $roomID, $tenantID, $reportDate, $reportMessage);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Redirect back to my_room.php
            header("Location: /iBalay.com/iBalay-student/my_room.php#");
            exit();
        } else {
            echo 'Error submitting report: ' . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Error in preparing statement: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo 'Invalid request method.';
}
?>
