<?php
session_start();
include 'connect_db/connection.php';

if (!isset($_SESSION['TenantID'])) {
    header("Location: /iBalay.com/iBalay-student/login.php"); 
    exit();
}

$tenantID = $_SESSION['TenantID'];
?>

<head>
        <!-- Favicons -->
    <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">
</head>

<!-- ======= Property Search Section ======= -->
<div class="click-closed"></div>
<!--/ Form Search Star /-->
<div class="box-collapse">
    <div class="title-box-d">
        <h3 class="title-d">Search Property</h3>
    </div>
    <span class="close-box-collapse right-boxed bi bi-x"></span>
    <div class="box-collapse-wrap form">
        <form action="search_result.php" method="GET" class="form-a">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="form-group mt-3">
                        <label class="pb-2" for="Type">Type</label>
                        <select class="form-control form-select form-control-a" id="Type" name="Type">
                            <option>All Type</option>
                            <?php 
                            $category_query = "SELECT DISTINCT Category FROM room";
                            $category_result = mysqli_query($conn, $category_query);
                            while ($row = mysqli_fetch_assoc($category_result)) {
                                echo "<option>" . $row['Category'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group mt-3">
                        <label class="pb-2" for="city">City</label>
                        <select class="form-control form-select form-control-a" id="city" name="city">
                            <option>All City</option>
                            <?php 
                            $municipality_query = "SELECT DISTINCT Municipality FROM room";
                            $municipality_result = mysqli_query($conn, $municipality_query);
                            while ($row = mysqli_fetch_assoc($municipality_result)) {
                                echo "<option>" . $row['Municipality'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group mt-3">
                        <label class="pb-2" for="barangay">Barangay</label>
                        <select class="form-control form-select form-control-a" id="barangay" name="barangay">
                            <option>All Barangay</option>
                            <?php 
                            $barangay_query = "SELECT DISTINCT Barangay FROM room";
                            $barangay_result = mysqli_query($conn, $barangay_query);
                            while ($row = mysqli_fetch_assoc($barangay_result)) {
                                echo "<option>" . $row['Barangay'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
   

                <div id="price-capacity-inputs">
                    <div class="col-md-6 mb-2">
                        <div class="form-group mt-3">
                            <label class="pb-2" for="price">Price</label>
                            <input type="text" class="form-control form-control-lg form-control-a" id="price" name="price" placeholder="Enter Price">
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group mt-3">
                            <label class="pb-2" for="capacity">Capacity</label>
                            <input type="text" class="form-control form-control-lg form-control-a" id="capacity" name="capacity" placeholder="Enter Capacity">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-2">
                    <div class="form-group mt-3">
                        <label class="pb-2" for="use-dropdown">Use Dropdown</label>
                        <input type="checkbox" class="form-check-input" id="use-dropdown" name="use_dropdown">
                    </div>
                </div>

                <div id="price-capacity-dropdowns" style="display: none;">
                    <div class="col-md-6 mb-2">
                        <div class="form-group mt-3">
                            <label class="pb-2" for="price-dropdown">Price Dropdown</label>
                            <select class="form-control form-select form-control-a" id="price-dropdown" name="price_dropdown">
                                <?php 
                                $price_query = "SELECT DISTINCT Price FROM room";
                                $price_result = mysqli_query($conn, $price_query);
                                while ($row = mysqli_fetch_assoc($price_result)) {
                                    echo "<option>" . $row['Price'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group mt-3">
                            <label class="pb-2" for="capacity-dropdown">Capacity Dropdown</label>
                            <select class="form-control form-select form-control-a" id="capacity-dropdown" name="capacity_dropdown">
                                <?php 
                                $capacity_query = "SELECT DISTINCT Capacity FROM room";
                                $capacity_result = mysqli_query($conn, $capacity_query);
                                while ($row = mysqli_fetch_assoc($capacity_result)) {
                                    echo "<option>" . $row['Capacity'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                              
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-b">Search Property</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Property Search Section -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    var checkbox = document.getElementById('use-dropdown');
    var priceCapacityInputs = document.getElementById('price-capacity-inputs');
    var priceCapacityDropdowns = document.getElementById('price-capacity-dropdowns');
    
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            priceCapacityInputs.style.display = "none";
            priceCapacityDropdowns.style.display = "block";
        } else {
            priceCapacityInputs.style.display = "block";
            priceCapacityDropdowns.style.display = "none";
        }
    });
});
</script>







<!-- ======= Header/Navbar ======= -->
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
  <div class="container">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <a class="navbar-brand text-brand" href="/iBalay.com/iBalay-student/index.php">iBalay<span class="color-b">BH</span></a>

    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link active" href="index.php">
            <i class="bi bi-house-door"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="BoardingHouse.php">
            <i class="bi bi-list-ul"></i> BH list
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/iBalay.com/iBalay-student/my_room.php">
            <i class="bi bi-door-open"></i> My Room
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/iBalay.com/iBalay-student/payment_history.php">
            <i class="bi bi-cash"></i> Payment History
          </a>
        </li>
<?php
include 'connect_db/connection.php';

$tenantID = $_SESSION['TenantID'] ?? null;

if ($tenantID) {
    $bookmarkQuery = "SELECT COUNT(*) AS total FROM bookmark WHERE TenantID = $tenantID";
    $bookmarkResult = mysqli_query($conn, $bookmarkQuery);

    if ($bookmarkResult) {
        $bookmarkCount = mysqli_fetch_assoc($bookmarkResult)['total'];
    } else {
        $bookmarkCount = 0;
    }
} else {
    $bookmarkCount = 0;
}
?>

<li class="nav-item">
    <a class="nav-link" href="/iBalay.com/iBalay-student/bookmarked.php">
        <i class="bi bi-bookmark"></i> Bookmarked
        <?php if ($bookmarkCount > 0): ?>
            <span class="badge bg-danger"><?php echo $bookmarkCount; ?></span>
        <?php endif; ?>
    </a>
</li>

<?php
include 'connect_db/connection.php';

$tenantID = $_SESSION['TenantID'] ?? null;

if ($tenantID) {
    $reservationQuery = "SELECT COUNT(*) AS total FROM reservation WHERE TenantID = $tenantID";
    $reservationResult = mysqli_query($conn, $reservationQuery);

    if ($reservationResult) {
        $reservationCount = mysqli_fetch_assoc($reservationResult)['total'];
    } else {
        $reservationCount = 0;
    }
} else {
    $reservationCount = 0;
}
?>

        <li class="nav-item">
          <a class="nav-link" href="/iBalay.com/iBalay-student/reserved_bh.php">
            <i class="bi bi-calendar-check"></i> Reserved
            <?php if ($reservationCount > 0): ?>
            <span class="badge bg-danger"><?php echo $reservationCount; ?></span>
            <?php endif; ?>
          </a>
        </li>
        
<?php
// Calculate the number of unnotified inquiries with non-null replies for the logged-in tenant
$unnotifiedInquiryQuery = "SELECT COUNT(DISTINCT inquiry.InquiryID) AS total 
                          FROM inquiry 
                          INNER JOIN reply ON inquiry.InquiryID = reply.InquiryID 
                          WHERE inquiry.TenantID = $tenantID 
                          AND reply.ReplyMessage IS NOT NULL 
                          AND reply.Notified = 0";
$unnotifiedInquiryResult = mysqli_query($conn, $unnotifiedInquiryQuery);
$unnotifiedInquiryCount = mysqli_fetch_assoc($unnotifiedInquiryResult)['total'];
?>

<li class="nav-item">
    <a class="nav-link" href="/iBalay.com/iBalay-student/inquiry_notif.php?action=update_notified">
        <i class="bi bi-chat-dots"></i> Inquiries
        <?php if ($unnotifiedInquiryCount > 0): ?>
            <span class="badge bg-danger"><?php echo $unnotifiedInquiryCount; ?></span>
        <?php endif; ?>
    </a>
</li>

<?php
// Calculate the number of acknowledged reports for the logged-in tenant
$acknowledgedReportQuery = "SELECT COUNT(*) AS total FROM report WHERE TenantID = $tenantID AND Acknowledge = 1 AND Notified = 0";
$acknowledgedReportResult = mysqli_query($conn, $acknowledgedReportQuery);
$acknowledgedReportCount = mysqli_fetch_assoc($acknowledgedReportResult)['total'];
?>

<li class="nav-item">
    <a class="nav-link" href="/iBalay.com/iBalay-student/report_notif.php?action=update_notified">
        <i class="bi bi-exclamation-diamond-fill"></i> Reports
        <?php if ($acknowledgedReportCount > 0): ?>
            <span class="badge bg-danger"><?php echo $acknowledgedReportCount; ?></span>
        <?php endif; ?>
    </a>
</li>


        <li class="nav-item">
          <a class="nav-link" href="/iBalay.com/iBalay-student/profile.php">
            <i class="bi bi-person"></i> Profile
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout_process.php">
            <i class="bi bi-box-arrow-right"></i> Log out
          </a>
        </li>

      </ul>
    </div>

    <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
      <i class="bi bi-search"></i>
    </button>

  </div>
</nav><!-- End Header/Navbar -->

