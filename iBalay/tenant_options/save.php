<?php
// Check if the PDF file data is received
if (isset($_FILES['pdfFile'])) {
    // Specify the directory where you want to save the PDF file
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . 'iBalay.com/receipt/';
    
    // Move the uploaded PDF file to the specified directory
    $pdfFilePath = $uploadDirectory . 'receipt.pdf';
    move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfFilePath);
    
    // Respond with success message
    echo json_encode(['success' => true]);
} else {
    // Respond with error message
    echo json_encode(['error' => 'PDF file data not received.']);
}
?>
