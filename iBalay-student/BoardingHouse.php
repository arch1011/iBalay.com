<?php require 'headbar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Boarding House lists</title>

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
  margin-top: 7px;
}
.col-sm-12{
  margin-top:10px;
}
.col-md-4 {
    margin: 12px 6px 6px 0;
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
              <h1 class="title-single">Our Amazing BoardingHouses</h1>
              <span class="color-text-a">Tanauan Rentals</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                 BoardingHouses
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
      <div class="col-sm-12">
        <div class="grid-option">
          <form>
            <select class="custom-select" id="sort-options" onchange="sortProperties()">
              <option value="all" selected>All</option>
              <option value="new_to_old">New to Old</option>
              <option value="rent">For Rent</option>
              <option value="cheap_to_expensive">Cheap to Expensive</option>
            </select>
          </form>
        </div>
      </div>

<?php
// Include your database connection code
include 'connect_db/connection.php';

// Define the number of items per page
$itemsPerPage = 6;

// Get the current page number from the query string
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($currentPage - 1) * $itemsPerPage;

// Sort properties based on the selected option
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'all';
switch ($sortOption) {
    case 'new_to_old':
        $sortClause = 'ORDER BY RoomID DESC';
        break;
    case 'rent':
        $sortClause = 'AND availability = 1 AND capacity > 0 ORDER BY Price ASC';
        break;
    case 'cheap_to_expensive':
        $sortClause = 'AND availability = 1 AND capacity > 0 ORDER BY Price ASC';
        break;  // Change to ASC for cheapest to expensive
    default:
        $sortClause = '';
        break;
}

// Fetch data from the database for the current page
$query = "SELECT room.*, owners.close_account 
          FROM room 
          INNER JOIN owners ON room.OwnerID = owners.owner_id 
          WHERE room.availability = 1 AND room.capacity > 0 
          AND owners.close_account = 0 $sortClause 
          LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $query);

      // Check if there are rows in the result set
      if (mysqli_num_rows($result) > 0) {
        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="col-md-4">';
          echo '<div class="carousel-item-b swiper-slide">';
          echo '<div class="card-box-a card-shadow">'; // Remove the inline style
          echo '<div class="img-box-a" style="height: 100% ; object-fit: cover;">'; 
          $photoPaths = explode(',', $row['Photos']);
          echo '<img src="' . $photoPaths[0] . '" alt="" class="img-a img-fluid" style="height: 100%;">'; // Set height: 100%;
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
          echo '<span class="price-a">rent | ₱ ' . $row['Price'] . '</span>';
          echo '</div>';
          echo '<a href="property-single.php?room_id=' . $row['RoomID'] . '&photo=' . $photoPaths[0] . '" class="link-a">Click here to view';
          echo '<span class="bi bi-chevron-right"></span>';
          echo '</a>';
          echo '</div>';
          echo '<div class="card-footer-a">';
          echo '<ul class="card-info d-flex justify-content-around"; >';
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
          echo '</div>';
        }

        // Display pagination
        $totalItemsQuery = "SELECT COUNT(*) as total FROM room WHERE availability = 1 AND capacity > 0 $sortClause";
        $totalItemsResult = mysqli_query($conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);

        echo '<div class="col-sm-12">';
        echo '<nav class="pagination-a">';
        echo '<ul class="pagination justify-content-end">';
        echo '<li class="page-item ' . ($currentPage == 1 ? 'disabled' : '') . '">';
        echo '<a class="page-link" href="?page=' . ($currentPage - 1) . '&sort=' . $sortOption . '" tabindex="-1">';
        echo '<span class="bi bi-chevron-left"></span>';
        echo '</a>';
        echo '</li>';
        
        for ($page = 1; $page <= $totalPages; $page++) {
          echo '<li class="page-item ' . ($page == $currentPage ? 'active' : '') . '">';
          echo '<a class="page-link" href="?page=' . $page . '&sort=' . $sortOption . '">' . $page . '</a>';
          echo '</li>';
        }

        echo '<li class="page-item ' . ($currentPage == $totalPages ? 'disabled' : '') . '">';
        echo '<a class="page-link" href="?page=' . ($currentPage + 1) . '&sort=' . $sortOption . '">';
        echo '<span class="bi bi-chevron-right"></span>';
        echo '</a>';
        echo '</li>';
        echo '</ul>';
        echo '</nav>';
        echo '</div>';
      } else {
        echo 'No properties available';
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
    </div>
  </div>
</section><!-- End Property Grid Single-->


  </main><!-- End #main -->

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


  <script>
  // JavaScript function to handle form submission and URL redirection
  function sortProperties() {
    var selectedOption = document.getElementById("sort-options").value;
    window.location.href = '?sort=' + selectedOption;
  }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function bookmarkRoom(roomID) {
    // Retrieve tenantID from the session (assuming it's already set)
    var tenantID = <?php echo isset($_SESSION['TenantID']) ? $_SESSION['TenantID'] : 'null'; ?>;

    if (tenantID === null) {
        console.error("Tenant ID not available. Please make sure you are logged in.");
        return;
    }

    // Send an AJAX request to bookmark_process.php
    $.ajax({
        type: "POST",
        url: "bookmark_process.php",
        data: { roomID: roomID, tenantID: tenantID },
        success: function(response) {
            console.log(response); // Log success message to the console
        },
        error: function(xhr, status, error) {
            console.error("Error occurred while bookmarking room. Status: " + status + ", Error: " + error);
        }
    });
}
</script>



</body>

</html>