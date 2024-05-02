<?php
// Start the session (if not already started)
session_start();

// Check if the tenant ID is set in the session
if (!isset($_SESSION['TenantID'])) {
    http_response_code(400);
    echo 'Error: Tenant ID not found in session.';
    exit;
}

// Get the tenant ID from session
$tenantID = $_SESSION['TenantID'];

// Define the file path to the saved payment history image
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/iBalay.com/payments-jpg/'. 'payment-for-' . $tenantID . '.png';

// Check if the file exists
if (file_exists($filePath)) {
    // Set the appropriate headers for download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));

    // Flush the output buffer
    flush();

    // Read the file and output its contents
    readfile($filePath);

    // Exit the script
    exit;
} else {
    // If the file doesn't exist, display an error message
    echo 'File not found.';
}
?>
