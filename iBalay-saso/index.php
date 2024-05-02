<?php require 'sidebar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SASO ADMIN</title>
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

<!--========================================== male Card ========================================================================-->
<?php
include 'connect_db/connection.php';

// Your SQL query to count male tenants with an owner ID
$sql = "SELECT COUNT(*) AS maleCount FROM tenant WHERE Gender = 'Male' AND checked_out = 0";


$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $maleCount = $row['maleCount'];
} else {
    // Handle the error if the query fails
    $maleCount = 0;
}

// Close the database connection if needed
mysqli_close($conn);
?>
<div class="col-xxl-4 col-md-4">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Male Boarders</h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-gender-male"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $maleCount; ?></h6>
                    <span class="text-success small pt-1 fw-bold"></span>
                    <span class="text-muted small pt-2 ps-1">Total</span>
                </div>
            </div>
        </div>
    </div>
</div><!--============================================= End male Card =============================================================-->

            <!--=============================================== female Card =========================================================-->
 <?php
include 'connect_db/connection.php';

// Your SQL query to count male tenants with an owner ID
$sql = "SELECT COUNT(*) AS femaleCount FROM tenant WHERE Gender = 'Female' AND checked_out = 0";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $femaleCount = $row['femaleCount'];
} else {
    // Handle the error if the query fails
    $femaleCount = 0;
}

// Close the database connection if needed
mysqli_close($conn);
?>
<div class="col-xxl-4 col-md-4">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Female Boarders</h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-gender-female"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $femaleCount; ?></h6>
                    <span class="text-success small pt-1 fw-bold"></span>
                    <span class="text-muted small pt-2 ps-1">Total</span>
                </div>
            </div>
        </div>
    </div>
            </div><!--================================================================= End female Card ===================================-->

<!--================================================ owner Card ===========================================================-->
<?php
include 'connect_db/connection.php';

// Your SQL query to count owners
$sqlOwners = "SELECT COUNT(*) AS ownerCount FROM owners where approval_status = 0";

$resultOwners = mysqli_query($conn, $sqlOwners);

if ($resultOwners) {
    $rowOwners = mysqli_fetch_assoc($resultOwners);
    $ownerCount = $rowOwners['ownerCount'];
} else {
    // Handle the error if the query fails
    $ownerCount = 0;
}

// Close the database connection if needed
mysqli_close($conn);
?>
<div class="col-xxl-4 col-xl-4">
    <div class="card info-card revenue-card">
        <div class="card-body">
<h5 class="card-title"><a href="/iBalay.com/iBalay-saso/register-owner.php" style="color: #00008B;">Pending Landlord accounts</a></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $ownerCount; ?></h6>
                    <span class="text-success small pt-1 fw-bold"></span>
                    <span class="text-muted small pt-2 ps-1">Total</span>
                </div>
            </div>
        </div>
    </div>
</div><!--=========================================== End owner Card ========================================================-->




<!--================================================================ Pie Chart ============================================-->
<?php
include 'connect_db/connection.php';

// Your SQL queries to count male and female tenants
$sqlMaleCount = "SELECT COUNT(*) AS maleCount FROM tenant WHERE Gender = 'Male' AND checked_out = 0";
$sqlFemaleCount = "SELECT COUNT(*) AS femaleCount FROM tenant WHERE Gender = 'Female' AND checked_out = 0";

$resultMaleCount = mysqli_query($conn, $sqlMaleCount);
$resultFemaleCount = mysqli_query($conn, $sqlFemaleCount);

if ($resultMaleCount && $resultFemaleCount) {
    $rowMaleCount = mysqli_fetch_assoc($resultMaleCount);
    $rowFemaleCount = mysqli_fetch_assoc($resultFemaleCount);

    $maleCount = $rowMaleCount['maleCount'];
    $femaleCount = $rowFemaleCount['femaleCount'];
} else {
    // Handle the error if the queries fail
    $maleCount = 0;
    $femaleCount = 0;
}

// Close the database connection if needed
mysqli_close($conn);

// Check if both male and female counts are zero
if ($maleCount == 0 && $femaleCount == 0) {
    $message = "No boarders yet";
} else {
    $message = "";
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Boarders | Gender Chart</h5>
            <?php if (!empty($message)) { ?>
                <div class="alert alert-warning" role="alert"><?php echo $message; ?></div>
            <?php } ?>

            <div id="pieChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#pieChart"), {
                        series: [<?php echo $maleCount; ?>, <?php echo $femaleCount; ?>],
                        chart: {
                            height: 350,
                            type: 'pie',
                            toolbar: {
                                show: true
                            }
                        },
                        labels: ['Male Boarders', 'Female Boarders']
                    }).render();
                });
            </script>
        </div>
    </div>
</div>
<!--========================================= End Pie Chart =====================================================-->


<!--============================================ Tenants ======================================================================-->
<div class="col-12">
    <div class="card recent-sales overflow-auto">

        <div class="card-body">
            <h5 class="card-title">Boarders</h5>

            <?php
            include 'connect_db/connection.php';

            // Your SQL query to get tenants with owner ID not null
            $sqlTenants = "SELECT * FROM tenant WHERE checked_out = 0";

            $resultTenants = mysqli_query($conn, $sqlTenants);

            if ($resultTenants && mysqli_num_rows($resultTenants) > 0) {
            ?>
                <table class="table table-borderless datatable">
                    <thead>
                        <tr>
                            <th scope="col">Boarder</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowTenant = mysqli_fetch_assoc($resultTenants)) {
                        ?>
                            <tr>
                                <td><?php echo $rowTenant['FirstName'] . ' ' . $rowTenant['LastName']; ?></td>
                                <td><?php echo $rowTenant['Email']; ?></a></td>
                                <td><?php echo $rowTenant['PhoneNumber']; ?></a></td>
                                <td><?php echo $rowTenant['gender']; ?></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                // Display a message if there are no tenants with owner ID not null
                echo '<div class="alert" style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404;">';
                echo '<p>No Boarders Yet!.</p>';
                echo '</div>';
                
            }

            // Close the database connection if needed
            mysqli_close($conn);
            ?>

        </div>

    </div>
</div><!--============================================================== End Tenants ==============================-->


          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

 <!--==================================== start report download ==============================================-->
 <div class="card">
    <div class="card-body">
        <h5 class="card-title">Download report</h5>

        <?php
        include 'connect_db/connection.php';

        // Fetch and display the dropdown options
        $sqlOwners = "SELECT owner_id, name FROM owners WHERE approval_status = 1";
        $resultOwners = mysqli_query($conn, $sqlOwners);
        ?>

        <!-- HTML Form with dropdown and button -->
        <div class="d-flex">
            <select id="ownerSelect" name="owner_id" class="form-select me-2" aria-label="Select Owner">
            <option value="" selected disabled>Select Landlord</option>
                <?php
                if ($resultOwners && mysqli_num_rows($resultOwners) > 0) {
                    while ($rowOwner = mysqli_fetch_assoc($resultOwners)) {
                        echo '<option value="' . $rowOwner['owner_id'] . '">' . $rowOwner['name'] . '</option>';
                    }
                }
                ?>
            </select>

            <button type="button" class="btn btn-primary" onclick="generateReport()">
                <i class="bi bi-download"></i>
            </button>
        </div>

        <script>
            function generateReport() {
                var selectedOwnerId = document.getElementById('ownerSelect').value;

                // Validate if an owner is selected
                if (!selectedOwnerId) {
                    alert('Please select an owner.');
                    return;
                }

                // Redirect to a PHP file that generates the Excel file based on the selected owner
                window.location.href = 'generate_excel.php?owner_id=' + selectedOwnerId;
            }
        </script>

        <?php
        // Free the result set
        mysqli_free_result($resultOwners);

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</div>


<!--==================================== end report download ==============================================-->

<!-- =====start recemt activity-->

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Recent Activities</h5>

        <div class="activity">

        <?php
        include 'connect_db/connection.php';

        // SQL query to get recent activities for tenants
        $sqlRecentActivities = "SELECT t.*, r.BoardingHouseName
                                FROM tenant t
                                LEFT JOIN room r ON t.RoomID = r.RoomID
                                ORDER BY RoomID ASC
                                LIMIT 7";

        $resultRecentActivities = mysqli_query($conn, $sqlRecentActivities);

        if ($resultRecentActivities && mysqli_num_rows($resultRecentActivities) > 0) {
            while ($rowActivity = mysqli_fetch_assoc($resultRecentActivities)) {
                $tenantName = $rowActivity['FirstName'] . ' ' . $rowActivity['LastName'];
                $boardingHouseName = $rowActivity['BoardingHouseName'];

                // Check if the RoomID is null (tenant has left)
                if ($rowActivity['RoomID'] === null) {
                    // Tenant has checked out
                    $message = "Room tenant checked out: $tenantName";
                    $activityClass = 'text-danger'; // Set a class for the "left" activity
                } else {
                    // Tenant is still in the boarding house
                    $message = "New Tenant: $tenantName";
                    $activityClass = 'text-success'; // Set a class for the "new" activity
                }

                ?>
                <div class="activity-item d-flex">
                    <div class="activity-label <?php echo $activityClass; ?>"><?php echo 'New Activity'; ?></div>
                    <i class='bi bi-circle-fill activity-badge <?php echo $activityClass; ?> align-self-start'></i>
                    <div class="activity-content">
                        <?php echo $message; ?>
                    </div>
                </div><!-- End activity item-->
                <?php
            }
        } else {
            // Display a message if there are no recent activities
            echo '<div class="alert" style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404;">';
            echo '<p>No Activity.</p>';
            echo '</div>';
        }

        // SQL query to get recent activities for reports
        $sqlRecentReports = "SELECT * FROM report WHERE Acknowledge = 0 ORDER BY ReportDate DESC LIMIT 7";
        $resultRecentReports = mysqli_query($conn, $sqlRecentReports);

        if ($resultRecentReports && mysqli_num_rows($resultRecentReports) > 0) {
            while ($rowReport = mysqli_fetch_assoc($resultRecentReports)) {
                $reportText = $rowReport['ReportText'];
                $reportDate = $rowReport['ReportDate'];

                ?>
                <div class="activity-item d-flex">
                    <div class="activity-label text-info"><?php echo 'New Report'; ?></div>
                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                    <div class="activity-content">
                        <?php echo "New report submitted: $reportText"; ?>
                    </div>
                </div><!-- End activity item-->
                <?php
            }
        }

        // SQL query to get recent activities for approved owners
        $sqlRecentApprovedOwners = "SELECT * FROM owners WHERE approval_status = 1 or approval_status = 2 ORDER BY owner_id DESC LIMIT 7";
        $resultRecentApprovedOwners = mysqli_query($conn, $sqlRecentApprovedOwners);

        if ($resultRecentApprovedOwners && mysqli_num_rows($resultRecentApprovedOwners) > 0) {
            while ($rowOwner = mysqli_fetch_assoc($resultRecentApprovedOwners)) {
                $ownerName = $rowOwner['name'];

                ?>
                <div class="activity-item d-flex">
                    <div class="activity-label text-primary"><?php echo 'Approved Owner'; ?></div>
                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                    <div class="activity-content">
                        <?php echo "New owner approved: $ownerName"; ?>
                    </div>
                </div><!-- End activity item-->
                <?php
            }
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        </div>
    </div>
</div>

<!-- =====end recemt activity-->

<!--==========================================Start map =========================================================-->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">iBalay Boarding Houses Map</h5>
        <div id="bingMap" style="height: 400px; width: 100%;"></div>
    </div>
</div>

<!-- Include Bing Maps SDK script from Microsoft -->
<script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key=AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy&callback=loadMapScenario" async defer></script>

<!-- Initialize the Bing Map and load hardcoded address -->
<script>
    <?php
    include 'connect_db/connection.php';

    $sqlRoomData = "SELECT RoomID, Latitude, Longitude, BoardingHouseName, Barangay FROM room";
    $resultRoomData = mysqli_query($conn, $sqlRoomData);

    $roomData = array();

    if ($resultRoomData && mysqli_num_rows($resultRoomData) > 0) {
        while ($row = mysqli_fetch_assoc($resultRoomData)) {
            $roomData[] = array(
                'RoomID' => $row['RoomID'],
                'Latitude' => $row['Latitude'],
                'Longitude' => $row['Longitude'],
                'BoardingHouseName' => $row['BoardingHouseName'],
                'Barangay' => $row['Barangay'],
            );
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    var roomData = <?php echo json_encode($roomData); ?>;

    // Inside the loadMapScenario function
    function loadMapScenario() {
        var map = new Microsoft.Maps.Map(document.getElementById('bingMap'), {
            credentials: 'AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy',
            center: new Microsoft.Maps.Location(11.0511, 125.0144), // Centered at Tanauan, Leyte, Philippines
            zoom: 11
        });

        console.log('Map initialized:', map);

        // Load the necessary Bing Maps modules
        Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
            // Loop through room data and add pushpins to the map
            roomData.forEach(function (room) {
                var location = new Microsoft.Maps.Location(room.Latitude, room.Longitude);

                // Create a pushpin for each room
                var pushpin = new Microsoft.Maps.Pushpin(location, {
                    title: room.BoardingHouseName,
                    icon: 'assets/img/icon.png', // House point icon
                });

                // Add mouseover event to show the room details
                Microsoft.Maps.Events.addHandler(pushpin, 'mouseover', function (e) {
                    var infoContent = '<strong>Boarding House:</strong> ' + room.BoardingHouseName + '<br>';
                    infoContent += '<strong>Barangay:</strong> ' + room.Barangay + '<br>';
                    infoContent += '<strong>Latitude:</strong> ' + room.Latitude + '<br>';
                    infoContent += '<strong>Longitude:</strong> ' + room.Longitude + '<br>';

                    var infobox = new Microsoft.Maps.Infobox(pushpin.getLocation(), {
                        title: room.BoardingHouseName,
                        description: infoContent,
                    });

                    infobox.setMap(map);
                });

                // Add pushpin to the map
                map.entities.push(pushpin);
            });
        });
    }
</script>
<!--==========================================end map =========================================================-->






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

</body>

</html>