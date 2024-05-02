<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ROOMS INFO - iBalay Owner</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
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
  <link href="../assets/css/style.css" rel="stylesheet">

  <style>
    /* Custom style to add space between tenant information and buttons on smaller screens */
    @media (max-width: 767px) {
      .card {
        margin-top: 20px;
      }
    }
  </style>

</head>

<body>
<?php
    include './../connect_db/connection.php';

    // Fetch room information
    $room_query = "SELECT RoomID, RoomNumber FROM room";
    $room_result = mysqli_query($conn, $room_query);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Room Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://localhost/iBalay/dashboard.php">Home</a></li>
                <li class="breadcrumb-item">Room | Setting</li>
                <li class="breadcrumb-item active">Room Information</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="roomSelect" class="form-label">Select Room:</label>
                            <select class="form-select" id="roomSelect" name="selectedRoom">
                                <?php
                                    // Populate dropdown with room options
                                    while ($row = mysqli_fetch_assoc($room_result)) {
                                        echo "<option value='{$row['RoomID']}'>{$row['RoomNumber']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="printCards()">Print</button>
                    </form>
                </div>

                <div class="col-md-8">
                    <?php
                        // Display tenant information and accumulated amount based on selected room
                        if (isset($_POST['selectedRoom'])) {
                            $selectedRoomID = $_POST['selectedRoom'];
                    
                            // Fetch tenant information
                            $tenant_query = "SELECT * FROM tenant WHERE RoomID = $selectedRoomID";
                            $tenant_result = mysqli_query($conn, $tenant_query);
                    
                            // Check if there is a tenant
                            if ($tenant_result && mysqli_num_rows($tenant_result) > 0) {
                                $tenant_row = mysqli_fetch_assoc($tenant_result);
                    
                                // Display tenant information card
                                echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>Renting tenant</h5>";
                                echo "<p class='card-text'>Tenant Name: {$tenant_row['FirstName']} {$tenant_row['LastName']}</p>";
                                echo "<p class='card-text'>Email: {$tenant_row['Email']}</p>";
                                echo "<p class='card-text'>Phone Number: {$tenant_row['PhoneNumber']}</p>";
                                echo "</div></div>";
                            } else {
                                // Display a message if there is no tenant
                                echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>Tenant Information</h5>";
                                echo "<p class='card-text'>No tenant currently renting this room.</p>";
                                echo "</div></div>";
                            }
                    
                            // Fetch accumulated amount
                            $amount_query = "SELECT SUM(Amount) AS TotalAmount FROM payment WHERE RoomID = $selectedRoomID";
                            $amount_result = mysqli_query($conn, $amount_query);
                            $amount_row = mysqli_fetch_assoc($amount_result);
                    
                            // Display accumulated amount card
                            echo "<div class='card mt-3'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Accumulated Amount</h5>";
                            echo "<p class='card-text'>Total Amount: {$amount_row['TotalAmount']}</p>";
                            echo "</div></div>";
                        }
                    ?>
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

<!-- Template Main JS File -->
<script src="./../assets/js/main.js"></script>
</body>
<script>
function printCards() {
    // Create a new window for printing
    var printWindow = window.open('', '_blank');

    // Define the content to be printed
    var printContent = "<html><head>" +
        "<style>" +
        "body { font-family: 'Arial', sans-serif; margin: 20px; }" +
        ".card { border: 1px solid #000; padding: 10px; margin-bottom: 10px; }" +
        "</style>" +
        "</head><body>";

    // Get the content of the cards
    var tenantInfoCard = document.querySelector(".col-md-8 .card:nth-child(1)").outerHTML;
    var accumulatedAmountCard = document.querySelector(".col-md-8 .card:nth-child(2)").outerHTML;

    printContent += "<h2>Receipt</h2>";
    printContent += "<h3>Tenant Information</h3>" + tenantInfoCard;
    printContent += "<h3>Accumulated Amount</h3>" + accumulatedAmountCard;

    printContent += "</body></html>";

    // Write the content to the new window
    printWindow.document.write(printContent);

    // Close the document after writing to ensure proper rendering
    printWindow.document.close();

    // Print the window
    printWindow.print();
}

  </script>

</html>