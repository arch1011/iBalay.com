<?php require 'headbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Reports Page</title>
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

    // Function to get reports for a specific tenant
    function getReportsByTenant($tenantID, $conn)
    {
        $reportQuery = "SELECT * FROM report WHERE TenantID = $tenantID";
        $reportResult = mysqli_query($conn, $reportQuery);

        if (!$reportResult) {
            echo 'Error in SQL query: ' . mysqli_error($conn);
            exit;
        }

        return mysqli_fetch_all($reportResult, MYSQLI_ASSOC);
    }

    $reports = getReportsByTenant($tenantID, $conn);
    ?>

<main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single">Your Reports</h1>
                        <span class="color-text-a">reports</span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/iBalay.com/iBalay-student/index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Reports</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Updates
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
                        // Display reports
                        foreach ($reports as $report) {
                            echo '<div class="card mb-3">';
                            echo '<div class="card-header">Room ' . $report['RoomID'] . '</div>';
                            echo '<div class="card-body">';
                            echo '<p class="card-text">Report Date: ' . $report['ReportDate'] . '</p>';
                            echo '<p class="card-text">Report Message: ' . $report['ReportText'] . '</p>';
                            echo '<p class="card-text">Acknowledged: ' . ($report['Acknowledge'] ? 'Yes' : 'No') . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
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