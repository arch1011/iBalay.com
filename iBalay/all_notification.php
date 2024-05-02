<?php require 'side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>All Notifications</title>
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>All Notifications</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="http://localhost/iBalay/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Notification</li>
                    <li class="breadcrumb-item active">All</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="container-fluid">
            <!-- Display all notifications here -->
            <div class="notifications">
                <div class="row">
                    <?php
                    // Display notifications
                    foreach ($allNotifications as $notification) {
                        echo '<div class="col-md-4">';
                        echo '<a href="'; // Opening anchor tag
                        if ($notification['notification_type'] == 'inquiry') {
                            echo 'https://ibalay-project.000webhostapp.com/iBalay.com/iBalay/inquiries/inquiry_page.php?roomID=' . $notification['RoomID'];
                        } else {
                            echo '/iBalay.com/iBalay/Reserved_Rooms/reserved_room.php?roomID=' . $notification['RoomID'];
                        }
                        echo '">'; // Closing anchor tag
                        echo '<div class="card mb-4">';
                        echo '<div class="card-body">';
                        if ($notification['notification_type'] == 'inquiry') {
                            echo '<h4 class="card-title">Inquiry for Room ' . $notification['RoomNumber'] . '</h4>';
                            echo '<p class="card-text">New inquiry received</p>';
                        } elseif ($notification['notification_type'] == 'reservation') {
                            echo '<h4 class="card-title">Reservation for Room ' . $notification['RoomNumber'] . '</h4>';
                            echo '<p class="card-text">New reservation received</p>';
                        } elseif ($notification['notification_type'] == 'due_payment') {
                            echo '<h4 class="card-title">Due payment</h4>';
                            echo '<p class="card-text">Payment due on ' . $notification['notification_date'] . '</p>';
                            echo '<p class="card-text">Tenant name: ' . $notification['FirstName'] . ' ' . $notification['LastName'] . '</p>';
                        }
                        echo '<p class="card-text">' . $notification['notification_date'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>'; // Closing anchor tag
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>
