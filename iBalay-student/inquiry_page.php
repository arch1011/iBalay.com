<?php require 'headbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inquiry Page</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

<!-- Bootstrap JS and dependencies 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
-->

<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

<?php

$tenantID = $_SESSION['TenantID'];

// Function to get inquiries for a specific tenant
function getInquiriesByTenant($tenantID, $conn)
{
    $inquiryQuery = "SELECT * FROM inquiry WHERE TenantID = $tenantID";
    $inquiryResult = mysqli_query($conn, $inquiryQuery);

    if (!$inquiryResult) {
        echo 'Error in SQL query: ' . mysqli_error($conn);
        exit;
    }

    $inquiriesByRoom = array();

    while ($inquiry = mysqli_fetch_assoc($inquiryResult)) {
        $roomID = $inquiry['RoomID'];
        if (!isset($inquiriesByRoom[$roomID])) {
            $inquiriesByRoom[$roomID] = array();
        }

        $inquiriesByRoom[$roomID][] = $inquiry;
    }

    return $inquiriesByRoom;
}

// Function to get the owner's reply for a specific inquiry
function getOwnerReply($inquiryID, $conn)
{
    $ownerReplyQuery = "SELECT ReplyMessage FROM reply WHERE InquiryID = $inquiryID";
    $ownerReplyResult = mysqli_query($conn, $ownerReplyQuery);

    if ($ownerReplyResult && mysqli_num_rows($ownerReplyResult) > 0) {
        $ownerReply = mysqli_fetch_assoc($ownerReplyResult)['ReplyMessage'];
        return $ownerReply;
    }

    return null;
}

// Function to get OwnerID for a specific room
function getOwnerIDForRoom($roomID, $conn)
{
    $ownerIDQuery = "SELECT OwnerID FROM room WHERE RoomID = $roomID";
    $ownerIDResult = mysqli_query($conn, $ownerIDQuery);

    if ($ownerIDResult && mysqli_num_rows($ownerIDResult) > 0) {
        $ownerID = mysqli_fetch_assoc($ownerIDResult)['OwnerID'];
        return $ownerID;
    }

    return null;
}

$inquiriesByRoom = getInquiriesByTenant($tenantID, $conn);
?>

<main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single">Your Messages</h1>
                        <span class="color-text-a">Inquiries</span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/iBalay.com/iBalay-student/index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Inquiries</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Messages
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section><!-- End Intro Single -->

    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // Display inquiries
                    foreach ($inquiriesByRoom as $roomID => $inquiries) {
                        echo '<div class="card mb-3">';
                        echo '<div class="card-header">Room ' . $roomID . '</div>';
                        echo '<div class="card-body">';

                        // Display each inquiry for the current RoomID
                        foreach ($inquiries as $inquiry) {
                            echo '<p class="card-text">Message: ' . $inquiry['Message'] . '</p>';

                            // Display owner's reply if available
                            $ownerReply = getOwnerReply($inquiry['InquiryID'], $conn);
                            if ($ownerReply) {
                                echo '<p class="card-text">Owner Reply: ' . $ownerReply . '</p>';
                            } else {
                                echo '<p class="card-text">Owner has not replied yet.</p>';
                            }
                        }

                        // Button to send another inquiry for the current RoomID
                        echo '<button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#inquiryModal' . $roomID . '">Message</button>';

                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal for Send Another Inquiry -->
        <?php
        // Iterate through inquiries to create modals
        foreach ($inquiriesByRoom as $roomID => $inquiries) {
            // Fetch the OwnerID for the current room
            $ownerID = getOwnerIDForRoom($roomID, $conn);

            echo '<div class="modal fade" id="inquiryModal' . $roomID . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="exampleModalLabel">Send Another Inquiry</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="property-contact">';
            echo '<form class="form-a" action="process_inquiry.php" method="post">';
            echo '<div class="row">';
            echo '<div class="col-md-12 mb-1">';
            echo '<div class="form-group">';
            echo '<textarea id="textMessage" class="form-control" placeholder="Send inquiry*" name="message" cols="45" rows="8" required></textarea>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-md-12 mt-3">';
            echo '<button type="submit" class="btn btn-a">Send inquiry</button>';
            echo '</div>';
            echo '</div>';
            echo '<input type="hidden" name="roomID" value="' . $roomID . '">';
            echo '<input type="hidden" name="tenantID" value="' . $_SESSION['TenantID'] . '">';
            echo '<input type="hidden" name="ownerID" value="' . $ownerID . '">'; // Include OwnerID
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </section>
</main>






<?php
include 'footer.php'
?>


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


</body>



</html>