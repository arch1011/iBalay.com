<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tenants History - iBalay Owner</title>
  <link href="./.././assets/img/evsu.png" rel="icon">
    <link href="./.././assets/img/evsu.png" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="./../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>

<body>
<?php
include './../connect_db/connection.php';

// Assuming the session has already started
$loggedInOwnerID = $_SESSION['owner_id'] ?? null;

// Fetch tenant history for the logged-in owner where owner_history contains the owner's ID
$tenantHistoryQuery = "SELECT T.TenantID, T.OwnerID, T.FirstName, T.LastName, T.gender, T.Email, T.PhoneNumber
                      FROM tenant T
                      WHERE FIND_IN_SET(?, T.owner_history)";
$stmt = mysqli_prepare($conn, $tenantHistoryQuery);
mysqli_stmt_bind_param($stmt, "i", $loggedInOwnerID);
mysqli_stmt_execute($stmt);
$tenantHistoryResult = mysqli_stmt_get_result($stmt);
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Boarder List History</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="https://ibalay-project.000webhostapp.com/iBalay.com/iBalay/dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Boarder | Setting</li>
          <li class="breadcrumb-item active">Boarder History</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Boarder List History</h5>

              <!-- Add the "table-responsive" class for mobile responsiveness -->
    <div class="table-responsive">
        <table id="tenantTable" class="table">
            <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
                   <?php
                    // Populate table with tenant history information
                    while ($row = mysqli_fetch_assoc($tenantHistoryResult)) {
                      echo "<tr>";
                      echo "<td>{$row['FirstName']} {$row['LastName']}</td>";
                      echo "<td>{$row['PhoneNumber']}</td>";
                      echo "<td>{$row['Email']}</td>";
                      echo "<td>{$row['gender']}</td>";
                      echo "</tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
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

  <!-- DataTables JS -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

  <!-- Template Main JS File -->
  <script src="./../assets/js/main.js"></script>


  <!-- DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>


<script>
  $(document).ready(function () {
    var table = $('#tenantTable').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    table.button('print').action(function (e, dt, button, config) {
      var idx = dt.rows({ selected: true }).indexes();
      var data = dt.cells(idx, ':visible').data().toArray();
      console.log(data);
      dt.rows.add(data).draw();
      dt.rows().invalidate('data');
      dt.draw(false);
      dt.button('print').trigger();
    });
</script>



</body>

</html>
