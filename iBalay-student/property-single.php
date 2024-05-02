<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Property</title>
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

<!-- Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
.comments-section {
  max-height: 200px; /* Adjust the maximum height as needed */
  overflow-y: auto;
}

.comment-item {
  padding: 10px;
}

.comments-heading {
  position: sticky;
  top: 0;
  background-color: #fff; /* Add background color if needed */
  z-index: 1; /* Set z-index to keep the heading above the scrolling content */
}
.carousel-item-b img {
    height: 400px; /* Set the desired height */
    width: 100%; /* Ensure the image takes the full width of its container */
    object-fit: cover; /* Maintain aspect ratio and cover the container */
}

</style>

</head>

<body>

    <main id="main">
        <!-- Intro Single -->
        <section class="intro-single">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="title-single-box">
                            <?php
                            include 'connect_db/connection.php';

                            $roomID = $_GET['room_id'];
                            $query = "SELECT * FROM room WHERE RoomID = $roomID";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);

                                echo '<h1 class="title-single">' . $row['Barangay'] . ', ' . $row['Municipality'] . '</h1>';
                                echo '<span class="color-text-a">' . $row['BoardingHouseName'] . '</span>';
                            } else {
                                echo 'Room not found.';
                            }

                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="BoardingHouse.php">Properties</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php
                                    echo $row['Barangay'] . ', ' . $row['Municipality'] . ' - ' . $row['BoardingHouseName'];
                                    ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section><!-- End Intro Single -->

        <!-- Property Single -->
        <section class="property-single nav-arrow-b">
        <div class="container">
        
        <div class="row justify-content-center">
    <div class="col-lg-8">
        <div id="property-single-carousel" class="swiper">
            <div class="swiper-wrapper">
                <?php
                include 'connect_db/connection.php';

                $roomID = $_GET['room_id'];
                $query = "SELECT * FROM room WHERE RoomID = $roomID";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    $photoPaths = explode(',', $row['Photos']);

                    foreach ($photoPaths as $photo) {
                        echo '<div class="carousel-item-b swiper-slide">';
                        echo '<img src="' . $photo . '" alt="" class="img-fluid">';
                        echo '</div>';
                    }
                } else {
                    echo 'Room not found.';
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
        <div class="property-single-carousel-pagination carousel-pagination"></div>
    </div>
</div>



            <div class="row">
          <div class="col-sm-12">

        <div class="row justify-content-between">
            <div class="col-md-5 col-lg-4 mb-4">
                <div class="property-summary">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-box-d section-t4 mt-4">
                                <h3 class="title-d">Quick Summary</h3>
                            </div>
                        </div>
                    </div>
                    <div class="summary-list">
                        <ul class="list">
                            <li class="d-flex justify-content-between">
                                <strong>BoardingHouse:</strong>
                                <span><?php echo $row['BoardingHouseName']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Room Serial ID:</strong>
                                <span><?php echo $row['RoomID']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Room number:</strong>
                                <span><?php echo $row['RoomNumber']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Location:</strong>
                                <span><?php echo $row['Barangay'] . ', ' . $row['Municipality']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Category:</strong>
                                <span><?php echo $row['Category']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Availability:</strong>
                                <span><?php echo ($row['Availability'] == 1) ? 'Available' : 'Not Available'; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Capacity:</strong>
                                <span><?php echo $row['Capacity']; ?></span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <strong>Price:</strong>
                                <span>₱<strong><?php echo number_format($row['Price'], 2); ?></strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

<!-- start Room Reviews -->
<hr>
<div class="comments-section mt-4">
  <h4 class="comments-heading">Room Reviews</h4>
  <?php
  include 'connect_db/connection.php';

  $roomID = $_GET['room_id'];
  // Fetch the highest-rated comment based on roomID
  $commentsQuery = "SELECT * FROM comment WHERE RoomID = $roomID ORDER BY Rating DESC LIMIT 100";
  $commentsResult = mysqli_query($conn, $commentsQuery);

  if ($commentsResult && mysqli_num_rows($commentsResult) > 0) {
    while ($comment = mysqli_fetch_assoc($commentsResult)) {
        echo '<div class="comment-item">';
        echo '<strong>Tenant:</strong> Anonymous<br>';
        echo '<strong>Comment:</strong> ' . $comment['CommentText'] . '<br>';
        echo '<strong>Rating:</strong> ';

        // Map numerical rating to labels and stars
        $rating = $comment['Rating'];
        $ratingLabels = ['Poor', 'Fair', 'Average', 'Good', 'Excellent'];
        $ratingLabel = isset($ratingLabels[$rating - 1]) ? $ratingLabels[$rating - 1] : 'Unknown';

        // Display stars based on the rating
        echo '<span class="star-rating">';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = ($i <= $rating) ? 'bi-star-fill' : 'bi-star';
            echo '<i class="bi ' . $starClass . '"></i>';
        }
        echo '</span>';
        echo ' (' . $ratingLabel . ')<br>';

        // Display CR rating, Co-boarders rating, and Owner rating
        echo '<strong>CR Rating:</strong> ';
        echo '<span class="star-rating">';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = ($i <= $comment['CrRating']) ? 'bi-star-fill' : 'bi-star';
            echo '<i class="bi ' . $starClass . '"></i>';
        }
        echo '</span><br>';

        echo '<strong>Co-boarders Rating:</strong> ';
        echo '<span class="star-rating">';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = ($i <= $comment['CoBoardersRating']) ? 'bi-star-fill' : 'bi-star';
            echo '<i class="bi ' . $starClass . '"></i>';
        }
        echo '</span><br>';

        echo '<strong>Owner Rating:</strong> ';
        echo '<span class="star-rating">';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = ($i <= $comment['OwnerRating']) ? 'bi-star-fill' : 'bi-star';
            echo '<i class="bi ' . $starClass . '"></i>';
        }
        echo '</span><br>';

        echo '<hr>';
        echo '</div>';
    }
    
  } else {
    echo '<p>No comments found.</p>';
  }
  mysqli_close($conn);
  ?>
</div>
<hr>
<!-- end Room Reviews -->



            <div class="col-md-7 col-lg-7 section-md-t3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title-box-d">
                            <h3 class="title-d">Room Description</h3>
                        </div>
                    </div>
                </div>
                <div class="property-description">
                    <p class="description color-text-a">
                        <?php echo nl2br($row['Description']); ?>
                    </p>
                </div>
                <div class="room-buttons">
                  <button class="btn btn-outline-success" onclick="bookmarkRoom(<?php echo $row['RoomID']; ?>)">Bookmark</button>
                  <button class="btn btn-success" onclick="reserveRoom(<?php echo $row['RoomID']; ?>)">Reserve Now</button>
                </div>
            </div>
        </div>

        <!-- Owner Details -->
        <?php
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay.com/uploads/';
        include 'connect_db/connection.php';

        $ownerID = $row['OwnerID'];
        $ownerQuery = "SELECT * FROM owners WHERE owner_id = $ownerID";
        $ownerResult = mysqli_query($conn, $ownerQuery);

        if (mysqli_num_rows($ownerResult) > 0) {
            $owner = mysqli_fetch_assoc($ownerResult);
        ?>
            <div class="col-md-12">
                <div class="row section-t3">
                    <div class="col-sm-12">
                        <div class="title-box-d">
                            <h3 class="title-d">Contact Owner</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <?php if (!empty($owner['photo']) && file_exists($targetDir . $owner['photo'])) : ?>
                            <img src="/iBalay.com/uploads/<?php echo $owner['photo']; ?>" alt="" class="img-fluid">
                        <?php else : ?>
                            <img src="/iBalay.com/uploads/661f2c99dae2e_evsu_favicon.png" alt="" class="img-fluid">
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="property-agent">
                            <h4 class="title-agent"><?php echo $owner['name']; ?></h4>
                            <p class="color-text-a">
                                <?php echo nl2br($owner['location']); ?>
                            </p>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between">
                                    <strong>Phone:</strong>
                                    <span class="color-text-a"><?php echo $owner['contact_number']; ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Email:</strong>
                                    <span class="color-text-a"><?php echo $owner['email']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        
<!-- ... (previous code) ... -->

<div class="property-contact">
  <form class="form-a" action="process_inquiry.php" method="post">
    <div class="row">
      <div class="col-md-12 mb-1">
        <div class="form-group">
          <textarea id="textMessage" class="form-control" placeholder="Send inquiry*" name="message" cols="45" rows="8" required></textarea>
        </div>
      </div>
      <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-a">Send inquiry</button>
      </div>
    </div>
    <input type="hidden" name="roomID" value="<?php echo $roomID; ?>">
    <input type="hidden" name="tenantID" value="<?php echo $_SESSION['TenantID']; ?>">

    <!-- Add the hidden input for ownerID -->
    <input type="hidden" name="ownerID" value="<?php echo $row['OwnerID']; ?>">
  </form>
</div>

<!-- ... (rest of the code) ... -->


              </div>
                </div>
            </div>
        <?php
        } else {
            echo 'Owner not found.';
        }

        mysqli_close($conn);
        ?>
</div>
</div>

<!-- Modal for reservation success -->
<div class="modal fade" id="reservationSuccessModal" tabindex="-1" aria-labelledby="reservationSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationSuccessModalLabel">Reservation Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Room reserved successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for bookmark success -->
<div class="modal fade" id="bookmarkSuccessModal" tabindex="-1" aria-labelledby="bookmarkSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookmarkSuccessModalLabel">Bookmark Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Room bookmarked successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for already reserved room -->
<div class="modal fade" id="alreadyReservedModal" tabindex="-1" aria-labelledby="alreadyReservedModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alreadyReservedModalLabel">Room Already Reserved</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You have already reserved this room.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for existing reserved room -->
<div class="modal fade" id="existingReservedModal" tabindex="-1" aria-labelledby="existingReservedModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existingReservedModalLabel">Existing Reserved Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You have an existing reserved room.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

      </section>
    </main><!-- End #main -->

<?php
include 'footer.php'
?>

    <!-- ... (rest of the code) ... -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function bookmarkRoom(roomID) {
    // Assuming you have a way to retrieve the tenantID (replace '123' with your actual logic)
    var tenantID = <?php echo json_encode($_SESSION['TenantID']); ?>;

    // Send an AJAX request to bookmark_process.php
    $.ajax({
        type: "POST",
        url: "bookmark_process.php",
        data: { roomID: roomID, tenantID: tenantID },
        success: function(response) {
            $('#bookmarkSuccessModal').modal('show'); // Show bookmark success modal
        },
        error: function() {
            alert("Error occurred while bookmarking room");
        }
    });
}
</script>

<script>
function reserveRoom(roomID) {
    // Retrieve tenantID from the session
    var tenantID = <?php echo json_encode($_SESSION['TenantID']); ?>;

    // Send an AJAX request to check_reservation.php to see if the room is already reserved by the tenant
    $.ajax({
        type: "POST",
        url: "check_reservation.php",
        data: { roomID: roomID, tenantID: tenantID },
        success: function(response) {
            if (response === "already_reserved") {
                $('#alreadyReservedModal').modal('show'); // Show already reserved modal
            } else if (response === "existing_reserved") {
                $('#existingReservedModal').modal('show'); // Show existing reserved modal
            } else {
                // Room is not reserved, proceed with reservation
                $.ajax({
                    type: "POST",
                    url: "reserve_process.php",
                    data: { roomID: roomID, tenantID: tenantID },
                    success: function(reservationResponse) {
                        if (reservationResponse.trim() === "Reservation successful!") {
                            $('#reservationSuccessModal').modal('show'); // Show reservation success modal
                        } else {
                            alert("Reservation failed. Please try again later."); // Handle other responses
                        }
                    },
                    error: function() {
                        alert("Error occurred while reserving room");
                    }
                });
            }
        },
        error: function() {
            alert("Error occurred while checking reservation status");
        }
    });
}

</script>

</body>

</html>
