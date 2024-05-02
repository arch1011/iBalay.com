<?php
session_start();
$redirectMessage = "";

if (isset($_SESSION['owner_id'])) {
    header("Location: ../dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './../connect_db/connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT owner_id, password, approval_status, close_account FROM owners WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($owner_id, $stored_password, $approval_status, $close_account);
    $stmt->fetch();
    $stmt->close();

    if ($approval_status !== null) {
        if ($close_account === 1) {
            $_SESSION['close_account'] = 1; 
            header("Location: closed_page.php");
            exit();
        } elseif ($approval_status === 1) {

            if (password_verify($password, $stored_password) || $password === $stored_password) {
                $_SESSION['owner_id'] = $owner_id;
                $_SESSION['approval_status'] = $approval_status;


                error_log("Login successful. Redirecting to dashboard.");

                header("Location: ../dashboard.php");
                exit();
            } else {
                $errorMessage = 'Invalid username or password.';
                header("Location: pages-login.php?error=" . urlencode($errorMessage));
                exit();
            }
        } elseif ($approval_status === "0") {
            $_SESSION['approval_status'] = $approval_status;


            error_log("Account is pending approval. Redirecting to pending_account.php");

            header("Location: pending_account.php?message=" . urlencode($redirectMessage)); // Use $redirectMessage
            exit();
        } else {
            $_SESSION['approval_status'] = $approval_status;


            error_log("Account is in an unknown state. Redirecting to pending_account.php");

            header("Location: pending_account.php?message=" . urlencode($redirectMessage)); // Use $redirectMessage
            exit();
        }
    } else {
        $errorMessage = 'Invalid username or password.';
        header("Location: pages-login.php?error=" . urlencode($errorMessage));
        exit();
    }
}

header("Location: ../pages-error-404.php");
exit();
?>
