<?php
include 'connect_db/connection.php';

if (isset($_GET['owner_id'])) {
    $ownerId = $_GET['owner_id'];

    // Fetch owner details from the database based on the selected owner_id
    $sqlOwnerDetails = "SELECT * FROM owners WHERE owner_id = $ownerId";
    $resultOwnerDetails = mysqli_query($conn, $sqlOwnerDetails);

    if ($resultOwnerDetails && mysqli_num_rows($resultOwnerDetails) > 0) {
        $ownerDetails = mysqli_fetch_assoc($resultOwnerDetails);

        // Fetch bh_information details
        $sqlBHInfo = "SELECT * FROM bh_information WHERE owner_id = $ownerId";
        $resultBHInfo = mysqli_query($conn, $sqlBHInfo);

        // Fetch tenants details
        $sqlTenants = "SELECT * FROM tenant WHERE OwnerID = $ownerId";
        $resultTenants = mysqli_query($conn, $sqlTenants);

        // Create an Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report.xlsx"');
        header('Cache-Control: max-age=0');

        // Initialize PhpSpreadsheet
        require 'vendor/autoload.php';
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Styles for the header row
        $styleHeader = [
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '088F8F'], 'endColor' => ['rgb' => '0000FF']]
        ];

        // Styles for the data rows
        $styleData = [
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ADD8E6'], 'endColor' => ['rgb' => 'ADD8E6']]
        ];

        // Styles for the merged cells
        $styleMerge = [
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '088F8F'], 'endColor' => ['rgb' => '0000FF']]
        ];

        // Add merged cells
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Boarding House Report');
        $spreadsheet->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleMerge);

        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Owner Name:');
        $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($styleData);
        $spreadsheet->getActiveSheet()->setCellValue('B2', $ownerDetails['name']);

        // Add bh_information details to the Excel file
        $spreadsheet->getActiveSheet()->mergeCells('A4:B4');
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'bh_information Table');
        $spreadsheet->getActiveSheet()->getStyle('A4:B4')->applyFromArray($styleHeader);

        $row = 5;
        if ($resultBHInfo && mysqli_num_rows($resultBHInfo) > 0) {
            while ($rowBHInfo = mysqli_fetch_assoc($resultBHInfo)) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'Complete Address:');
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->applyFromArray($styleData);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $rowBHInfo['complete_address']);
                $spreadsheet->getActiveSheet()->getStyle('B' . $row)->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 1), 'Business Permit:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 1), $rowBHInfo['business_permit']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 1))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 2), 'Monthly Payment Rate:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 2))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 2), $rowBHInfo['monthly_payment_rate']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 2))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), 'Number of Kitchen:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 3), $rowBHInfo['number_of_kitchen']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 3))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 4), 'Number of Living Room:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 4))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 4), $rowBHInfo['number_of_living_room']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 4))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 5), 'Number of Students/Tenants:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 5))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 5), $rowBHInfo['number_of_students_tenants']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 5))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 6), 'Number of CR:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 6))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 6), $rowBHInfo['number_of_cr']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 6))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 7), 'Number of Beds:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 7))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 7), $rowBHInfo['number_of_beds']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 7))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 8), 'Number of Rooms:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 8))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 8), $rowBHInfo['number_of_rooms']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 8))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 9), 'BH Max Capacity:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 9))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 9), $rowBHInfo['bh_max_capacity']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 9))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 10), 'Gender Allowed:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 10))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 10), $rowBHInfo['gender_allowed']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 10))->applyFromArray($styleData);
        
                $row += 11; // Increment by 11 for the next set of data
            }
        } else {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $row . ':B' . $row);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'No data available');
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':B' . $row)->applyFromArray($styleData);
        }
        

        // Add tenants details to the Excel file
        $spreadsheet->getActiveSheet()->mergeCells('A' . ($row + 2) . ':B' . ($row + 2));
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 2), 'Residing Tenants');
        $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 2) . ':B' . ($row + 2))->applyFromArray($styleHeader);

        $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), 'Name');
        $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->applyFromArray($styleHeader);

        $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 3), 'Contact Number');
        $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 3))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 3))->applyFromArray($styleHeader);

        $row += 4;
        if ($resultTenants && mysqli_num_rows($resultTenants) > 0) {
            while ($rowTenant = mysqli_fetch_assoc($resultTenants)) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $rowTenant['FirstName'] . ' ' . $rowTenant['LastName']);
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->applyFromArray($styleData);

                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $rowTenant['PhoneNumber']);
                $spreadsheet->getActiveSheet()->getStyle('B' . $row)->applyFromArray($styleData);

                $row++;
            }
        } else {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $row . ':B' . $row);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'No tenants');
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':B' . $row)->applyFromArray($styleData);
        }

        // Add end report
        $spreadsheet->getActiveSheet()->mergeCells('A' . ($row + 2) . ':B' . ($row + 2));
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 2), 'End Report');
        $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 2) . ':B' . ($row + 2))->applyFromArray($styleMerge);

        // Add downloaded date
        $spreadsheet->getActiveSheet()->mergeCells('A' . ($row + 3));
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), 'Downloaded Date:');
        $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->applyFromArray($styleHeader);

        $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 3), date('Y-m-d H:i:s')); // You can customize the date format if needed
        $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 3))->applyFromArray($styleData);

// Create 'exports' directory if it doesn't exist
$exportDirectory = __DIR__ . '/exports';
if (!is_dir($exportDirectory)) {
    mkdir($exportDirectory, 0777, true);  // Change the permission as needed
}

// Save Excel file to the 'exports' directory
$filePath = $exportDirectory . '/report.xlsx';
$writer->save($filePath);

// Provide download link
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');
readfile($filePath);

// Delete the file after download
unlink($filePath);
exit;



    } else {
        echo 'Error fetching owner details.';
    }

    // Free the result sets
    mysqli_free_result($resultOwnerDetails);
    mysqli_free_result($resultBHInfo);
    mysqli_free_result($resultTenants);
}

// Close the database connection
mysqli_close($conn);
?>
