<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ADD ROOMS - iBalay Owner</title>
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
</head>

<body>
    <?php
    // Include your database connection code
    include './../connect_db/connection.php';

    // Fetch categories from the database
    $categoryQuery = "SHOW COLUMNS FROM room WHERE Field = 'Category'";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categoryValues = getEnumValues($categoryResult);

    // Fetch barangays from the database
    $barangayQuery = "SHOW COLUMNS FROM room WHERE Field = 'Barangay'";
    $barangayResult = mysqli_query($conn, $barangayQuery);
    $barangayValues = getEnumValues($barangayResult);

    function getEnumValues($result)
    {
        $values = [];
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $options = $row['Type'];
    
            // Use regular expression to extract enum values
            preg_match_all("/'([^']+)'/", $options, $matches);
    
            if (isset($matches[1])) {
                $values = $matches[1];
            }
        }
        return $values;
    }
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Rooms</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://localhost/iBalay/dashboard.php">Home</a></li>
                <li class="breadcrumb-item">Room | Setting</li>
                <li class="breadcrumb-item active">Add Rooms</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Room Form</h5>

                        <form action="process_room.php" method="post" enctype="multipart/form-data" class="row g-3">
                            <div class="col-md-6 position-relative">
                                <label for="boardingHouseName" class="form-label">Enter Boarding House Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="boardingHouseName" name="boardingHouseName">
                                    <button class="btn btn-outline-secondary" type="button" id="boardingHouseNameDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="boardingHouseNameDropdown">
                                        <?php
                                        // Fetch existing boarding house names from the database
                                        $boardingHouseQuery = "SELECT DISTINCT BoardingHouseName FROM room WHERE OwnerID = $ownerID";
                                        $boardingHouseResult = mysqli_query($conn, $boardingHouseQuery);
                                        while ($row = mysqli_fetch_assoc($boardingHouseResult)) {
                                            $boardingHouseName = $row['BoardingHouseName'];
                                            $escapedName = htmlspecialchars($boardingHouseName, ENT_QUOTES, 'UTF-8');
                                            echo "<li><a class='dropdown-item' href='#' onclick='fillInput(\"$escapedName\")'>$escapedName</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <script>
                                // Function to fill input field with selected boarding house name
                                function fillInput(name) {
                                    document.getElementById('boardingHouseName').value = name;
                                }
                            </script>

                            <div class="col-md-6">
                                <label for="roomNumber" class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Room Gender Category</label>
                                <select id="category" class="form-select" name="category" required>
                                    <?php
                                    foreach ($categoryValues as $value) {
                                        echo "<option value=\"$value\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="barangay" class="form-label">Barangay</label>
                                <select id="barangay" class="form-select" name="barangay" required>
                                    <?php
                                    foreach ($barangayValues as $value) {
                                        echo "<option value=\"$value\">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="municipality" class="form-label">Municipality</label>
                                <select id="municipality" class="form-select" name="municipality" required>
                                    <option value="Tanauan" selected>Tanauan</option>
                                    <!-- Add other municipalities as needed -->
                                </select>
                            </div>

                            <!-- Map for pinpointing location -->
                            <div class="col-12">
                                <label for="location" class="form-label">Pinpoint Location</label>
                                <div id="map" style="height: 300px;"></div>
                                <!-- Disabled input to display location -->
                                <input type="text" id="displayLocation" class="form-control" disabled>
                                <!-- Hidden input to store location for form submission -->
                                <input type="hidden" id="location" name="location">
                            </div>

                            
                            <div class="col-md-6">
                                <label for="availability" class="form-label">Availability</label>
                                <select id="availability" class="form-select" name="availability" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>

                                    <!-- Required Photos -->
                                    <div class="col-12">
                                        <label for="requiredPhotos" class="form-label">Required Photos</label>
                                        <input type="file" class="form-control" id="requiredPhotos" name="photos[]" accept="image/*" required>
                                    </div>

                                    <!-- Optional Photos -->
                                    <div class="col-12">
                                        <label for="optionalPhotos" class="form-label">Optional Photos</label>
                                        <input type="file" class="form-control" id="optionalPhotos" name="optionalPhotos[]" accept="image/*">
                                    </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Confirm Add Room</button>
                            </div>

                            <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy'></script>
                            
<script>
    var map, marker;

    function loadMapScenario() {
        map = new Microsoft.Maps.Map(document.getElementById('map'), {
            credentials: 'AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy', // Your Bing Maps API key
            center: new Microsoft.Maps.Location(11.1090, 125.0160), // Default center for Tanauan, Leyte, Philippines
            zoom: 15,
            mapTypeId: Microsoft.Maps.MapTypeId.aerial // Set the map type to aerial
        });

        // Add marker on click
        Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
            if (!marker) {
                marker = new Microsoft.Maps.Pushpin(e.location, {
                    draggable: true,
                    title: 'Pinpointed Location'
                });
                map.entities.push(marker);
            } else {
                marker.setLocation(e.location);
            }

            // Update disabled input with location
            document.getElementById('displayLocation').value = e.location.latitude + ',' + e.location.longitude;

            // Store location for form submission
            document.getElementById('location').value = e.location.latitude + ',' + e.location.longitude;
        });
    }
</script>


                        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy&callback=loadMapScenario' async defer></script>
                        </form><!-- End Add Room Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
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
</body>

</html>
