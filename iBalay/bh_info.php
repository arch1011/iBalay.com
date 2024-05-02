<?php require 'side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Boardinbg House Information</title>
  <!-- Favicons -->
  <link href="assets/img/evsu.png" rel="icon">
    <link href="assets/img/evsu.png" rel="apple-touch-icon">
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

<body>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>BH Information</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Boarding House Information</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
            
                        <div class="alert alert-warning" role="alert">
                            Please fill out/update the form completely.
                            BH information will automatically pop up
                            every month.
                        </div>

        <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Boarding House Information Form</h5>
                <form action="info_process.php" method="post">
                                     <?php
                                    // Include the database connection file
                                    include 'connect_db/connection.php';

                                    $ownerID = $_SESSION['owner_id'];

                                    // Get existing data, if available
                                    $existingData = null;
                                    $sql = "SELECT * FROM bh_information WHERE owner_id='$ownerID'";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $existingData = mysqli_fetch_assoc($result);
                                    }
                                    ?>
        <div class="mb-3">
          <label for="complete_address" class="form-label">Complete Address:</label>
          <input type="text" class="form-control" id="complete_address" name="complete_address" value="<?php echo isset($existingData['complete_address']) ? htmlspecialchars($existingData['complete_address']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Business Permit:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="business_permit" id="business_permit_yes" value="yes" required>
            <label class="form-check-label" for="business_permit_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="business_permit" id="business_permit_no" value="no" required>
            <label class="form-check-label" for="business_permit_no">No</label>
          </div>
        </div>

        <div class="mb-3">
          <label for="monthly_payment_rate" class="form-label">Monthly Payment Rate (Price to Price):</label>
          <input type="text" class="form-control" id="monthly_payment_rate" name="monthly_payment_rate"  value="<?php echo isset($existingData['monthly_payment_rate']) ? htmlspecialchars($existingData['monthly_payment_rate']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_kitchen" class="form-label">Number of Kitchens:</label>
          <input type="number" class="form-control" id="number_of_kitchen" name="number_of_kitchen"  value="<?php echo isset($existingData['number_of_kitchen']) ? htmlspecialchars($existingData['number_of_kitchen']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_living_room" class="form-label">Number of Living Rooms:</label>
          <input type="number" class="form-control" id="number_of_living_room" name="number_of_living_room"  value="<?php echo isset($existingData['number_of_living_room']) ? htmlspecialchars($existingData['number_of_living_room']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_students_tenants" class="form-label">Number of Students Tenants (EVSU TC):</label>
          <input type="number" class="form-control" id="number_of_students_tenants" name="number_of_students_tenants" value="<?php echo isset($existingData['number_of_students_tenants']) ? htmlspecialchars($existingData['number_of_students_tenants']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_cr" class="form-label">Number of Comfort Rooms (CR):</label>
          <input type="number" class="form-control" id="number_of_cr" name="number_of_cr" value="<?php echo isset($existingData['number_of_cr']) ? htmlspecialchars($existingData['number_of_cr']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_beds" class="form-label">Number of Beds:</label>
          <input type="number" class="form-control" id="number_of_beds" name="number_of_beds" value="<?php echo isset($existingData['number_of_beds']) ? htmlspecialchars($existingData['number_of_beds']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="number_of_rooms" class="form-label">Number of Rooms:</label>
          <input type="number" class="form-control" id="number_of_rooms" name="number_of_rooms" value="<?php echo isset($existingData['number_of_rooms']) ? htmlspecialchars($existingData['number_of_rooms']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label for="bh_max_capacity" class="form-label">Boarding House Max Capacity:</label>
          <input type="number" class="form-control" id="bh_max_capacity" name="bh_max_capacity" value="<?php echo isset($existingData['bh_max_capacity']) ? htmlspecialchars($existingData['bh_max_capacity']) : ''; ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Gender Allowed:</label>
          <select class="form-select" id="gender_allowed" name="gender_allowed" required>
            <option value="male">ALL</option>
            <option value="female">Female</option>
            <option value="all">Male</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>


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