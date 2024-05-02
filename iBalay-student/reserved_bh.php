<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Reserved Boarding House</title>
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

  <!--other styles added-->
  <style>
    .card-info{
  margin-top:8px;
}
.card-overlay {
  margin-top: 8px;
}
  </style>
</head>

<body>

<main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single">Your Reserved Rooms</h1>
                        <span class="color-text-a">Reserved</span>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/iBalay.com/iBalay-student/index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Ongoing Reservation
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section><!-- End Intro Single-->

    <!-- Property Grid section -->
    <section class="property-grid grid">
        <div class="container">
            <div class="row">
                <?php
                include 'connect_db/connection.php';

                if (isset($_SESSION['TenantID'])) {
                    $tenantID = $_SESSION['TenantID'];

                    $sql = "SELECT room.*, reservation.ReservationID, reservation.ReservationDate
                            FROM room
                            JOIN reservation ON room.RoomID = reservation.RoomID
                            WHERE reservation.TenantID = $tenantID
                            ORDER BY reservation.ReservationDate DESC
                            LIMIT 6";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4">';
                            echo '<div class="card-box-a card-shadow">';
                            echo '<div class="img-box-a">';

                            $photoPaths = explode(',', $row['Photos']);

                            if (!empty($photoPaths[0]) && file_exists($_SERVER['DOCUMENT_ROOT'] . $photoPaths[0])) {
                                echo '<img src="' . $photoPaths[0] . '" alt="" class="img-a img-fluid" style="height: 100%; width: 100%;">';
                            } else {
                                echo '<img src="/uploads/default-placeholder.jpg" alt="" class="img-a img-fluid" style="height: 100%;">';
                            }

                            echo '</div>';
                            echo '<div class="card-overlay">';
                            echo '<div class="card-overlay-a-content">';
                            echo '<div class="card-header-a">';
                            echo '<h2 class="card-title-a">';
                            echo '<a href="#">' . $row['BoardingHouseName'] . '</a>';
                            echo '</h2>';
                            echo '</div>';
                            echo '<div class="card-body-a">';
                            echo '<div class="price-box d-flex">';
                            echo '<span class="price-a">rent | $ ' . $row['Price'] . '</span>';
                            echo '</div>';
                            echo '<a href="property-single.php?room_id=' . $row['RoomID'] . '&photo=' . $photoPaths[0] . '" class="link-a">Click here to view';
                            echo '<span class="bi bi-chevron-right"></span>';
                            echo '</a>';
                            echo '</div>';
                            echo '<div class="card-footer-a">';
                            echo '<ul class="card-info d-flex justify-content-around">';
                            
                            $reservationID = $row['ReservationID'];

                            echo '<li class="text-center">';
                            echo '<form method="post" action="delete_reserve.php">';
                            echo '<input type="hidden" name="reservationID" value="' . $reservationID . '">';
                            echo '<button type="submit" class="btn btn-danger btn-sm">Cancel Reservation</button>';
                            echo '</form>';
                            echo '</li>';

                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<li class="text-center">';
                        echo "<span>No reserved rooms found. or rooms reserved have been declined by the owner.</span>";
                        echo '</li>';
                    }
                } else {
                    echo "TenantID is not set in the session.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

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
