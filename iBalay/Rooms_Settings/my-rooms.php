<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ROOMS LIST - iBalay Owner</title>
  <!-- Favicons
  <link href="./.././assets/img/evsu.png" rel="icon">
  <link href="./.././assets/img/evsu.png" rel="apple-touch-icon">
  -->
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="./../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="./../assets/css/style.css" rel="stylesheet">

            <style>
                .search-bar {
                    margin: 20px 0;
                    display: flex;
                    align-items: center;
                }

                .search-bar input {
                    flex: 1;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px 0 0 4px;
                    margin-right: -1px; /* Adjusted to fix alignment */
                }

                .search-bar button {
                    padding: 10px;
                    border: none;
                    border-radius: 0 4px 4px 0;
                    background-color: #007bff;
                    color: #fff;
                    cursor: pointer;
                }

                .card {
                    height: 100%;
                    margin-bottom: 20px; /* Added margin between cards */
                    box-sizing: border-box; /* Ensure padding and border are included in the height */
                }

                .card .card-img-top {
                    object-fit: cover;
                    height: 100%;
                }

                @media (max-width: 768px) {
                    .card {
                        height: auto; /* Adjusted height for smaller screens */
                    }
                }
            </style>
</head>

        <body>
            <?php
            include './../connect_db/connection.php';

            $ownerID = $_SESSION['owner_id'];

            // Handle search query
            $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            $query = "SELECT * FROM room WHERE ownerID = $ownerID";

            if (!empty($searchTerm)) {
                $query .= " AND RoomNumber LIKE '%$searchTerm%'";
            }

            $result = mysqli_query($conn, $query);

            // Pagination logic
            $cardsPerPage = 5;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startIndex = ($currentPage - 1) * $cardsPerPage;
            $endIndex = $startIndex + $cardsPerPage;

            $totalRooms = mysqli_num_rows($result);
            $totalPages = ceil($totalRooms / $cardsPerPage);

            // Fetch and display rooms based on pagination
            $result = mysqli_query($conn, $query . " LIMIT $startIndex, $cardsPerPage");
            ?>


                <main id="main" class="main">
                    <div class="pagetitle">
                        <h1>Room Lists</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/iBalay.com/iBalay/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item">Rooms | Settings</li>
                                <li class="breadcrumb-item active">my rooms</li>
                            </ol>
                        </nav>
                    </div>

                <section class="section">
                    <div class="search-bar">
                        <form method="GET" action="?page=<?php echo $currentPage; ?>">
                            <div class="search-bar">
                                <input type="text" name="search" id="searchInput" placeholder="Search Room Number"
                                    value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                                <input type="hidden" name="search_hidden" id="searchHidden"
                                    value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="col-lg-3 mb-4">
                                <div class="card">
                                    <?php
                                    $photoPaths = explode(',', $row['Photos']);
                                    $firstImagePath = $photoPaths[0];
                                    echo '<img src="' . $firstImagePath . '" class="card-img-top card-image" alt="Room Image">';
                                    ?>

                                    <div class="card-body">
                                        <h5 class="card-title">Room Number: <?php echo $row['RoomNumber']; ?></h5>
                                        <button class="btn btn-primary view-button" data-toggle="modal"
                                            data-target="#myModal<?php echo $row['RoomID']; ?>">View</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="myModal<?php echo $row['RoomID']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Room Number: <?php echo $row['RoomNumber']; ?></h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Column for Room Photos Carousel -->
                                                <div class="col-lg-6">
                                                    <div id="photoCarousel<?php echo $row['RoomID']; ?>"
                                                        class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <?php
                                                            $photoPaths = explode(',', $row['Photos']);
                                                            foreach ($photoPaths as $index => $photoPath) {
                                                                $activeClass = ($index === 0) ? 'active' : '';
                                                                echo '<div class="carousel-item ' . $activeClass . '">';
                                                                echo '<img src="' . $photoPath . '" class="d-block w-100" style="height: 200px;" alt="Room Photo">';
                                                                echo '</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#photoCarousel<?php echo $row['RoomID']; ?>"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#photoCarousel<?php echo $row['RoomID']; ?>"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                </div>

                                    <!-- Column for Room Details -->
                                    <div class="col-lg-6">
                                        <p><strong>Boarding House Name:</strong> <?php echo $row['BoardingHouseName']; ?></p>
                                        <p><strong>Description:</strong> <?php echo $row['Description']; ?></p>
                                        <p><strong>Category:</strong> <?php echo $row['Category']; ?></p>
                                        <p><strong>Capacity:</strong> <?php echo $row['Capacity']; ?></p>
                                        <p><strong>Barangay:</strong> <?php echo $row['Barangay']; ?></p>
                                        <p><strong>Availability:</strong>
                                            <?php echo ($row['Availability'] == 1) ? 'Available' : 'Not Available'; ?></p>
                                        <p><strong>Price:</strong> <?php echo $row['Price']; ?></p>
                                        <p><strong>Municipality:</strong> <?php echo $row['Municipality']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

 <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </section>
</main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="./../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="./../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./../assets/vendor/chart.js/chart.umd.js"></script>
<script src="./../assets/vendor/echarts/echarts.min.js"></script>
<script src="./../assets/vendor/quill/quill.min.js"></script>
<script src="./../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="./../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="./../assets/vendor/php-email-form/validate.js"></script>


<!-- Bootstrap JavaScript and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Template Main JS File -->
<script src="./../assets/js/main.js"></script>

<!-- Add this after your existing code -->
<script>
    // Add this script to ensure proper modal behavior
    $(document).ready(function () {
        // Enable Bootstrap tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Enable Bootstrap popovers
        $('[data-toggle="popover"]').popover();
    });
</script>

<script>
    // Update hidden input when the search input changes
    $(document).ready(function () {
        $('#searchInput').on('input', function () {
            $('#searchHidden').val($(this).val());
        });
    });
</script>



</body>

</html>
