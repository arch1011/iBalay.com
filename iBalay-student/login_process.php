<?php
// Start a session to manage user login state
session_start();

// Check if the user is already logged in; if so, redirect to the dashboard
if (isset($_SESSION['TenantID'])) {
    header("Location: /iBalay.com/iBalay-student/index.php"); // Replace with your actual dashboard page URL
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection file
    include 'connect_db/connection.php';

    // Get the submitted email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform authentication using the database connection
    $sql = "SELECT TenantID, Password FROM tenant WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($TenantID, $stored_password);
        $stmt->fetch();

        // Check if the stored password matches the submitted password
        if (password_verify($password, $stored_password)) {
            // Password is hashed and correct, set session variables
            $_SESSION['TenantID'] = $TenantID;
            header("Location: /iBalay.com/iBalay-student/my_room.php"); // Replace with your actual dashboard page URL
            exit();
        } elseif ($password === $stored_password) {
            // Password is in plaintext and correct, set session variables
            $_SESSION['TenantID'] = $TenantID;
            header("Location: /iBalay.com/iBalay-student/my_room.php"); // Replace with your actual dashboard page URL
            exit();
        } else {
            // Password is incorrect, display an error message
            $login_error = "Invalid email or password.";
        }
    } else {
        // If login fails, you can display an error message here.
        $login_error = "Invalid email or password.";
    }
}

// If the script reaches here, it means either it's a GET request or the login failed.
// You can render the login form and display any error message.

// Redirect to error page if the dashboard URL is not found
header("Location: /iBalay.com/iBalay-student/login.php");
exit();
?>
