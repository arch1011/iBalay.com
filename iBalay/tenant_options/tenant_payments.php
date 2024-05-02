<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tenants Payments- iBalay Owner</title>
  <link href="./.././assets/img/evsu.png" rel="icon">
  <link href="./.././assets/img/evsu.png" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <link href="./../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./../assets/vendor/simple-datatables/style.css" rel="stylesheet">
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

<?php
include './../connect_db/connection.php';

// Assuming the session has already started
$loggedInOwnerID = $_SESSION['owner_id'] ?? null;

// Fetch tenant information for the logged-in owner
$tenant_query = "SELECT TenantID, FirstName, LastName, RoomID FROM tenant WHERE OwnerID = ?";
$stmt = mysqli_prepare($conn, $tenant_query);
mysqli_stmt_bind_param($stmt, "i", $loggedInOwnerID);
mysqli_stmt_execute($stmt);

$tenant_result = mysqli_stmt_get_result($stmt);
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tenant Payment</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://localhost/iBalay/dashboard.php">Home</a></li>
        <li class="breadcrumb-item">Tenant | Setting</li>
        <li class="breadcrumb-item active">Tenant Payment</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="container">
      <div class="row">
<div class="col-md-4">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Select Tenant</h5>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="tenantSelect" class="form-label">Select Tenant:</label>
                    <select class="form-select" id="tenantSelect" name="selectedTenant">
                        <?php
                        // Populate dropdown with tenant options
                        while ($row = mysqli_fetch_assoc($tenant_result)) {
                            echo "<option value='{$row['TenantID']}'>{$row['FirstName']} {$row['LastName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">View</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_POST['selectedTenant'])) : ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Make New Payment</h5>
<form method="post" action="payment_process.php">
    <input type="hidden" name="tenantID" value="<?php echo $_POST['selectedTenant']; ?>">
    <div class="mb-3">
        <label for="amount" class="form-label">Amount:</label>
        <input type="text" class="form-control" id="amount" name="amount">
    </div>
    <div class="mb-3">
        <label for="dueDate" class="form-label">Due Date:</label>
        <input type="date" class="form-control" id="dueDate" name="dueDate">
    </div>
    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Pay</button>
    </div>
</form>

        </div>
    </div>
    <?php endif; ?>
</div>


        <div class="col-md-8">
          <?php
          // Display selected tenant information, room details, and payment history
          if (isset($_POST['selectedTenant'])) {
            $selectedTenantID = $_POST['selectedTenant'];

            // Fetch tenant information
            $tenant_info_query = "SELECT * FROM tenant WHERE TenantID = $selectedTenantID";
            $tenant_info_result = mysqli_query($conn, $tenant_info_query);
            $tenant_info_row = mysqli_fetch_assoc($tenant_info_result);

            // Display tenant information card
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Tenant Information</h5>";
            echo "<p class='card-text'>Name: {$tenant_info_row['FirstName']} {$tenant_info_row['LastName']}</p>";
            echo "<p class='card-text'>Email: {$tenant_info_row['Email']}</p>";
            echo "<p class='card-text'>Phone Number: {$tenant_info_row['PhoneNumber']}</p>";
            echo "</div></div>";

            // Fetch payment history regardless of room status
            $payment_query = "SELECT * FROM payment_history WHERE TenantID = $selectedTenantID";
            $payment_result = mysqli_query($conn, $payment_query);

            // Display payment history card
            echo "<div class='card mt-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Payment History</h5>";
            echo "<div class='table-responsive'>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Payment ID</th>";
            echo "<th scope='col'>Amount</th>";
            echo "<th scope='col'>Due Date</th>";
            echo "<th scope='col'>Payment Date</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($payment_row = mysqli_fetch_assoc($payment_result)) {
              echo "<tr>";
              echo "<th scope='row'>{$payment_row['PaymentID']}</th>";
              echo "<td>{$payment_row['Amount']}</td>";
              echo "<td>{$payment_row['DueDate']}</td>";
              echo "<td>{$payment_row['PaymentDate']}</td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</div></div>";
          } else {
            // If no tenant is selected, display a message
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'>Please select a tenant to view payment history.</p>";
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

<!-- Include HTML2Canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<!-- Template Main JS File -->
<script src="./../assets/js/main.js"></script>

<!-- Include jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<!-- Custom Script for Downloading Information as PDF -->
<script>
  function initializeDownloadCards() {
    // Ensure jsPDF is defined before calling downloadCards
    if (typeof jsPDF !== 'undefined') {
      document.querySelector('.btn-secondary').addEventListener('click', downloadCards);
    } else {
      console.error('Error: jsPDF library is not loaded.');
    }
  }

  function downloadCards() {
    // Initialize jsPDF
    var pdf = new jsPDF('p', 'pt', 'letter');

    // Add title to PDF
    pdf.text("Tenant Payment Information", 40, 40);

    // Get the content of the cards
    var tenantInfoCard = document.querySelector(".col-md-8 .card:nth-child(1)").outerHTML;
    var paymentHistoryCard = document.querySelector(".col-md-8 .card:nth-child(3)").outerHTML;

    // Add tenant information and payment history to PDF
    pdf.fromHTML(tenantInfoCard, 40, 60);
    pdf.addPage(); // Add a new page for payment history
    pdf.fromHTML(paymentHistoryCard, 40, 40);

    // Save the PDF
    pdf.save("Tenant_Payment_Information.pdf");
  }
</script>

</body>
</html>
