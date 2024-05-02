<?php require '../side-navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>CheckOut - iBalay Owner</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="./.././assets/img/evsu.png" rel="icon">
    <link href="./.././assets/img/evsu.png" rel="apple-touch-icon">
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
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Add these lines in the head section -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

</head>

<body>
<?php
  include './../connect_db/connection.php';

  // Get the TenantID from the URL parameter
  $tenantID = $_GET['tenantID'];

  // Fetch information from the room table
  $room_query = "SELECT room.BoardingHouseName, room.RoomNumber, CONCAT(tenant.FirstName, ' ', tenant.LastName) AS TenantName
                FROM room
                INNER JOIN tenant ON room.RoomID = tenant.RoomID
                WHERE tenant.TenantID = $tenantID";

  $room_result = mysqli_query($conn, $room_query);

  // Fetch payment information
  $payment_query = "SELECT Amount, PaymentDate FROM payment WHERE TenantID = $tenantID";
  $payment_result = mysqli_query($conn, $payment_query);
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Check out Tenant</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/iBalay.com/iBalay/dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Tenant | Setting</li>
          <li class="breadcrumb-item active">Check Out Tenant</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
  <div class="row">
    <div class="col-lg-12">

    <div class="mt-3">
        <button class="btn btn-danger" id="checkoutBtn">Checkout</button>
        <button class="btn btn-primary ml-2" id="imageBtn" onclick="saveAsImage()">Save as Image</button>
    </div>

          <br>

      <div class="card" id="pdfContent">
        <div class="card-body">
          <h5 class="card-title">Tenant Information</h5>

          <?php
          if ($room_row = mysqli_fetch_assoc($room_result)) {
          ?>
            <div class="card-body">
              <p class="card-text">Boarding House Name: <strong><?php echo $room_row['BoardingHouseName']; ?></strong></p>
              <p class="card-text">Tenant Name: <strong><?php echo $room_row['TenantName']; ?></strong></p>
              <p class="card-text">Room Number: <strong><?php echo $room_row['RoomNumber']; ?></strong></p>
            </div>
          <?php
          }
          ?>

          <hr>

<h5 class="card-title mt-3">Payments</h5>

<?php
$totalPayment = 0;
while ($payment_row = mysqli_fetch_assoc($payment_result)) {
    $totalPayment += $payment_row['Amount'];
    $paymentDate = date('F j, Y, g:i a', strtotime($payment_row['PaymentDate'])); // Format the payment date

    ?>
    <div class="card-body">
        <p class="card-text">Payment Amount: <?php echo $payment_row['Amount']; ?></p>
        <p class="card-text">Payment Date: <?php echo $paymentDate; ?></p>
        <hr>
    </div>
<?php
}
?>

<hr>

<div class="card-body">
    <p class="card-text font-weight-bold">Total Payment: <?php echo $totalPayment; ?></p>
</div>


        </div>
      </div>

    </div>
  </div>
</section>


                    <!-- Warning Modal -->
                    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog"
                        aria-labelledby="warningModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="warningModalLabel">Warning !!!</h5>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to checkout this tenant?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="confirmCheckout">Confirm
                                        Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>



  </main><!-- End #main -->

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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

 <!-- this is working -->
 <!--
  <script>
    // Function to handle the "Save as Image" button click
    function saveAsImage() {
        // Get the HTML content of the payments card
        const element = document.getElementById('pdfContent');

        // Use HTML2Canvas to render the HTML content as an image
        html2canvas(element, {
            allowTaint: true,
            useCORS: true,
            onrendered: function(canvas) {
                // Convert the canvas to a data URL
                const imageData = canvas.toDataURL();

                // Create a link element to download the image
                const link = document.createElement('a');
                link.href = imageData;
                link.download = 'payments_card.png';
                link.click();
            }
        });
    }
</script>
  -->

  <!--downloads as a http or https for webview-->
  <script>
    // Function to handle the "Save as Image" button click
    function saveAsImage() {
        // Get the HTML content of the payments card
        const element = document.getElementById('pdfContent');

        // Use HTML2Canvas to render the HTML content as an image
        html2canvas(element, {
            allowTaint: true,
            useCORS: true,
            onrendered: function(canvas) {
                // Convert the canvas to a data URL
                const dataURL = canvas.toDataURL('image/png');

                // Create a temporary anchor element
                const link = document.createElement('a');
                link.href = dataURL;
                link.download = 'payments_card.png';

                // Programmatically trigger a click event on the anchor element
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    }
</script>

<script>
    // Redirect to tenant_list.php after successful checkout
    function redirectToTenantList() {
        window.location.href = "/iBalay.com/iBalay/tenant_options/tenant_list.php";
    }

    // Show the modal when the Checkout button is clicked
    document.getElementById("checkoutBtn").addEventListener("click", function () {
        $('#warningModal').modal('show');
    });

    // Handle the checkout confirmation
    document.getElementById("confirmCheckout").addEventListener("click", function () {
        // Make an AJAX call to checkout-process.php
        $.ajax({
            type: "POST",
            url: "checkout-process.php",
            data: { tenantID: <?php echo $tenantID; ?> },
            success: function (response) {
                redirectToTenantList(); // Redirect to tenant_list.php after successful checkout
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while processing the checkout.");
            }
        });
    });
</script>


</body>

</html>
