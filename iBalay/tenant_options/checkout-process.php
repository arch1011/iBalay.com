<?php
include './../connect_db/connection.php';

// Check if the tenantID is set and is a valid integer
if (isset($_POST['tenantID']) && is_numeric($_POST['tenantID'])) {
    $tenantID = $_POST['tenantID'];

    // Fetch the OwnerID and RoomID for the given TenantID
    $tenantInfoQuery = "SELECT OwnerID, RoomID FROM tenant WHERE TenantID = $tenantID";
    $tenantInfoResult = mysqli_query($conn, $tenantInfoQuery);

    if ($tenantInfoRow = mysqli_fetch_assoc($tenantInfoResult)) {
        $ownerID = $tenantInfoRow['OwnerID'];
        $roomID = $tenantInfoRow['RoomID'];

        // Delete payment records associated with the given TenantID
        $deletePaymentQuery = "DELETE FROM payment WHERE TenantID = $tenantID";
        $deletePaymentResult = mysqli_query($conn, $deletePaymentQuery);

        if ($deletePaymentResult) {
            // Update the RoomID to NULL and checked_out to 1
            $updateTenantQuery = "UPDATE tenant SET RoomID = NULL, checked_out = 1, OwnerID = NULL WHERE TenantID = $tenantID";
            $updateTenantResult = mysqli_query($conn, $updateTenantQuery);

            if ($updateTenantResult) {
                // Increment the capacity in the room table
                $incrementCapacityQuery = "UPDATE room SET Capacity = Capacity + 1 WHERE RoomID = $roomID";
                $incrementCapacityResult = mysqli_query($conn, $incrementCapacityQuery);

                if ($incrementCapacityResult) {
                    // Fetch the current owner_history value
                    $fetchOwnerHistoryQuery = "SELECT owner_history FROM tenant WHERE TenantID = $tenantID";
                    $fetchOwnerHistoryResult = mysqli_query($conn, $fetchOwnerHistoryQuery);
                    $currentOwnerHistory = mysqli_fetch_assoc($fetchOwnerHistoryResult)['owner_history'];

                    // Append the current owner's ID to the owner_history
                    $updatedOwnerHistory = $currentOwnerHistory ? $currentOwnerHistory . ',' . $ownerID : $ownerID;

                    // Update the owner_history column
                    $updateOwnerHistoryQuery = "UPDATE tenant SET owner_history = '$updatedOwnerHistory' WHERE TenantID = $tenantID";
                    $updateOwnerHistoryResult = mysqli_query($conn, $updateOwnerHistoryQuery);

                    if ($updateOwnerHistoryResult) {
                        echo "Checkout process completed successfully.";
                    } else {
                        echo "Error updating owner history: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error incrementing room capacity: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating tenant information: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting payment records: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching tenant information.";
    }
} else {
    echo "Invalid tenantID.";
}
?>
