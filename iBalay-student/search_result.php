<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Result</title>
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
        .card-box-a {
            height: 75%;
        }

        .link-a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .link-a:hover {
            color: #4CAF50;
        }
    </style>
</head>

<body>

    <main id="main">

        <section class="intro-single">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="title-single-box">
                            <h1 class="title-single">BoardingHouse Results</h1>
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
        </section>

        <?php
include 'connect_db/connection.php';

$tenantID = $_SESSION['TenantID'];

if (!isset($_SESSION['TenantID'])) {
    header("Location: /iBalay.com/iBalay-student/login.php"); 
    exit();
}

// Initialize search parameters
$category = $_GET['Type'] ?? '';
$city = $_GET['city'] ?? '';
$barangay = $_GET['barangay'] ?? '';
$useDropdown = isset($_GET['use_dropdown']) && $_GET['use_dropdown'] == 'on'; // Check if the checkbox is checked
$price = $useDropdown ? $_GET['price_dropdown'] : ($_GET['price'] ?? ''); // Use dropdown value if checkbox is checked
$capacity = $useDropdown ? $_GET['capacity_dropdown'] : ($_GET['capacity'] ?? ''); // Use dropdown value if checkbox is checked

// Construct SQL query based on search parameters
$query = "SELECT * FROM room WHERE 1";

if (!empty($category) && $category !== 'All Type') {
    $query .= " AND Category = '$category'";
}

if (!empty($city) && $city !== 'All City') {
    $query .= " AND Municipality = '$city'";
}

if (!empty($barangay) && $barangay !== 'All Barangay') {
    $query .= " AND Barangay = '$barangay'";
}

if (!$useDropdown) {
    if (!empty($price)) {
        if (!is_numeric($price)) {
            echo "Invalid price input.";
            exit();
        }
        $price = str_replace('$', '', $price);
        $query .= " AND Price <= $price";
    }

    if (!empty($capacity)) {
        if (!is_numeric($capacity)) {
            echo "Invalid capacity input.";
            exit();
        }
        $query .= " AND Capacity = $capacity";
    }
}

// Execute SQL query
$result = mysqli_query($conn, $query);

?>




<section class="property-grid grid">
    <div class="container">
        <div class="row">
            <?php
            // Check if there are search results
            if (mysqli_num_rows($result) > 0) {
                // Loop through each search result
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <!-- Display search result in card layout -->
                    <div class="col-md-4">
                        <div class="carousel-item-b swiper-slide">
                            <div class="card-box-a card-shadow">
                                <!-- Replace placeholder values with actual database values -->
                                <div class="img-box-a">
                                    <?php
                                    // Assuming you have a column named 'Photos' that stores comma-separated photo paths
                                    $photoPaths = explode(',', $row['Photos']);
                                    ?>
                                    <img src="<?php echo $photoPaths[0]; ?>" alt="" class="img-a img-fluid">
                                </div>
                                <div class="card-overlay">
                                    <div class="card-overlay-a-content">
                                        <div class="card-header-a">
                                            <h2 class="card-title-a">
                                                <a href="#"><?php echo $row['BoardingHouseName']; ?></a>
                                            </h2>
                                        </div>
                                        <div class="card-body-a">
                                            <div class="price-box d-flex">
                                                <span class="price-a">rent | ₱ <?php echo $row['Price']; ?></span>
                                            </div>
                                            <a href="property-single.php?room_id=<?php echo $row['RoomID']; ?>" class="link-a">Click here to view
                                                  <span class="bi bi-chevron-right"></span>
                                              </a>
                                        </div>
                                        <div class="card-footer-a">
                                            <ul class="card-info d-flex justify-content-around">
                                                <li>
                                                    <h4 class="card-info-title">Available Capacity</h4>
                                                    <span><?php echo $row['Capacity']; ?> available bedding</span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Category</h4>
                                                    <span><?php echo $row['Category']; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // No matching properties found
                echo "<div class='col-md-12'>No properties found.</div>";
            }
            ?>
        </div>
    </div>
</section>


    </main>

    <?php include 'footer.php' ?>

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
