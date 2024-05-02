<?php require '../side-navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Owner / Room Inquiries</title>

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="./.././assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./.././assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./.././assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="./.././assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="./.././assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="./.././assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="./.././assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="./.././assets/css/style.css" rel="stylesheet">
    <style>
        @media (max-width: 767px) {
            .message-text {
                white-space: normal !important;
                overflow: visible !important;
                text-overflow: initial !important;
            }
        }
    </style>
</head>

<body>
    
    <?php
    function getOwnerReply($inquiryID, $conn)
    {
        $replyQuery = "SELECT ReplyMessage FROM reply WHERE InquiryID = $inquiryID";
        $replyResult = $conn->query($replyQuery);

        if ($replyResult->num_rows > 0) {
            $replyRow = $replyResult->fetch_assoc();
            return $replyRow['ReplyMessage'];
        } else {
            return '';
        }
    }

    if (isset($_SESSION['owner_id'])) {
        $OwnerID = $_SESSION['owner_id'];
    } else {
        header("Location: /path/to/login.php");
        exit();
    }

    include '../connect_db/connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT InquiryID, RoomID, message FROM inquiry WHERE OwnerID = $OwnerID";
    
    $result = $conn->query($sql);

    $inquiries = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                $roomID = $row['RoomID'];
                    if (!isset($inquiries[$roomID])) {
                        $inquiries[$roomID] = array();
                    }
                    $inquiries[$roomID][] = $row;
            }
    }

    $result->close();
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Room Inquiries</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/iBalay.com/iBalay/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Inquiry</li>
                    <li class="breadcrumb-item active">Messages</li>
                </ol>
            </nav>
        </div>

        <section class="container-fluid">
            <div class="row">
                <?php foreach ($inquiries as $roomID => $roomInquiries) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Room serial ID: <?php echo $roomID; ?></h5>
                                    <?php echo $RoomNumber; ?>
                            </div>
                            <div class="card-body">
                                <?php foreach ($roomInquiries as $inquiry) : ?>
                                        <p class="card-text message-text">
                                            Tenant Message: <?php echo $inquiry['message']; ?>
                                        </p>
                                        <?php
                                                $ownerReply = getOwnerReply($inquiry['InquiryID'], $conn); // Pass $conn as an argument
                                                    if ($ownerReply) {
                                                        echo '<p class="card-text message-text">Owner Reply: ' . $ownerReply . '</p>';
                                                    } else {
                                                        echo '<p class="card-text message-text">Owner has not replied yet.</p>';
                                                }
                                         ?>
                         <?php endforeach; ?>

                                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inquiryModal<?php echo $roomID; ?>">Reply</a>
                                <a href="delete_process.php?inquiryID=<?php echo $inquiry['InquiryID']; ?>" class="btn btn-danger">Delete</a>
                                
                                            <!-- MODAL INI -->
                                            <div class="modal fade" id="inquiryModal<?php echo $roomID; ?>" tabindex="-1" role="dialog" aria-labelledby="inquiryModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Room #<?php echo $roomID; ?> - Inquiry</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="reply_process.php" method="post">
                                                                <input type="hidden" name="inquiryID" value="<?php echo $inquiry['InquiryID']; ?>">

                                                                <div class="mb-3">
                                                                    <label for="replyMessage" class="form-label">Reply Message:</label>
                                                                    <textarea class="form-control" id="replyMessage" name="replyMessage" rows="3" required></textarea>
                                                                </div>

                                                                <button type="submit" class="btn btn-primary">Send Reply</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                    <?php
                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="./../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="./../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="./../assets/vendor/echarts/echarts.min.js"></script>
    <script src="./../assets/vendor/quill/quill.min.js"></script>
    <script src="./../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="./../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="./../assets/vendor/php-email-form/validate.js"></script>

    <script src="./../assets/js/main.js"></script>
</body>

</html>
