<?php

// Start the session (if not already started)
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the image data
    $imageData = $_POST['imageData'];

    // Decode the base64 encoded image data
    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

    // Set the directory path to save the image (assuming the root directory is C:\xampp\htdocs\)
    $directoryPath = $_SERVER['DOCUMENT_ROOT'] . '/iBalay.com/payments-jpg/';

    // Check if the tenant ID is set in the session
    if (!isset($_SESSION['TenantID'])) {
        http_response_code(400);
        echo 'Error: Tenant ID not found in session.';
        exit;
    }

    // Get the tenant ID from session
    $tenantID = $_SESSION['TenantID'];

    // Set the file path to save the image with tenant's ID
    $filePath = $directoryPath . 'payment-for-' . $tenantID . '.png';

    // Save the image to the server, overwriting the existing file if it exists
    if (file_put_contents($filePath, $imageData) !== false) {
        echo 'Payment history saved successfully.';
    } else {
        http_response_code(500);
        echo 'Error saving payment history. Unable to write to file: ' . $filePath;
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
