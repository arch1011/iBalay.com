<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
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
</head>

<body>
<?php
include './../connect_db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $roomID = $_POST['roomID'];

    $roomQuery = "SELECT * FROM room WHERE RoomID = $roomID";
    $roomResult = mysqli_query($conn, $roomQuery);
    $room = mysqli_fetch_assoc($roomResult);

    $reservationQuery = "SELECT * FROM reservation WHERE RoomID = $roomID";
    $reservationResult = mysqli_query($conn, $reservationQuery);
    $reservation = mysqli_fetch_assoc($reservationResult);

    $tenantQuery = "SELECT * FROM tenant WHERE TenantID = {$reservation['TenantID']}";
    $tenantResult = mysqli_query($conn, $tenantQuery);
    $tenant = mysqli_fetch_assoc($tenantResult);
}
?>

<main id="main" class="main">
        <div class="pagetitle">
            <h1>Payment Section </h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <?php
                        $photoPaths = explode(',', $room['Photos']);
                        $firstImagePath = $photoPaths[0];
                        echo '<img src="' . $firstImagePath . '" class="card-img-top card-image" alt="Room Image">';
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tenant Information</h5>
                            <p><strong>Name:</strong> <?php echo $tenant['FirstName'] . ' ' . $tenant['LastName']; ?></p>
                            <p><strong>Email:</strong> <?php echo $tenant['Email']; ?></p>
                            <p><strong>Phone Number:</strong> <?php echo $tenant['PhoneNumber']; ?></p>
                            <p><strong>Gender:</strong> <?php echo $tenant['gender']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment Section</h5>
                            <p><strong>Boarding House Name:</strong> <?php echo $room['BoardingHouseName']; ?></p>
                             <p><strong>Price: ₱</strong> <?php echo $room['Price']; ?></p>
    
                            <form action="tenant_processing.php" method="post">
                                <input type="hidden" name="roomID" value="<?php echo $roomID; ?>">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount ₱</label>
                                    <input type="text" class="form-control" id="amount" name="amount" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dueDate" class="form-label">Due Date</label>
                                    <input type="date" class="form-control" id="dueDate" name="dueDate" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="isFirstPayment" name="isFirstPayment">
                                    <label class="form-check-label" for="isFirstPayment">First Payment</label>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Add / Approve Tenant</button>
                            </form>
                            
                        </div>
                    </div>
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
</body>

</html>
