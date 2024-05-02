<?php
// Retrieve the payment history content from the request
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody);

if ($data && isset($data->content)) {
    // Generate a unique filename
    $filename = 'payment_history_' . uniqid() . '.txt';
    // Specify the directory path
    $directory = $_SERVER['DOCUMENT_ROOT'] . '/iBalay.com/payments/';
    // Save the content to a file
    file_put_contents($directory . $filename, $data->content);

    // Return the URL of the saved file
    $response = array(
        'url' => '/iBalay.com/payments/' . $filename
    );
    echo json_encode($response);
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid request'));
}
?>
