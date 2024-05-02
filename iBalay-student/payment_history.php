<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Payment History</title>
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

  <style>
    @media print {
      /* Add custom styles for printing if needed */
      .print-hide {
        display: none;
      }
    }
  </style>
</head>

<body>

<?php 
include 'connect_db/connection.php';
$tenantID = $_SESSION['TenantID'];

// Fetch payment history for the tenant with room information
$query = "SELECT payment.*, room.RoomNumber FROM payment
          LEFT JOIN room ON payment.RoomID = room.RoomID
          WHERE payment.TenantID = $tenantID";
$result = mysqli_query($conn, $query);
?>

<main id="main">
  <!-- ======= Intro Single ======= -->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Your Payments</h1>
            <span class="color-text-a">Payments</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/iBalay.com/iBalay-student/index.php">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Payment History
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section><!-- End Intro Single-->

  <!-- ======= Payment History Card ======= -->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <button class="btn btn-primary print-hide" onclick="preparePaymentHistory()">Prepare Payment History</button>
        </div>
        <div id="paymentHistoryContent" style="display: none;">
          <?php
          // Check if there are any payments
          if (mysqli_num_rows($result) > 0) {
            echo '<div class="col-md-12"><div class="card"><div class="card-body">';
            echo '<h5 class="card-title">Payment Details</h5>';
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<p class="card-text">Amount: $' . $row['Amount'] . '</p>';
              echo '<p class="card-text">Payment Date: ' . $row['PaymentDate'] . '</p>';
              echo '<p class="card-text">Room Number: ' . $row['RoomNumber'] . '</p>';
              echo '<hr>';
            }
            echo '</div></div></div>';
          } else {
            echo '<div class="col-md-12"><p>No payment history available.</p></div>';
          }
          ?>
        </div>
        <div class="col-md-12 mt-3 mb-3">
                    <hr>
                    <!-- Initially hidden, shown after preparing payment history -->
                    <button id="downloadBtn" class="btn btn-primary print-hide" style="display: none;" onclick="downloadPaymentHistory()">Download Payment History</button>
                </div>

      </div>
    </div>
  </section><!-- End Payment History Card -->
</main><!-- End #main -->

<?php include 'footer.php'; ?>

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
// Define the downloadPaymentHistory function in the global scope
function downloadPaymentHistory() {
    // Open a new tab and navigate to the download script
    window.open('download_payment_history.php', '_blank');
}

function preparePaymentHistory() {
    // Show payment history content
    document.getElementById("paymentHistoryContent").style.display = "block";
    
    // Display the download button immediately
    document.getElementById("downloadBtn").style.display = "block";

    // Use HTML2Canvas to render the HTML content as an image
    html2canvas(document.getElementById('paymentHistoryContent')).then(canvas => {
        // Convert the canvas to a data URL
        const dataURL = canvas.toDataURL('image/png');

        // Send the canvas data to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Success, do nothing
                    console.log("Payment history saved successfully.");
                } else {
                    // Error handling
                    console.error("Error saving payment history:", xhr.responseText);
                }
            }
        };
        xhr.open('POST', 'save_payment_history.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imageData=' + encodeURIComponent(dataURL));
    });
}

</script>


</body>
</html>
