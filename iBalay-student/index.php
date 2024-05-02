<?php require 'headbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    /* Add this CSS to your stylesheet or in the head of your HTML document */
.card-box-a .img-box-a img {
  object-fit: cover;
  width: 100%;
  height: 550px;
}
  .card-footer-a{
      height: 100%;
  }
  </style>
</head>

<body>
<main id="main">

    <!-- ========================================= Intro Section ========================================================= -->
                <?php
            // Include your database connection code
            include 'connect_db/connection.php';

            // Fetch data from the database for the intro section, ordered by price in ascending order, and limit to 3 rows
$query = "SELECT room.*, owners.close_account 
          FROM room 
          INNER JOIN owners ON room.OwnerID = owners.owner_id 
          WHERE room.availability = 1 AND room.capacity > 0 
          AND owners.close_account = 0  ORDER BY Price ASC LIMIT 3"; // Replace 'room' with the actual table name
            $result = mysqli_query($conn, $query);

            // Check if there are rows in the result set
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="intro intro-carousel swiper position-relative">';
                echo '<div class="swiper-wrapper">';

                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Explode the photo paths to get an array
                    $photoPaths = explode(',', $row['Photos']);

                    echo '<div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(' . $photoPaths[0] . ')">';
                    echo '<div class="overlay overlay-a"></div>';
                    echo '<div class="intro-content display-table">';
                    echo '<div class="table-cell">';
                    echo '<div class="container">';
                    echo '<div class="row">';
                    echo '<div class="col-lg-8">';
                    echo '<div class="intro-body">';
                    echo '<p class="intro-title-top">' . $row['Barangay'] . ', ' . $row['Municipality'] . '</p>';
                    echo '<h1 class="intro-title mb-4">';
                    echo '<span class="color-b">' . $row['RoomNumber'] . '</span> ' . $row['BoardingHouseName'];
                    echo '</h1>';
                    echo '<p class="intro-subtitle intro-price">';
                    echo '<a href="property-single.php?room_id=' . $row['RoomID'] . '&photo=' . $photoPaths[0] . '"><span class="price-a">rent | ₱ ' . $row['Price'] . '</span></a>';
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
                echo '<div class="swiper-pagination"></div>';
                echo '</div><!-- End Intro Section -->';
            } else {
                echo 'No available rooms with capacity.';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
<!--=========================================================== End Intro Section ===============================-->




    <!-- ============================================= Services Section ========================================================== -->
    <section class="section-services section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Our Services</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card-box-c foo">
              <div class="card-header-c d-flex">
                <div class="card-box-ico">
                  <span class="bi bi-cart"></span>
                </div>
                <div class="card-title-c align-self-center">
                  <h2 class="title-c">Lifestyle</h2>
                </div>
              </div>
              <div class="card-body-c">
              Welcome to iBalay, where vibrant community living meets convenience and dynamic lifestyles. Enjoy shared spaces, diverse interactions, 
              and support in a home that goes beyond accommodation. Welcome to a place where every day offers connection and growth.
                </p>
              </div>
              <div class="card-footer-c">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card-box-c foo">
              <div class="card-header-c d-flex">
                <div class="card-box-ico">
                  <span class="bi bi-calendar4-week"></span>
                </div>
                <div class="card-title-c align-self-center">
                  <h2 class="title-c">Access</h2>
                </div>
              </div>
              <div class="card-body-c">
                <p class="content-c">
                Experience vibrant community living with seamless access at iBalay. 
                Enjoy shared spaces, diverse interactions, and support in a home that goes beyond accommodation. 
                Here, every day brings connection and growth, with convenient access to nearby amenities.
                </p>
              </div>
              <div class="card-footer-c">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card-box-c foo">
              <div class="card-header-c d-flex">
                <div class="card-box-ico">
                  <span class="bi bi-card-checklist"></span>
                </div>
                <div class="card-title-c align-self-center">
                  <h2 class="title-c">Track</h2>
                </div>
              </div>
              <div class="card-body-c">
                <p class="content-c">
                Effortlessly track payments at iBalay, combining vibrant community living, seamless access, and 
                support beyond accommodation. Enjoy daily connection and growth 
                with convenient access to amenities.
                </p>
              </div>
              <div class="card-footer-c">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--========================================== End Services Section ======================================================-->



    <!-- ============================================ Latest Properties Section =============================================== -->
    <section class="section-property section-t8">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title-wrap d-flex justify-content-between">
          <div class="title-box">
            <h2 class="title-a">Latest Boarding House</h2>
          </div>
          <div class="title-link">
            <a href="/iBalay.com/iBalay-student/BoardingHouse.php">All BH
              <span class="bi bi-chevron-right"></span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div id="property-carousel" class="swiper">
      <div class="swiper-wrapper">

        <?php
        // Include your database connection code
        include 'connect_db/connection.php';

        // Fetch data from the database for the latest properties
        $query = "SELECT room.*, owners.close_account 
          FROM room 
          INNER JOIN owners ON room.OwnerID = owners.owner_id 
          WHERE room.availability = 1 AND room.capacity > 0 
          AND owners.close_account = 0 ORDER BY RoomID DESC LIMIT 5";
        $result = mysqli_query($conn, $query);

        // Check if there are rows in the result set
        if (mysqli_num_rows($result) > 0) {
          // Loop through each row in the result set
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="carousel-item-b swiper-slide">';
            echo '<div class="card-box-a card-shadow">';
            echo '<div class="img-box-a">';
            // Assuming you have a column named 'Photos' that stores comma-separated photo paths
            $photoPaths = explode(',', $row['Photos']);
            echo '<img src="' . $photoPaths[0] . '" alt="" class="img-a img-fluid">';
            echo '</div>';
            echo '<div class="card-overlay">';
            echo '<div class="card-overlay-a-content">';
            echo '<div class="card-header-a">';
            echo '<h2 class="card-title-a">';
            echo '<a href="#">' . $row['BoardingHouseName'] . '</a>';
            echo '</h2>';
            echo '</div>';
            echo '<br>';
            echo '<div class="card-body-a">';
            echo '<div class="price-box d-flex">';
            echo '<a href="property-single.php?room_id=' . $row['RoomID'] . '&photo=' . $photoPaths[0] . '"><span class="price-a">Rent | ₱ ' . $row['Price'] . '</span></a>';
            echo '</div>';
            echo '<br>';
            echo '<a href="property-single.php?room_id=' . $row['RoomID'] . '&photo=' . $photoPaths[0] . '" class="link-a">Click here to view';
            echo '<span class="bi bi-chevron-right"></span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="card-footer-a">';
            echo '<ul class="card-info d-flex justify-content-around">';
            echo '<li>';
            echo '<h4 class="card-info-title">Available Capacity</h4>';
            echo '<span>' . $row['Capacity'] . ' available bedding</span>'; 
            echo '</li>';
            echo '<li>';
            echo '<h4 class="card-info-title">Category</h4>';
            echo '<span>' . $row['Category'] . ' Only</span>';
            echo '</li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo 'No properties available';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

      </div>
    </div>
    <div class="propery-carousel-pagination carousel-pagination"></div>
  </div>
  </section>
    <!--============================================== End Latest Properties Section ==============================================-->

  </main>
  <!-- End #main -->

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