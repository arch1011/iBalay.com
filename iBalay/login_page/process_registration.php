<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include './../connect_db/connection.php';

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

function ensureFolderExists($folder)
{
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

function handleFileUpload($inputName, $uploadDir)
{
    $uploadedFiles = $_FILES[$inputName];
    $uploadedFileCount = count($uploadedFiles['name']);
    $uploadedFileList = [];

    for ($i = 0; $i < $uploadedFileCount; $i++) {
        if ($uploadedFiles['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = basename($uploadedFiles['name'][$i]);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetFile)) {
                $uploadedFileList[] = $fileName;
            } else {
                error_log('Error during file upload: ' . $uploadedFiles['error'][$i]);
                error_log('Move uploaded file failed: ' . $targetFile);

                var_dump($uploadedFiles);

                error_log('Is the directory readable? ' . is_readable($uploadDir));
                error_log('Is the directory writable? ' . is_writable($uploadDir));
            }
        } else {
            error_log('Error during file upload: ' . $uploadedFiles['error'][$i]);
        }
    }

    return $uploadedFileList;
}

ensureFolderExists(__DIR__ . '/../../uploads/');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $name = $_POST["name"];
    $contactNumber = $_POST["contact_number"];
    $email = $_POST["email"];
    $location = $_POST["location"];

    ensureFolderExists(__DIR__ . '/../../uploads/photos/');
    ensureFolderExists(__DIR__ . '/../../uploads/documents/');

    $photoList = handleFileUpload('ownerPhoto', __DIR__ . '/../../uploads/photos/');
    $documents1List = handleFileUpload('ownerDocuments1', __DIR__ . '/../../uploads/documents/');
    $documents2List = handleFileUpload('ownerDocuments2', __DIR__ . '/../../uploads/documents/');

    $photo = implode('|', $photoList);
    $documents1 = implode('|', $documents1List);
    $documents2 = implode('|', $documents2List);

    $documents = $documents1 . '|' . $documents2;

    try {
        $stmt = $conn->prepare("INSERT INTO owners (username, password, name, contact_number, email, location, photo, documents, approval_status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");

        $stmt->bind_param('ssssssss', $username, $password, $name, $contactNumber, $email, $location, $photo, $documents);

        $stmt->execute();

        echo 'pending';

    } catch (Exception $e) {

        error_log('Error during registration: ' . $e->getMessage());

        header('Content-Type: application/json');
        echo json_encode(['error' => 'Registration failed. ' . $e->getMessage()]);
        exit;
    }

    $stmt->close();
} else {
    echo 'Invalid request';
}

$conn->close();

?>
