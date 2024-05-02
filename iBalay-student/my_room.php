<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>My Room - Tenant</title>
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
    .carousel-item-b img {
    height: 400px; /* Set the desired height */
    width: 100%; /* Ensure the image takes the full width of its container */
    object-fit: cover; /* Maintain aspect ratio and cover the container */
}
.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}

</style>
</head>

<body>
    

<?php

include 'connect_db/connection.php';

if (!isset($_SESSION['TenantID'])) {
    header("Location: /iBalay.com/iBalay-student/login.php");
    exit();
}

$tenantID = $_SESSION['TenantID'];

// Retrieve the room information for the tenant
$query = "SELECT room.*, owners.name AS ownerName, owners.email AS ownerEmail, owners.contact_number AS ownerContact, owners.close_account,
            tenant.FirstName, tenant.LastName, tenant.Email AS tenantEmail, tenant.PhoneNumber AS tenantContact,
            payment.Amount AS paymentAmount, payment.DueDate AS paymentDueDate
            FROM room
            JOIN tenant ON room.RoomID = tenant.RoomID
            JOIN owners ON room.OwnerID = owners.owner_id
            LEFT JOIN payment ON room.RoomID = payment.RoomID
            WHERE tenant.TenantID = $tenantID
            ORDER BY payment.PaymentDate DESC
            LIMIT 1";

$result = mysqli_query($conn, $query);

// Fetch all the results into an array
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if any rows are returned
if (empty($rows)) {
    
    ?>

          <!-- ========================================================== Intro Single ========================================================= -->
          <section class="intro-single">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-lg-8">
              <div class="title-single-box">
                <h1 class="title-single">My Room</h1>
                <span class="color-text-a">Rented Room</span>
              </div>
            </div>
            <div class="col-md-12 col-lg-4">
              <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="/iBalay.com/iBalay-student/index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="/iBalay.com/iBalay-student/BoardingHouse.php">Boarding House</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    My Room
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <!-- ======================================================End Intro Single=============================================================-->

    <!-- Display alert message when no rented room is found -->
    <div class="alert alert-warning" role="alert">
        No rented room yet. See available rooms <a href="/iBalay.com/iBalay-student/BoardingHouse.php">here</a>.
    </div>
<?php
} else {
    // Use the first row for displaying photos
    $firstRow = reset($rows);
    $photoPaths = explode(',', $firstRow['Photos']);
    ?>
    <main id="main">

      <!-- ========================================================== Intro Single ========================================================= -->
      <section class="intro-single">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-lg-8">
              <div class="title-single-box">
                <h1 class="title-single">My Room</h1>
                <span class="color-text-a">Rented Room</span>
              </div>
            </div>
            <div class="col-md-12 col-lg-4">
              <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="/iBalay.com/iBalay-student/index.php">Home</a>
                  </li>
                  <li class="breadcrumb-item">
                    <a href="/iBalay.com/iBalay-student/BoardingHouse.php">Boarding House</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    My Room
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <!-- ======================================================End Intro Single=============================================================-->

      <!-- ======= Property Single ======= -->
      <section class="property-single nav-arrow-b">
          <div class="container">
          <div class="row justify-content-center">
    <div class="col-lg-8">
        <div id="property-single-carousel" class="swiper">
            <div class="swiper-wrapper">
                <?php
                if (empty($photoPaths)) {
                    ?>
                    <div class="alert alert-warning" role="alert">
                        No photos available for the rented room.
                    </div>
                    <?php
                } else {
                    foreach ($photoPaths as $photo) {
                        ?>
                        <div class="carousel-item-b swiper-slide">
                            <img src="<?php echo $photo; ?>" alt="" class="img-fluid">
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="property-single-carousel-pagination carousel-pagination"></div>
    </div>
</div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="row justify-content-between">
                            <div class="col-md-5 col-lg-4">
                                <div class="property-summary">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="title-box-d section-t4">
                                                <h3 class="title-d">Quick Summary</h3>
                                            </div>
                                        </div>
                                    </div>
                                                                <!-- Display warning message if owner's account is closed -->
<?php
if ($firstRow['close_account'] == 1) {
    echo '<div class="alert alert-danger" role="alert">';
    echo 'The owner\'s account has been terminated by SASO. Please contact your BH owner for your own safety! Thank You';
    echo '</div>';
}
?>

                                    <div class="summary-list">
                                        <ul class="list">
                                            <!-- Display other information -->
                                            <li class="d-flex justify-content-between">
                                                <strong>Boarding House Name:</strong>
                                                <span><?php echo $firstRow['BoardingHouseName']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Room Number:</strong>
                                                <span><?php echo $firstRow['RoomNumber']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Payment Due Date:</strong>
                                                <span><?php echo $firstRow['paymentDueDate']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Monthly:</strong>
                                                <span><?php echo $firstRow['Price']; ?></span>
                                            </li>
                                            <hr>
                                            <li class="d-flex justify-content-between">
                                                <strong>Owner:</strong>
                                                <span><?php echo $firstRow['ownerName']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Email:</strong>
                                                <span><?php echo $firstRow['ownerEmail']; ?></span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <strong>Phone:</strong>
                                                <span><?php echo $firstRow['ownerContact']; ?></span>
                                            </li>

                                            
                                            <!-- Add the modal structure for commenting -->
<!-- Add the modal structure for commenting -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Dynamically set the modal title with detailed room information -->
                <h5 class="modal-title" id="exampleModalLabel">Comment Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Tenant Name: <?php echo $firstRow['FirstName'] . ' ' . $firstRow['LastName']; ?></p>
                        <p>Room Number: <?php echo $firstRow['RoomNumber']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p>Boarding House Name: <?php echo $firstRow['BoardingHouseName']; ?></p>
                        <p>Owner Name: <?php echo $firstRow['ownerName']; ?></p>
                    </div>
                </div>
                <form id="commentForm" class="form-a" method="post">
                    <div id="commentModalContent"></div>
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <label for="commentText">Comment:</label>
                                <textarea id="commentText" class="form-control" placeholder="Provide your comment*" name="commentText" cols="45" rows="8" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-1">
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select id="rating" class="form-select" name="rating" required>
                                    <option value="1">1 (Poor)</option>
                                    <option value="2">2 (Fair)</option>
                                    <option value="3">3 (Average)</option>
                                    <option value="4">4 (Good)</option>
                                    <option value="5">5 (Excellent)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-1">
                            <div class="form-group">
                                <label for="crRating">CR Rating:</label>
                                <select id="crRating" class="form-select" name="crRating" required>
                                    <option value="1">1 (Poor)</option>
                                    <option value="2">2 (Fair)</option>
                                    <option value="3">3 (Average)</option>
                                    <option value="4">4 (Good)</option>
                                    <option value="5">5 (Excellent)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-1">
                            <div class="form-group">
                                <label for="coBoardersRating">Co-boarders Rating:</label>
                                <select id="coBoardersRating" class="form-select" name="coBoardersRating" required>
                                    <option value="1">1 (Poor)</option>
                                    <option value="2">2 (Fair)</option>
                                    <option value="3">3 (Average)</option>
                                    <option value="4">4 (Good)</option>
                                    <option value="5">5 (Excellent)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-1">
                            <div class="form-group">
                                <label for="ownerRating">Owner Rating:</label>
                                <select id="ownerRating" class="form-select" name="ownerRating" required>
                                    <option value="1">1 (Poor)</option>
                                    <option value="2">2 (Fair)</option>
                                    <option value="3">3 (Average)</option>
                                    <option value="4">4 (Good)</option>
                                    <option value="5">5 (Excellent)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-success">Submit Comment</button>
                        </div>
                    </div>
                    <input type="hidden" name="roomID" value="<?php echo $firstRow['RoomID']; ?>">
                    <input type="hidden" name="tenantID" value="<?php echo $_SESSION['TenantID']; ?>">
                </form>
            </div>
        </div>
    </div>
</div>



                                            <!-- Add the modal structure for reporting -->
                                            <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <!-- Dynamically set the modal title with detailed room information -->
                                                                    <h5 class="modal-title" id="exampleModalLabel">Report Room</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                          <p>Tenant Name: <?php echo $firstRow['FirstName'] . ' ' . $firstRow['LastName']; ?></p>
                                                                            <p>Room Number: <?php echo $firstRow['RoomNumber']; ?></p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>Boarding House Name: <?php echo $firstRow['BoardingHouseName']; ?></p>
                                                                            <p>Owner Name: <?php echo $firstRow['ownerName']; ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <form class="form-a" action="process_report.php" method="post">
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-1">
                                                                                <div class="form-group">
                                                                                    <textarea id="reportMessage" class="form-control" placeholder="Provide details about the issue*" name="reportMessage" cols="45" rows="8" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 mt-3">
                                                                                <button type="submit" class="btn btn-danger">Submit Report</button>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="roomID" value="<?php echo $firstRow['RoomID']; ?>">
                                                                        <input type="hidden" name="tenantID" value="<?php echo $_SESSION['TenantID']; ?>">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <hr>
                                            <!-- Add Report and Comment buttons -->
                                            <li class="room-buttons">
                                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportModal">Report</a>
                                                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#commentModal">Comment</a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Property Single-->
    </main><!-- End #main -->
<?php } ?>




  <?php include 'footer.php' ?>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>


<!-- Add this script block at the end of your HTML file, before the closing </body> tag -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add an event listener for the form submission
        document.getElementById("commentForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Get form data
            var formData = new FormData(this);

            // Send a POST request to process_comment.php
            fetch("process_comment.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                // Check the response from the server
                if (data.error) {
                    // If there's an error, update the modal content with the error message
                    document.getElementById("commentModalContent").innerHTML = '<p class="error-message">' + data.error + '</p>';
                } else if (data.success) {
                    // If it's a success, you can redirect or display a success message
                    document.getElementById("commentModalContent").innerHTML = '<p class="success-message">' + data.success + '</p>';
                    // Optionally, you can redirect the user after a delay
                    setTimeout(function() {
                        window.location.href = "/iBalay.com/iBalay-student/my_room.php";
                    }, 2000);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
</script>


</body>

</html>
