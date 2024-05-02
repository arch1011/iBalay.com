<?php require 'headbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>EstateAgency Bootstrap Template - Index</title>
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

/* Add these styles to your existing stylesheet */
.link-a {
  color: #fff; /* Set initial text color to white */
  text-decoration: none; /* Remove underline */
  transition: color 0.3s; /* Add transition for smooth color change */
}

.link-a:hover {
  color: #4CAF50; /* Change text color to green on hover */
}
.card-footer-a {
  margin-top:12px;
}
.card-overlay {
  margin-top: 15px;
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
              <h1 class="title-single">Your Bookmarks</h1>
              <span class="color-text-a">Boarding Houses</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                 Bookmarks
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= Property Grid ======= -->
    <section class="property-grid grid">
      <div class="container">
        <div class="row">

          <?php
          // Include your database connection code
          include 'connect_db/connection.php';

          if (isset($_SESSION['TenantID'])) {
            $tenantID = $_SESSION['TenantID'];

            // Fetch bookmarked rooms
        $sql = "SELECT room.*, bookmark.BookmarkID FROM room
                JOIN bookmark ON room.RoomID = bookmark.RoomID
                WHERE bookmark.TenantID = $tenantID
                LIMIT 6";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Loop through bookmarked rooms and display them
              while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4">';
                echo '<div class="card-box-a card-shadow">';
                echo '<div class="img-box-a">';
                
                // Assuming you have a column named 'Photos' that stores comma-separated photo paths
                $photoPaths = explode(',', $row['Photos']);
                
                // Check if the first photo path exists
                if (!empty($photoPaths[0]) && file_exists($_SERVER['DOCUMENT_ROOT'] . $photoPaths[0])) {
                        echo '<img src="' . $photoPaths[0] . '" alt="" class="img-a img-fluid" style="height: 100%; width: 100%;">';

                } else {
                  // If the photo doesn't exist, show a placeholder or handle as needed
                  echo '<img src="/iBalay/uploads/default-placeholder.jpg" alt="" class="img-a img-fluid" style="height: 100%; width: 100%">';
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
                                        echo '<button class="btn btn-danger btn-sm" onclick="deleteBookmark(' . $row['BookmarkID'] . ')">Delete</button>';
                echo '</div>';
                echo '<div class="card-footer-a">';
                echo '<ul class="card-info d-flex justify-content-around">';
                echo '<li>';
                echo '<h4 class="card-info-title">Available Capacity</h4>';
                echo '<span>' . $row['Capacity'] . '</span>';
                echo '</li>';
                echo '<li>';
                echo '<h4 class="card-info-title">Category</h4>';
                echo '<span>' . $row['Category'] . '</span>';
                echo '</li>';
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
            } else {
              // Handle case when no bookmarked rooms are found
              echo "No bookmarked rooms found.";
            }
          } else {
            // Handle case when TenantID is not set in the session
            echo "TenantID is not set in the session.";
          }

          // Close the database connection
          $conn->close();
          ?>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

<?php
include 'footer.php'
?>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  
<script>
  function deleteBookmark(bookmarkID) {
    // Send AJAX request to delete_bookmark.php
    $.ajax({
      type: "POST",
      url: "delete_bookmark.php",
      data: { bookmarkID: bookmarkID },
      success: function(response) {
        // Refresh the page or update the UI as needed
        location.reload(); // Reload the page to reflect changes
      },
      error: function() {
        alert("Error occurred while deleting bookmark.");
      }
    });
  }
</script>

</body>

</html>
