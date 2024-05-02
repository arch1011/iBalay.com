<?php
require 'session.php';

$sql = "SELECT *, TIMESTAMPDIFF(MINUTE, last_submission_time, NOW()) AS minutes_since_submission FROM bh_information WHERE owner_id = '$ownerID'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Handle the database query error
    die("Database query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) === 0 && basename($_SERVER['PHP_SELF']) !== 'bh_info.php') {
    // If the owner does not have a record and the current script is not bh_info.php, redirect to bh_info.php
    header("Location: /iBalay.com/iBalay/bh_info.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// Check if $row is not null before accessing its elements
if ($row !== null) {
    echo "Minutes since submission: " . $row['minutes_since_submission']; // Debugging statement
    if ($row['minutes_since_submission'] > 20 && basename($_SERVER['PHP_SELF']) !== 'bh_info.php') {
        // If it's been more than 20 minutes since the last submission, redirect to bh_info.php
        header("Location: /iBalay.com/iBalay/bh_info.php");
        exit();
    }
} else {

}



$query = "SELECT username, name, location, contact_number, email, photo FROM owners WHERE owner_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $ownerID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
        $username = $userData['username'];
        $name = $userData['name'];
        $location = $userData['location'];
        $phone = $userData['contact_number'];
        $email = $userData['email'];
        $photoUrl = $userData['photo'];
// Assuming $photoUrl contains the filename, e.g., "1.png"
// Assuming $photoUrl contains the filename, e.g., "1.png"
$uploads = $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . basename($photoUrl);

if (file_exists($uploads)) {
    // File exists, proceed
} else {
    // Handle the case where the file doesn't exist
}
}


    // Function to get notifications related to inquiries
function getInquiryNotifications($ownerID, $conn)
{
    $query = "SELECT RoomID, InquiryDate FROM inquiry WHERE OwnerID = ? ORDER BY InquiryDate DESC LIMIT 5";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $ownerID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $notifications = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $notifications;
    } else {
        // Handle the case where the prepared statement failed
        return array();
    }
}
}

function getAllNotifications($ownerID, $conn)
{
    $query = "SELECT 'inquiry' AS notification_type, i.RoomID, r.RoomNumber, NULL AS TenantID, NULL AS FirstName, NULL AS LastName, i.InquiryDate AS notification_date
              FROM inquiry i
              JOIN room r ON i.RoomID = r.RoomID
              WHERE i.OwnerID = ?
              UNION
              SELECT 'reservation' AS notification_type, r.RoomID, r.RoomNumber, NULL AS TenantID, NULL AS FirstName, NULL AS LastName, rv.ReservedDate AS notification_date
              FROM reservation rv
              JOIN room r ON rv.RoomID = r.RoomID
              WHERE rv.OwnerID = ?
              UNION
              SELECT 'due_payment' AS notification_type, p.RoomID, r.RoomNumber, t.TenantID, t.FirstName, t.LastName, p.DueDate AS notification_date
              FROM payment p
              JOIN tenant t ON p.TenantID = t.TenantID
              JOIN room r ON p.RoomID = r.RoomID
              WHERE p.OwnerID = ? AND p.DueDate <= CURDATE()
              ORDER BY notification_date DESC LIMIT 5";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iii", $ownerID, $ownerID, $ownerID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $notifications = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }

        mysqli_stmt_close($stmt);

        return $notifications;
    } else {
        // Handle the case where the prepared statement failed
        return array();
    }
}

// Example usage to get all notifications
$allNotifications = getAllNotifications($ownerID, $conn);




?>
<head>
      <link href="assets/img/evsu.png" rel="icon">
    <link href="assets/img/evsu.png" rel="apple-touch-icon">
</head>


<!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="/iBalay.com/iBalay/dashboard.php" class="logo d-flex align-items-center">
    <img src="assets/img/evsu.png" alt="" loading="lazy">
    <span class="d-none d-lg-block">Owner | Dashboard</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

  <!--start notification -->
  <li class="nav-item dropdown">
  <a id="notification-icon" class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <?php
        // Count the number of new notifications (inquiries)
        $newNotificationsCount = count(getInquiryNotifications($ownerID, $conn));
        ?>
        <span class="badge bg-primary badge-number"><?php echo $newNotificationsCount; ?></span>
    </a>

    <!-- Notification Dropdown -->
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
    <li class="dropdown-header">
        You have <?php echo count($allNotifications); ?> new notification<?php echo (count($allNotifications) != 1) ? 's' : ''; ?>
        <a href="/iBalay.com/iBalay/all_notification.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>

<?php
// Display notifications
foreach ($allNotifications as $notification) {
    echo '<li class="notification-item">';
    if ($notification['notification_type'] == 'inquiry' || $notification['notification_type'] == 'reservation') {
        if ($notification['notification_type'] == 'inquiry') {
            $redirectURL = '/iBalay.com/iBalay/inquiries/inquiry_page.php?roomID=' . $notification['RoomID'];
        } else {
            $redirectURL = '/iBalay.com/iBalay/Reserved_Rooms/reserved_room.php?roomID=' . $notification['RoomID'];
        }
        echo '<a href="' . $redirectURL . '">';
        echo '<div>';
        if ($notification['notification_type'] == 'inquiry') {
            echo '<h4>Inquiry for Room ' . $notification['RoomNumber'] . '</h4>';
            echo '<p>New inquiry received</p>';
        } else {
            echo '<h4>Reservation for Room ' . $notification['RoomNumber'] . '</h4>';
            echo '<p>New reservation received</p>';
        }
        echo '<p>' . $notification['notification_date'] . '</p>';
        echo '</div>';
        echo '</a>';
    } elseif ($notification['notification_type'] == 'due_payment') {
        echo '<a href="/iBalay.com/iBalay/tenant_options/tenant_payments.php">';
        echo '<div>';
        echo '<h4>Due payment</h4>';
        echo '<p>Payment due on ' . $notification['notification_date'] . '</p>';
        echo '<p>Tenant name: ' . $notification['FirstName'] . ' ' . $notification['LastName'] . '</p>';
        echo '</div>';
        echo '</a>';
    }
    echo '</li>';
}
?>


    <li>
        <hr class="dropdown-divider">
    </li>
</ul>
</li>
<!-- end navbar -->

<!-- ==================================== for future updates =============================================================
    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number">3</span>
      </a>

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
          You have 3 new messages
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
            <div>
              <h4>Maria Hudson</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>4 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
            <div>
              <h4>Anna Nelson</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>6 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="message-item">
          <a href="#">
            <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
            <div>
              <h4>David Muldon</h4>
              <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
              <p>8 hrs. ago</p>
            </div>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="dropdown-footer">
          <a href="#">Show all messages</a>
        </li>

      </ul>

    </li> End Messages Nav 
     ================================================================= for futre updates end============================  -->

    <li class="nav-item dropdown pe-3">

    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
<img src="<?php echo '/iBalay.com/uploads/photos/' . basename($photoUrl); ?>" alt="Profile" class="rounded-circle">
    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $name; ?></span>
</a>

<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
    <li class="dropdown-header">
        <h6><?php echo $name; ?></h6>
        <span><?php echo $username; ?></span>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li>
        <a class="dropdown-item d-flex align-items-center" href="/iBalay.com/iBalay/users-profile.php">
            <i class="bi bi-person"></i>
            <span>My Profile</span>
        </a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li>
        <a class="dropdown-item d-flex align-items-center" href="/iBalay.com/iBalay/users-profile.php">
            <i class="bi bi-gear"></i>
            <span>Account Settings</span>
        </a>
    </li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li>
<a class="dropdown-item d-flex align-items-center" href="/iBalay.com/iBalay/logout_process.php">
  
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
    </a>
</li>

</ul>

    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
  
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/iBalay.com/iBalay/dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard | Home</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#room-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-truck-flatbed"></i><span>Rooms | Setting</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="room-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/iBalay.com/iBalay/Rooms_Settings/add-room.php">
              <i class="bi bi-circle"></i><span>Add Rooms</span>
            </a>
          </li>
          <li>
            <a href="/iBalay.com/iBalay/Rooms_Settings/my-rooms.php">
              <i class="bi bi-circle"></i><span>My Rooms</span>
            </a>
          </li>
          <li>
            <a href="/iBalay.com/iBalay/Rooms_Settings/room_information.php">
              <i class="bi bi-circle"></i><span>Room Informations</span>
            </a>
          </li>
          <li>
            <a href="/iBalay.com/iBalay/Rooms_Settings/update_room.php">
              <i class="bi bi-circle"></i><span>Update Rooms</span>
            </a>
          </li>
          <li>

        </ul>
      </li><!-- End Room Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reserved-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Reserved | Bookings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reserved-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/iBalay.com/iBalay/Reserved_Rooms/reserved_room.php">
              <i class="bi bi-circle"></i><span>Reserved Rooms | Approve</span>
            </a>
          </li>
        </ul>
      </li><!-- End Reserved Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tenant-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Boarders | Options</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tenant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/iBalay.com/iBalay/tenant_options/tenant_list.php">
              <i class="bi bi-circle"></i><span>Boarders Information</span>
            </a>
          </li>
          <li>
            <a href="/iBalay.com/iBalay/tenant_options/tenant_checkout.php">
              <i class="bi bi-circle"></i><span>checkout</span>
            </a>
          </li>
          <li>
            <a href="/iBalay.com/iBalay/tenant_options/tenant_payments.php">
              <i class="bi bi-circle"></i><span>Boarders Payments</span>
            </a>
          </li>
                    <li>
            <a href="/iBalay.com/iBalay/tenant_options/tenant_history.php">
              <i class="bi bi-circle"></i><span>Boarders History</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-heading">Other Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay.com/iBalay/users-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay.com/iBalay/inquiries/inquiry_page.php">
          <i class="bi bi-house-fill"></i>
          <span>Room Inquiries</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay.com/iBalay/bh_info.php">
          <i class="bi bi-book"></i>
          <span>UPDATE BH Information</span>
        </a>
      </li><!-- End Profile Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <script>
    // Function to update the notification count
    function updateNotificationCount() {
        // Fetch the total count of new notifications (inquiries and reservations)
        var totalCount = <?php echo count(getAllNotifications($ownerID, $conn)); ?>;
        
        // Update the count in the badge
        document.querySelector('.badge-number').textContent = totalCount;

        // You can also add additional logic here if needed
    }

    // Add an event listener for the notification icon
    document.getElementById('notification-icon').addEventListener('click', function () {
        // Call the function to update the notification count
        updateNotificationCount();
    });

    // Call the function on page load to set the initial count
    updateNotificationCount();

    document.getElementById('notification-icon').addEventListener('click', function () {
        // When the icon is clicked, update the count to 0
        document.querySelector('.badge-number').textContent = '0';
    });
</script>
