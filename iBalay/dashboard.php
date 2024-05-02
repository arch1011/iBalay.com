<?php require 'side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>iBalay Owner - Dashboard Panel</title>
  <!-- Favicons 
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">
  -->
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body> 

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboad Panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard Panel</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <?php
// Fetch owner's warning data
$ownerID = $_SESSION['owner_id'];
$getOwnerQuery = "SELECT warnings FROM owners WHERE owner_id = $ownerID";
$ownerResult = mysqli_query($conn, $getOwnerQuery);
if ($ownerResult) {
    $ownerData = mysqli_fetch_assoc($ownerResult);
    $warnings = $ownerData['warnings'];

    // Define warning messages
    $warningMessages = [
        1 => "This is your 1st warning, You have been reported and SASO will take action if this continue. Thank You!.",
        2 => "This is your 2nd warning, You have been reported and SASO will take action if this continue. Thank You!",
        3 => "This is your final warning, You have been reported and SASO will take action if this continue. Thank You!"
    ];

    // Determine the appropriate warning message
    $warningMessage = isset($warningMessages[$warnings]) ? $warningMessages[$warnings] : "You have no warnings.";

    // Display the warning message with close button
    echo "<div class='alert alert-warning alert-dismissible' role='alert'>";
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
    echo $warningMessage;
    echo "</div>";
} else {
    echo "Error fetching owner data: " . mysqli_error($conn);
}
?>



    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

<!-- Tenant Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card tenant-card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="?gender=all">All</a></li>
                <li><a class="dropdown-item" href="?gender=male">Male</a></li>
                <li><a class="dropdown-item" href="?gender=female">Female</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h5 class="card-title">Total Boarders</h5>
            <?php
            // Initialize the filter variable
            $genderFilter = isset($_GET['gender']) ? $_GET['gender'] : 'all';
            $ownerID = $_SESSION['owner_id'];

            // Construct the SQL query based on the gender filter and owner ID
            if ($genderFilter === 'all') {
                $filterCondition = " WHERE OwnerID = $ownerID AND checked_out = 0"; // Filter only checked-in tenants
            } else {
                $filterCondition = " WHERE Gender = '$genderFilter' AND OwnerID = $ownerID AND checked_out = 0"; // Filter only checked-in tenants
            }

            // Fetch total checked-in tenant counts
            $totalCheckedInTenantQuery = "SELECT COUNT(*) AS totalCheckedInTenants FROM tenant" . $filterCondition;
            $totalCheckedInTenantResult = mysqli_query($conn, $totalCheckedInTenantQuery);
            $totalCheckedInTenants = mysqli_fetch_assoc($totalCheckedInTenantResult)['totalCheckedInTenants'];
            ?>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-house-fill"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $totalCheckedInTenants; ?></h6>
                    <span class="text-muted small pt-2 ps-1">Checked-in Boarders</span>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Tenant Card -->

<!-- Checked out Tenant Card -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card tenant-card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="?gender=all">All</a></li>
                <li><a class="dropdown-item" href="?gender=male">Male</a></li>
                <li><a class="dropdown-item" href="?gender=female">Female</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h5 class="card-title">Checked-out</h5>
            <?php
            // Initialize the filter variable
            $genderFilter = isset($_GET['gender']) ? $_GET['gender'] : 'all';
            $ownerID = $_SESSION['owner_id'];

            // Fetch total checked-out tenant counts from tenant table where owner_history contains the owner's ID
            $totalCheckedOutTenantQuery = "SELECT COUNT(*) AS totalCheckedOutTenants FROM tenant WHERE FIND_IN_SET($ownerID, owner_history)";
            $totalCheckedOutTenantResult = mysqli_query($conn, $totalCheckedOutTenantQuery);

            if ($totalCheckedOutTenantResult) {
                $totalCheckedOutTenants = mysqli_fetch_assoc($totalCheckedOutTenantResult)['totalCheckedOutTenants'];
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
            ?>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $totalCheckedOutTenants; ?></h6>
                    <span class="text-muted small pt-2 ps-1">Previous Boarders</span>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Tenant Card -->



                  <!-- Revenue Card -->
                  <div class="col-xxl-4 col-md-6">
                      <div class="card info-card revenue-card">

                          <div class="filter">
                              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                  <li class="dropdown-header text-start">
                                      <h6>Filter</h6>
                                  </li>
                                  <li><a class="dropdown-item" href="?filter=total">Total</a></li>
                                  <li><a class="dropdown-item" href="?filter=this_month">This Month</a></li>
                                  <li><a class="dropdown-item" href="?filter=last_month">Last Month</a></li>
                              </ul>
                          </div>

                          <div class="card-body">
                              <?php
                              // Assuming you have a database connection
                              include 'connect_db/connection.php';

                              // Set default filter if not provided in the URL
                              $filter = isset($_GET['filter']) ? $_GET['filter'] : 'this_month';

                              // Adjust the SQL query based on the selected filter
                              $sqlConditions = '';

                              switch ($filter) {
                                  case 'total':
                                      // No additional conditions for total
                                      break;
                                  case 'this_month':
                                      $sqlConditions = " AND MONTH(PaymentDate) = MONTH(NOW()) AND YEAR(PaymentDate) = YEAR(NOW())";
                                      break;
                                  case 'last_month':
                                      $sqlConditions = " AND MONTH(PaymentDate) = MONTH(NOW() - INTERVAL 1 MONTH) AND YEAR(PaymentDate) = YEAR(NOW() - INTERVAL 1 MONTH)";
                                      break;
                              }

                              $query = "SELECT SUM(Amount) AS totalIncome FROM payment_history WHERE OwnerID IS NOT NULL $sqlConditions";
                              $result = mysqli_query($conn, $query);

                              if ($result) {
                                  $row = mysqli_fetch_assoc($result);
                                  $totalIncome = $row['totalIncome'];
                              } else {
                                  $totalIncome = 0;
                              }
                              ?>

                              <h5 class="card-title">Revenue <span>| <?php echo ucfirst(str_replace('_', ' ', $filter)); ?></span></h5>

                              <div class="d-flex align-items-center">
                                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                      <i class="bi bi-currency-dollar"></i>
                                  </div>
                                  <div class="ps-3">
                                      <h6>₱<?php echo number_format($totalIncome, 2); ?></h6>
                                      <!-- You can add percentage and increase message based on your logic -->
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div><!-- End Revenue Card -->


                  <!-- Recent Tenants -->
                  <div class="col-12">
                    <div class="card recent-tenants overflow-auto">


                      <div class="card-body">
                        <h5 class="card-title">Tenants Mini List</span></h5>

                        <table class="table table-borderless datatable">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Tenant</th>
                              <th scope="col">Room</th>
                              <th scope="col">Due Date</th>
                              <th scope="col">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            // Fetch recent tenants for the specific owner
                            $recentTenantsQuery = "SELECT tenant.TenantID, tenant.FirstName, tenant.LastName, room.RoomNumber, payment.DueDate
                              FROM tenant
                              LEFT JOIN room ON tenant.RoomID = room.RoomID
                              LEFT JOIN payment ON tenant.TenantID = payment.TenantID
                              WHERE room.OwnerID = $ownerID AND payment.OwnerID = $ownerID
                              ORDER BY payment.PaymentDate DESC
                              LIMIT 5";

                            $recentTenantsResult = mysqli_query($conn, $recentTenantsQuery);

                            if ($recentTenantsResult) {
                              while ($row = mysqli_fetch_assoc($recentTenantsResult)) {
                                echo "<tr>";
                                echo "<th scope='row'>{$row['TenantID']}</th>";
                                echo "<td>{$row['FirstName']} {$row['LastName']}</td>";
                                echo "<td>{$row['RoomNumber']}</td>";
                                echo "<td>{$row['DueDate']}</td>";

                                // Check if the tenant is due or paid
                                if (empty($row['DueDate'])) {
                                  // No Due Date, display a button indicating no due date
                                  echo "<td><button class='btn btn-secondary' disabled>No Due Date</button></td>";
                                } else {
                                  $dueDate = strtotime($row['DueDate']);
                                  $today = strtotime(date('Y-m-d'));

                                  // Check if the due date has passed
                                  if ($dueDate < $today) {
                                    // If due date has passed, display a red button
                                    echo "<td><button class='btn btn-danger' disabled>Due</button></td>";
                                  } else {
                                    // If due date is in the future, display a green button
                                    echo "<td><button class='btn btn-success' disabled>Due Soon</button></td>";
                                  }
                                }

                                echo "</tr>";
                              }
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>

                    </div>
                  </div><!-- End Recent Tenants -->


          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity 
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div> End activity item

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div> End activity item

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div> End activity item

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div> End activity item

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div>End activity item

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div> End activity item

              </div>

            </div>
          </div> End Recent Activity -->

        </div><!-- End Right side columns -->

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

<script src="notification.js"></script>

</body>

</html>