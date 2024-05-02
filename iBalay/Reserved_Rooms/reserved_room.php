<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>RESERVED ROOMS - iBalay Owner</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
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
        margin-right: -1px;
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
        margin-bottom: 20px;
        box-sizing: border-box;
    }

    .card .card-img-top {
        object-fit: cover;
        height: 100%;
    }

    @media (max-width: 768px) {
        .card {
            height: auto;
        }
    }
</style>


</head>

<body>
<?php
include './../connect_db/connection.php';

// Assuming you have a search term
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 12;

// Query to get reserved rooms
$query = "SELECT room.*, reservation.* FROM room
          LEFT JOIN reservation ON room.RoomID = reservation.RoomID
          WHERE reservation.RoomID IS NOT NULL";

// Add a condition for the search term
if (!empty($searchTerm)) {
    $query .= " AND room.RoomNumber LIKE '%$searchTerm%'";
}

// Perform the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Pagination
$totalItems = mysqli_num_rows($result);
$totalPages = ceil($totalItems / $itemsPerPage);
$offset = ($currentPage - 1) * $itemsPerPage;

$query .= " LIMIT $itemsPerPage OFFSET $offset";
$result = mysqli_query($conn, $query);

// ... rest of the code to display reserved rooms and modal details ...
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reserved Rooms</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://localhost/iBalay/dashboard.php">Home</a></li>
                <li class="breadcrumb-item">Reserved Rooms</li>
                <li class="breadcrumb-item active">reserved</li>
            </ol>
        </nav>
    </div>

    <section class="section">

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
                                            <?php
                                            // Fetch tenant details based on the reservation
                                            $reservationQuery = "SELECT * FROM reservation WHERE RoomID = '{$row['RoomID']}'";
                                            $reservationResult = mysqli_query($conn, $reservationQuery);

                                            if ($reservationResult && $reservationRow = mysqli_fetch_assoc($reservationResult)) {
                                                $tenantQuery = "SELECT * FROM tenant WHERE TenantID = '{$reservationRow['TenantID']}'";
                                                $tenantResult = mysqli_query($conn, $tenantQuery);

                                                if ($tenantResult && $tenantRow = mysqli_fetch_assoc($tenantResult)) {
                                                    ?>
                                                    <div class="tenant-details">
                                                        <p><strong>Tenant Information</strong></p>
                                                        <p><strong>Tenant Name:</strong> <?php echo $tenantRow['FirstName'] . ' ' . $tenantRow['LastName']; ?></p>
                                                        <p><strong>Email:</strong> <?php echo $tenantRow['Email']; ?></p>
                                                        <p><strong>Phone Number:</strong> <?php echo $tenantRow['PhoneNumber']; ?></p>
                                                        <p><strong>Gender:</strong> <?php echo $tenantRow['gender']; ?></p>
                                                    </div>
                                                <?php
                                                } else {
                                                    echo '<p>Tenant not found.</p>';
                                                }
                                            } else {
                                                echo '<p>Reservation not found.</p>';
                                            }
                                            ?>
                                            <hr>
                                            <p><strong>Room Information</strong></p>
                                            <p><strong>Boarding House Name:</strong> <?php echo $row['BoardingHouseName']; ?></p>
                                            <p><strong>Description:</strong> <?php echo $row['Description']; ?></p>
                                            <p><strong>Category:</strong> <?php echo $row['Category']; ?></p>
                                            <p><strong>Capacity:</strong> <?php echo $row['Capacity']; ?></p>
                                            <p><strong>Barangay:</strong> <?php echo $row['Barangay']; ?></p>
                                            <p><strong>Availability:</strong>
                                                <?php echo ($row['Availability'] == 1) ? 'Available' : 'Not Available'; ?></p>
                                            <p><strong>Price:</strong> <?php echo $row['Price']; ?></p>
                                            <p><strong>Municipality:</strong> <?php echo $row['Municipality']; ?></p>
                                            <!-- Add the "Approve Reservation" button -->
                                            <div class="d-flex justify-content-between mt-3">
                                        <!-- Button in the modal to view details -->
                                        <form action="approving_tenant.php" method="post">
                                            <input type="hidden" name="roomID" value="<?php echo $row['RoomID']; ?>">
                                            <button type="submit" class="btn btn-success">Proceed to payment</button>
                                        </form>

                                                <form action="decline_process.php" method="post">
                                                    <input type="hidden" name="roomID" value="<?php echo $row['RoomID']; ?>">
                                                    <button type="submit" class="btn btn-danger">Decline</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
