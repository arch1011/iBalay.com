<?php require 'headbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Update Profile -Profile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

<!-- Bootstrap JS and dependencies 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
-->

<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

  <main id="main">

<!-- ======= Intro Single ======= -->
<section class="intro-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <?php
          // Fetch tenant data from the database based on the tenant ID stored in the session
          $tenantID = $_SESSION['TenantID'];
          $query = "SELECT * FROM tenant WHERE TenantID = $tenantID";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            $tenantData = mysqli_fetch_assoc($result);
            echo '<div class="title-single-box">';
            echo '<h1 class="title-single">' . $tenantData['FirstName'] . ' ' . $tenantData['LastName'] . '</h1>';
            echo '<span class="color-text-a">Tenant</span>';
            echo '</div>';
          } else {
            echo '<div class="title-single-box">';
            echo '<h1 class="title-single">Tenant Not Found</h1>';
            echo '</div>';
          }
        ?>
      </div>
      <div class="col-md-12 col-lg-4">
        <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/iBalay.com/iBalay-student/index.php">Home</a>
            </li>
            <li class="breadcrumb-item">
              <a href="">Profile</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <?php
                // Display tenant name in breadcrumb if tenant data is available
                if (isset($tenantData)) {
                  echo $tenantData['FirstName'] . ' ' . $tenantData['LastName'];
                } else {
                  echo 'Tenant Not Found';
                }
              ?>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section><!-- End Intro Single -->


<!-- ======= Tenant Single ======= -->
<section class="tenant-single">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
        <div class="col-md-6">
        <div class="tenant-avatar-box">
    <?php
    // Display tenant photo
    if (isset($tenantData)) {
        // Assuming 'Photos' column in the tenant table contains the photo paths
        $photoPaths = explode(',', $tenantData['Photos']);

        // Check if the first photo path is not empty
        if (!empty($photoPaths[0])) {
            $uploadDir = '/iBalay.com/uploads/'; // Update this with your actual path
            $fullPath = $uploadDir . trim($photoPaths[0]);
            echo '<div class="img-box-a">';
            echo '<img src="' . $fullPath . '" alt="Tenant Photo" class="img-a img-fluid">';
            echo '</div>';
        } else {
            // If the first path is empty, show a default photo
            echo '<img src="assets/img/default-tenant-photo.jpg" alt="Default Tenant Photo" class="tenant-avatar img-fluid">';
        }
    } else {
        echo '<img src="assets/img/default-tenant-photo.jpg" alt="Default Tenant Photo" class="tenant-avatar img-fluid">';
    }
    ?>
</div>

          <div class="col-md-5 section-md-t3">
            <div class="tenant-info-box">
              <div class="tenant-title">
                <div class="title-box-d">
                  <h3 class="title-d">
                    <?php
                      // Display tenant name
                      if (isset($tenantData)) {
                        echo $tenantData['FirstName'] . ' ' . $tenantData['LastName'];
                      } else {
                        echo 'Tenant Not Found';
                      }
                    ?>
                  </h3>
                </div>
              </div>
              <div class="tenant-content mb-3">
                <div class="info-tenants color-a">
                  <p>
                    <strong>Email: </strong>
                    <span class="color-text-a">
                      <?php
                        // Display tenant email
                        if (isset($tenantData)) {
                          echo $tenantData['Email'];
                        } else {
                          echo 'Email Not Found';
                        }
                      ?>
                    </span>
                  </p>
                  <p>
                    <strong>Phone: </strong>
                    <span class="color-text-a">
                      <?php
                        // Display tenant phone number
                        if (isset($tenantData)) {
                          echo $tenantData['PhoneNumber'];
                        } else {
                          echo 'Phone Number Not Found';
                        }
                      ?>
                    </span>
                  </p>
                  <p>
                    <strong>Gender: </strong>
                    <span class="color-text-a">
                      <?php
                        // Display tenant gender
                        if (isset($tenantData)) {
                          echo $tenantData['gender'];
                        } else {
                          echo 'Gender Not Found';
                        }
                      ?>
                    </span>
                  </p>
                </div>



<!-- Add this to the button in your Tenant Single section -->
<div class="mt-4">
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
    Update Profile
  </button>
</div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Tenant Single -->


  </main><!-- End #main -->

<?php
include 'footer.php'
?>


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

<!-- Add this modal at the end of your HTML body -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
      </div>
      <div class="modal-body">
        <!-- Include your update profile form here -->
        <!-- This form should include fields for FirstName, LastName, Email, PhoneNumber, gender, and Photos -->
        <!-- Make sure to use appropriate input types and form elements -->
        <form id="updateProfileForm" method="post" action="update_profile.php" enctype="multipart/form-data">
 
          <!-- FirstName -->
          <div class="mb-3">
            <label for="updateFirstName" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" value="<?php echo $tenantData['FirstName']; ?>" required>
          </div>

          <!-- LastName -->
          <div class="mb-3">
            <label for="updateLastName" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="updateLastName" name="updateLastName" value="<?php echo $tenantData['LastName']; ?>" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="updateEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="updateEmail" name="updateEmail" value="<?php echo $tenantData['Email']; ?>" required>
          </div>

          <!-- PhoneNumber -->
          <div class="mb-3">
            <label for="updatePhoneNumber" class="form-label">Phone Number:</label>
            <input type="tel" class="form-control" id="updatePhoneNumber" name="updatePhoneNumber" value="<?php echo $tenantData['PhoneNumber']; ?>" required>
          </div>

          <!-- Gender -->
          <div class="mb-3">
            <label for="updateGender" class="form-label">Gender:</label>
            <select class="form-select" id="updateGender" name="updateGender" required>
              <option value="Male" <?php echo ($tenantData['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
              <option value="Female" <?php echo ($tenantData['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
          </div>

          <!-- Photos (you may need to adjust this based on your specific requirements) -->
 <!-- New field for photo upload -->
 <div class="mb-3">
 <label for="updatePhoto">Profile Photo:</label>
    <input type="file" id="updatePhoto" name="updatePhoto">
   </div>

    <!-- Submit button -->
    <div class="mb-3">
    <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
  </form>
      </div>
    </div>
  </div>
</div>



</html>